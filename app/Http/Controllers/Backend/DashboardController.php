<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang; // Tambahkan model Barang
use Carbon\Carbon;

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
        // --- Data untuk 4 Kartu Statistik (Sudah ada) ---
        $today = Carbon::today();
        $totalPenjualanHariIni = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_harga');
        $totalPengeluaranHariIni = PenjualanDetail::whereHas('penjualan', function ($query) use ($today) {
            $query->whereDate('tanggal_penjualan', $today);
        })->with('barang:id,harga_beli')->get()->sum(fn($detail) => $detail->qty * (optional($detail->barang)->harga_beli ?? 0));
        $produkTerjualHariIni = PenjualanDetail::whereHas('penjualan', function ($query) use ($today) {
            $query->whereDate('tanggal_penjualan', $today);
        })->sum('qty');
        $labaBersihHariIni = $totalPenjualanHariIni - $totalPengeluaranHariIni;
        $tanggalHariIni = $today->translatedFormat('d F Y');

        // --- DATA BARU ---

        // 1. Data untuk Chart Tren Penjualan (7 Hari Terakhir)
        $tanggalMulai = Carbon::now()->subDays(6)->startOfDay();
        $tanggalSelesai = Carbon::now()->endOfDay();

        $penjualanPerHari = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

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
            'totalPengeluaranHariIni',
            'produkTerjualHariIni',
            'labaBersihHariIni',
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
