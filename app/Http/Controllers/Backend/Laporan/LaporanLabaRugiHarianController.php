<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PenjualanDetail;
use App\Models\BarangMasukDetail;
use App\Models\PengeluaranDetail;
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanLabaRugiHarianController extends Controller
{
    /**
     * Tampilkan halaman index utama.
     * MODIFIKASI: Langsung memuat data untuk hari ini saat halaman dibuka.
     */
    public function index(Request $request)
    {
        // 1. Tentukan tanggal hari ini
        $tanggalHariIni = Carbon::now()->startOfDay();

        // 2. Ambil data untuk hari ini menggunakan fungsi private
        $data = $this->_getLaporanData($tanggalHariIni);

        // 3. Render partial HTML-nya
        $laporanHtml = view('backend.laporan.laporan_laba_rugi_harian._partials.laporan_content', $data)->render();

        // 4. Kirim HTML yang sudah jadi ke view utama
        return view('backend.laporan.laporan_laba_rugi_harian.index', [
            'laporanHtml' => $laporanHtml
        ]);
    }

    /**
     * [AJAX] Ambil data detail untuk tanggal yang dipilih di datepicker
     */
    public function getLaporanHarianDetail(Request $request)
    {
        $request->validate([
            'filter_tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggal = Carbon::parse($request->filter_tanggal)->startOfDay();

        // Panggil fungsi private untuk mengambil data
        $data = $this->_getLaporanData($tanggal);

        // Render file partial view
        $html = view('backend.laporan.laporan_laba_rugi_harian._partials.laporan_content', $data)->render();

        // Kembalikan HTML sebagai response JSON
        return response()->json(['html' => $html]);
    }

    /**
     * [PDF] Export PDF untuk laporan detail harian
     */
    public function exportLabaRugiPdf(Request $request)
    {
        $request->validate([
            'filter_tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggal = Carbon::parse($request->filter_tanggal)->startOfDay();
        $paperSize = $request->ukuran_kertas ?? 'A4';
        $orientation = $request->orientasi_kertas ?? 'portrait';

        // Panggil fungsi private untuk mengambil data
        $data = $this->_getLaporanData($tanggal);

        // Tambahkan data khusus untuk PDF
        $data['namaUser'] = Auth::user()->name;
        $data['tanggalCetak'] = Carbon::now();

        // Load view PDF
        $pdf = Pdf::loadView('backend.laporan.laporan_laba_rugi_harian.laba_rugi_harian_pdf', $data)
            ->setPaper($paperSize, $orientation);

        return $pdf->stream('laporan-laba-rugi-harian-' . $tanggal->format('Y-m-d') . '.pdf');
    }

    /**
     * FUNGSI PRIVATE BARU: (Prinsip DRY - Don't Repeat Yourself)
     * Satu fungsi terpusat untuk mengambil dan mengkalkulasi semua data laporan.
     */
    private function _getLaporanData(Carbon $tanggal)
    {
        // 1. Ambil Detail Penjualan
        $detail_penjualan = PenjualanDetail::with('barang:id,nama,kode_barang')
            ->whereHas('penjualan', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_penjualan', $tanggal);
            })
            ->get();

        // 2. Ambil Detail Pembelian
        $detail_pembelian = BarangMasukDetail::with('barang:id,nama,kode_barang', 'barangMasuk:id,kode_transaksi')
            ->whereHas('barangMasuk', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_masuk', $tanggal);
            })
            ->get();

        // 3. Ambil Detail Pengeluaran
        $detail_pengeluaran = PengeluaranDetail::with('kategori:id,nama')
            ->whereHas('pengeluaran', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            })
            ->get();

        // 4. Hitung Total
        $total_penjualan = $detail_penjualan->sum('subtotal');
        $total_hpp_penjualan = $detail_penjualan->sum(function ($item) {
            // Pastikan harga_beli ada untuk menghindari error
            return ($item->harga_beli ?? 0) * $item->qty;
        });
        $total_profit_kotor = $total_penjualan - $total_hpp_penjualan;
        $total_pembelian = $detail_pembelian->sum('subtotal');
        $total_pengeluaran = $detail_pengeluaran->sum('jumlah');
        $laba_rugi = $total_penjualan - $total_pembelian - $total_pengeluaran;

        // 5. Kembalikan array data yang siap di-render
        return [
            'tanggal' => $tanggal,
            'total_penjualan' => $total_penjualan,
            'total_pembelian' => $total_pembelian,
            'total_pengeluaran' => $total_pengeluaran,
            'laba_rugi' => $laba_rugi,
            'total_profit_kotor' => $total_profit_kotor,
            'detail_penjualan' => $detail_penjualan,
            'detail_pembelian' => $detail_pembelian,
            'detail_pengeluaran' => $detail_pengeluaran,
        ];
    }

    // ... (fungsi terbilang dan penyebut biarkan saja ada di bawah) ...
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
