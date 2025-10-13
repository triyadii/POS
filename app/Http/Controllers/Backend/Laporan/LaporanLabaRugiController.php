<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanLabaRugiController extends Controller
{
    public function index(Request $request)
    {
        // Ganti path view jika berbeda, sesuaikan dengan error sebelumnya
        return view('backend.laporan.laporan_laba_rugi.index');
    }

    /**
     * Method utama untuk mengambil data dan dikirim sebagai JSON untuk chart
     */
    public function getProfitLossData(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        $data = $this->_calculateProfitLossData($start, $end);

        return response()->json($data);
    }

    /**
     * Method untuk export data ke PDF
     */
    public function exportLabaRugiPdf(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        $periode = $this->_calculateProfitLossData($start, $end);

        // Ukuran dan orientasi
        $paperSize = $request->ukuran_kertas ?? 'A4';
        $orientation = $request->orientasi_kertas ?? 'portrait';

        // Anda perlu membuat view blade baru untuk tampilan PDF
        // contoh: resources/views/backend/laporan/laporan-laba-rugi/laba_rugi_pdf.blade.php
        $pdf = Pdf::loadView('backend.laporan.laporan_laba_rugi.laba_rugi_pdf', [
            'periode' => $periode,
            'start' => $start->format('d-m-Y'),
            'end' => $end->format('d-m-Y')
        ])->setPaper($paperSize, $orientation);

        return $pdf->stream('laporan-laba-rugi.pdf');
    }

    /**
     * Private method untuk kalkulasi data agar tidak duplikasi kode (DRY Principle)
     */
    private function _calculateProfitLossData(Carbon $start, Carbon $end)
    {
        // 1. Ambil total PENDAPATAN dari tabel penjualan
        $pendapatan = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        // 2. Ambil total PENGELUARAN (HPP/COGS)
        // SUM dari (qty * harga_beli_barang) pada setiap item penjualan
        $pengeluaran = PenjualanDetail::select(
            DB::raw('DATE(penjualan.tanggal_penjualan) as tanggal'),
            DB::raw('SUM(penjualan_detail.qty * barang.harga_beli) as total')
        )
            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
            ->join('barang', 'barang.id', '=', 'penjualan_detail.barang_id')
            ->whereBetween('penjualan.tanggal_penjualan', [$start, $end])
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');


        // 3. Gabungkan data dalam satu periode rentang tanggal
        $periode = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $tanggalStr = $date->format('Y-m-d');

            $totalPendapatan = $pendapatan[$tanggalStr] ?? 0;
            $totalPengeluaran = $pengeluaran[$tanggalStr] ?? 0;

            $periode[] = [
                'tanggal' => $tanggalStr,
                'total_pendapatan' => $totalPendapatan,
                'pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $totalPendapatan - $totalPengeluaran
            ];
        }

        return $periode;
    }
}
