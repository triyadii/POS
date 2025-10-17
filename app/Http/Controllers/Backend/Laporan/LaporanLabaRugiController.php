<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\BarangMasuk;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanLabaRugiController extends Controller
{

    public function index(Request $request)
    {
        return view('backend.laporan.laporan_laba_rugi.index');
    }

    public function getProfitLossData(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();
        $data = $this->_calculateProfitLossData($start, $end);
        return response()->json($data);
    }

    public function exportLabaRugiPdf(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();
        $periode = $this->_calculateProfitLossData($start, $end);
        $paperSize = $request->ukuran_kertas ?? 'A4';
        $orientation = $request->orientasi_kertas ?? 'portrait';

        $pdf = Pdf::loadView('backend.laporan.laporan_laba_rugi.laba_rugi_pdf', [
            'periode' => $periode,
            'start' => $start,
            'end' => $end,
            'namaUser' => Auth::user()->name,
            'tanggalCetak' => Carbon::now()
        ])->setPaper($paperSize, $orientation);
        return $pdf->stream('laporan-laba-rugi.pdf');
    }

    /**
     * FUNGSI BARU: Mengambil data detail untuk modal.
     */
    public function getDetailData(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'tipe' => 'required|in:pendapatan,pembelian,pengeluaran',
        ]);

        $tanggal = Carbon::parse($request->tanggal);
        $tipe = $request->tipe;
        $data = [];

        switch ($tipe) {
            case 'pendapatan':
                $data = PenjualanDetail::with('barang:id,nama,kode_barang')
                    ->whereHas('penjualan', function ($q) use ($tanggal) {
                        $q->whereDate('tanggal_penjualan', $tanggal);
                    })->get();
                break;
            case 'pembelian':
                $data = BarangMasuk::with('detail.barang:id,nama,kode_barang', 'supplier:id,nama')
                    ->whereDate('tanggal_masuk', $tanggal)
                    ->get();
                break;
            case 'pengeluaran':
                $data = Pengeluaran::with('details.kategori:id,nama')
                    ->whereDate('tanggal', $tanggal)
                    ->get();
                break;
        }
        return response()->json($data);
    }

    /**
     * Private method dirombak total untuk mengambil data dari 3 sumber.
     */
    private function _calculateProfitLossData(Carbon $start, Carbon $end)
    {
        // 1. Ambil PENDAPATAN dari tabel penjualan
        $pendapatan = Penjualan::select(DB::raw('DATE(tanggal_penjualan) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->groupBy('tanggal')->pluck('total', 'tanggal');

        // 2. Ambil PEMBELIAN BARANG (HPP dari barang masuk)
        $pembelianBarang = BarangMasuk::select(DB::raw('DATE(tanggal_masuk) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->whereBetween('tanggal_masuk', [$start, $end])
            ->groupBy('tanggal')->pluck('total', 'tanggal');

        // 3. Ambil PENGELUARAN OPERASIONAL dari tabel pengeluaran
        $pengeluaranOperasional = Pengeluaran::select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(total) as total'))
            ->whereBetween('tanggal', [$start, $end])
            ->groupBy('tanggal')->pluck('total', 'tanggal');

        // 4. Gabungkan semua data
        $periode = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $tanggalStr = $date->format('Y-m-d');
            $totalPendapatan = $pendapatan[$tanggalStr] ?? 0;
            $totalPembelian = $pembelianBarang[$tanggalStr] ?? 0;
            $totalPengeluaran = $pengeluaranOperasional[$tanggalStr] ?? 0;

            $periode[] = [
                'tanggal' => $tanggalStr,
                'total_pendapatan' => $totalPendapatan,
                'pembelian_barang' => $totalPembelian,
                'pengeluaran_operasional' => $totalPengeluaran,
                'laba_bersih' => $totalPendapatan - $totalPembelian - $totalPengeluaran
            ];
        }
        return $periode;
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
