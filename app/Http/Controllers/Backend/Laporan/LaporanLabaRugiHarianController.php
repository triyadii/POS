<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PenjualanDetail;
use App\Models\BarangMasukDetail; // Kita pakai detail
use App\Models\PengeluaranDetail; // Kita pakai detail
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanLabaRugiHarianController extends Controller
{
    /**
     * Tampilkan halaman index utama
     */
    public function index(Request $request)
    {
        return view('backend.laporan.laporan_laba_rugi_harian.index');
    }

    /**
     * [BARU] Ambil data detail untuk laporan harian via AJAX
     */
    public function getLaporanHarianDetail(Request $request)
    {
        $request->validate([
            'filter_tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggal = Carbon::parse($request->filter_tanggal)->startOfDay();

        // 1. Ambil Detail Penjualan (Pendapatan & Komparasi Profit)
        $detail_penjualan = PenjualanDetail::with('barang:id,nama,kode_barang')
            ->whereHas('penjualan', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_penjualan', $tanggal);
            })
            ->get();

        // 2. Ambil Detail Pembelian (Barang Masuk)
        $detail_pembelian = BarangMasukDetail::with('barang:id,nama,kode_barang', 'barangMasuk:id,kode_transaksi')
            ->whereHas('barangMasuk', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_masuk', $tanggal);
            })
            ->get();

        // 3. Ambil Detail Pengeluaran (Biaya Operasional)
        $detail_pengeluaran = PengeluaranDetail::with('kategori:id,nama')
            ->whereHas('pengeluaran', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            })
            ->get();

        // 4. Hitung Total
        // Total Penjualan (Omzet)
        $total_penjualan = $detail_penjualan->sum('subtotal');

        // Total Modal (COGS) dari barang yang terjual
        $total_hpp_penjualan = $detail_penjualan->sum(function ($item) {
            return $item->harga_beli * $item->qty;
        });

        // Total Profit Kotor (Margin Penjualan)
        $total_profit_kotor = $total_penjualan - $total_hpp_penjualan;

        // Total Pembelian Hari Itu
        $total_pembelian = $detail_pembelian->sum('subtotal');

        // Total Pengeluaran Hari Itu
        $total_pengeluaran = $detail_pengeluaran->sum('jumlah');

        // Laba Rugi Bersih (Sesuai formula Anda: Penjualan - Pembelian - Pengeluaran)
        $laba_rugi = $total_penjualan - $total_pembelian - $total_pengeluaran;

        return response()->json([
            // Data untuk Statistik Box
            'total_penjualan' => $total_penjualan,
            'total_pembelian' => $total_pembelian,
            'total_pengeluaran' => $total_pengeluaran,
            'laba_rugi' => $laba_rugi,
            'total_profit_kotor' => $total_profit_kotor, // Tambahan untuk komparasi

            // Data untuk Tabel Detail
            'detail_penjualan' => $detail_penjualan,
            'detail_pembelian' => $detail_pembelian,
            'detail_pengeluaran' => $detail_pengeluaran,
        ]);
    }

    /**
     * [MODIFIKASI] Export PDF untuk laporan detail harian
     */
    public function exportLabaRugiPdf(Request $request)
    {
        $request->validate([
            'filter_tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggal = Carbon::parse($request->filter_tanggal)->startOfDay();
        $paperSize = $request->ukuran_kertas ?? 'A4';
        $orientation = $request->orientasi_kertas ?? 'portrait';

        // --- Mengambil data (logika sama persis dengan getLaporanHarianDetail) ---
        $detail_penjualan = PenjualanDetail::with('barang:id,nama,kode_barang')
            ->whereHas('penjualan', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_penjualan', $tanggal);
            })
            ->get();

        $detail_pembelian = BarangMasukDetail::with('barang:id,nama,kode_barang', 'barangMasuk:id,kode_transaksi')
            ->whereHas('barangMasuk', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_masuk', $tanggal);
            })
            ->get();

        $detail_pengeluaran = PengeluaranDetail::with('kategori:id,nama')
            ->whereHas('pengeluaran', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            })
            ->get();

        // --- Kalkulasi Total (logika sama persis) ---
        $total_penjualan = $detail_penjualan->sum('subtotal');
        $total_hpp_penjualan = $detail_penjualan->sum(function ($item) {
            return $item->harga_beli * $item->qty;
        });
        $total_profit_kotor = $total_penjualan - $total_hpp_penjualan;
        $total_pembelian = $detail_pembelian->sum('subtotal');
        $total_pengeluaran = $detail_pengeluaran->sum('jumlah');
        $laba_rugi = $total_penjualan - $total_pembelian - $total_pengeluaran;
        // --- End Kalkulasi ---

        $data = [
            'tanggal' => $tanggal,
            'total_penjualan' => $total_penjualan,
            'total_pembelian' => $total_pembelian,
            'total_pengeluaran' => $total_pengeluaran,
            'laba_rugi' => $laba_rugi,
            'total_profit_kotor' => $total_profit_kotor,
            'detail_penjualan' => $detail_penjualan,
            'detail_pembelian' => $detail_pembelian,
            'detail_pengeluaran' => $detail_pengeluaran,
            'namaUser' => Auth::user()->name,
            'tanggalCetak' => Carbon::now()
        ];

        // Kita akan menggunakan view PDF baru: 'laba_rugi_harian_pdf'
        $pdf = Pdf::loadView('backend.laporan.laporan_laba_rugi_harian.laba_rugi_harian_pdf', $data)
            ->setPaper($paperSize, $orientation);

        return $pdf->stream('laporan-laba-rugi-harian-' . $tanggal->format('Y-m-d') . '.pdf');
    }

    private function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return ucwords($hasil) . " Rupiah";
    }

    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut($nilai % 1000000000);
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " triliun" . $this->penyebut($nilai % 1000000000000);
        }
        return $temp;
    }
}
