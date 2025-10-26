<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use Carbon\Carbon;

// --- Impor Model untuk Pembelian dan Pengeluaran ---
use App\Models\BarangMasukDetail;
use App\Models\PengeluaranDetail;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with dynamic data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      // --- Data untuk 4 Kartu Statistik ---
      $today = Carbon::today();

      // ===================================
      // LOGIKA KALKULASI KARTU STATISTIK
      // ===================================
      
      // 1. Total Penjualan (Gross Sales / Omzet) - Sesuai Laba Rugi
    //   $totalPenjualanHariIni = PenjualanDetail::whereHas('penjualan', function ($query) use ($today) {
    //       $query->whereDate('tanggal_penjualan', $today);
    //   })->sum('subtotal');

    $detailPenjualanHariIni = PenjualanDetail::whereHas('penjualan', function ($query) use ($today) {
        $query->whereDate('tanggal_penjualan', $today);
    })->with('barang:id,harga_beli')->get(); // Eager load harga beli barang
    
    $totalPenjualanHariIni = $detailPenjualanHariIni->sum('subtotal');
      
      // 2. Total Pembelian (Stok Masuk) - Sesuai Laba Rugi
    //   $totalPembelianHariIni = BarangMasukDetail::whereHas('barangMasuk', function ($q) use ($today) {
    //       $q->whereDate('tanggal_masuk', $today);
    //   })->sum('subtotal');

    $totalHppHariIni = $detailPenjualanHariIni->sum(function ($detail) {
        return $detail->qty * (optional($detail->barang)->harga_beli ?? 0);
    });

    //   // 3. Total Pengeluaran (Biaya Operasional) - Sesuai Laba Rugi
    //   $totalPengeluaranHariIni = PengeluaranDetail::whereHas('pengeluaran', function ($q) use ($today) {
    //       $q->whereDate('tanggal', $today);
    //   })->sum('jumlah');
      
    //   // 4. Laba / Rugi - Sesuai Laba Rugi
    //   $labaRugiHariIni = $totalPenjualanHariIni - $totalPembelianHariIni - $totalPengeluaranHariIni;

    $totalPengeluaranHariIni = PengeluaranDetail::whereHas('pengeluaran', function ($q) use ($today) {
        $q->whereDate('tanggal', $today);
    })->sum('jumlah');
    
    // 4. Laba / Rugi - Tetap Penjualan Kotor - Pembelian Stok - Pengeluaran (Sesuai Laporan Laba Rugi)
    //    Jika Anda ingin Laba Kotor (Penjualan - HPP), gunakan: $labaRugiHariIni = $totalPenjualanHariIni - $totalHppHariIni;
    //    Tapi kita ikuti Laporan Laba Rugi untuk konsistensi kartu "Laba/Rugi":
    $totalPembelianStokHariIni = BarangMasukDetail::whereHas('barangMasuk', function ($q) use ($today) {
        $q->whereDate('tanggal_masuk', $today);
    })->sum('subtotal'); // Ini masih dibutuhkan untuk kalkulasi Laba/Rugi Harian
    $labaRugiHariIni = $totalPenjualanHariIni - $totalHppHariIni - $totalPengeluaranHariIni;
      
      // ===================================
      // AKHIR LOGIKA KARTU STATISTIK
      // ===================================

      $tanggalHariIni = $today->translatedFormat('d F Y');

        // --- DATA BARU ---

        // ===================================
        // LOGIKA CHART (Gross Sales)
        // ===================================

        // 1. Data untuk Chart Tren Penjualan (7 Hari Terakhir)
        $tanggalMulai = Carbon::now()->subDays(6)->startOfDay();
        $tanggalSelesai = Carbon::now()->endOfDay();

        // Ubah query untuk mengambil dari PenjualanDetail (Gross Sales)
        $penjualanPerHari = PenjualanDetail::select(
            DB::raw('DATE(created_at) as tanggal'), // Asumsi tanggal di detail sama dgn penjualan
            DB::raw('SUM(subtotal) as total')
        )
            ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        // ===================================
        // AKHIR LOGIKA CHART
        // ===================================

        $trenPenjualan = [];
        for ($date = $tanggalMulai->copy(); $date->lte($tanggalSelesai); $date->addDay()) {
            $tanggalStr = $date->format('Y-m-d');
            $trenPenjualan[] = [
                'tanggal' => $date->translatedFormat('d M'),
                'total' => $penjualanPerHari[$tanggalStr] ?? 0
            ];
        }

        // 2. Data untuk Notifikasi Stok Kritis (Stok <= 10)
        $stokKritis = Barang::with('brand:id,nama')
            ->where('stok', '<=', 10)
            ->orderBy('stok', 'asc')
            ->limit(5) // Ambil 5 item paling kritis
            ->get();

        // Kirim semua data ke view
        return view('backend.dashboard.index', compact(
            'totalPenjualanHariIni',
            // 'totalPembelianHariIni',
            'totalHppHariIni',
            'totalPengeluaranHariIni',
            'labaRugiHariIni',
            'tanggalHariIni',
            'trenPenjualan',
            'stokKritis'
        ));
    }

    /**
     * Mengambil data Log Activities untuk widget.
     */
    public function getLogActivities()
    {
        $activities = Activity::with('causer')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $monthlyActivityCount = Activity::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return response()->json([
            'activities' => $activities,
            'monthly_count' => $monthlyActivityCount
        ]);
    }
}