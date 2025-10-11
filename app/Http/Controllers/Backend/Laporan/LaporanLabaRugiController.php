<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Auth;
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
        // $start = Carbon::parse($request->filter_tanggal_start);
        // $end = Carbon::parse($request->filter_tanggal_end);

        // // Ambil pendapatan dari penjualan_detail
        // $penjualan = PenjualanDetail::selectRaw('penjualan.tanggal, SUM(penjualan_detail.subtotal) as total')
        //     ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
        //     ->whereBetween('penjualan.tanggal', [$start, $end])
        //     ->groupBy('penjualan.tanggal')
        //     ->pluck('total', 'penjualan.tanggal');

        // // Ambil pendapatan dari tiket masuk
        // $tiket = DB::table('tiket_masuk')
        //     ->selectRaw('tanggal, SUM(harga) as total')
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->groupBy('tanggal')
        //     ->pluck('total', 'tanggal');

        // // Ambil pengeluaran
        // $pengeluaran = DB::table('pengeluaran')
        //     ->selectRaw('tanggal, SUM(harga) as total')
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->groupBy('tanggal')
        //     ->pluck('total', 'tanggal');

        // // Siapkan array tanggal
        // $periode = [];
        // for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        //     $tanggalStr = $date->format('Y-m-d');

        //     $pendapatanPenjualan = $penjualan[$tanggalStr] ?? 0;
        //     $pendapatanTiket = $tiket[$tanggalStr] ?? 0;
        //     $totalPendapatan = $pendapatanPenjualan + $pendapatanTiket;

        //     $totalPengeluaran = $pengeluaran[$tanggalStr] ?? 0;

        //     $periode[] = [
        //         'tanggal' => $tanggalStr,
        //         'pendapatan_penjualan' => $pendapatanPenjualan,
        //         'pendapatan_tiket' => $pendapatanTiket,
        //         'total_pendapatan' => $totalPendapatan,
        //         'pengeluaran' => $totalPengeluaran,
        //         'laba_bersih' => $totalPendapatan - $totalPengeluaran
        //     ];
        // }

        // return response()->json($periode);
    }



    public function exportLabaRugiPdf(Request $request)
    {
        // $start = Carbon::parse($request->filter_tanggal_start);
        // $end = Carbon::parse($request->filter_tanggal_end);

        // // Pendapatan dari penjualan_detail
        // $penjualan = PenjualanDetail::selectRaw('penjualan.tanggal, SUM(penjualan_detail.subtotal) as total')
        //     ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
        //     ->whereBetween('penjualan.tanggal', [$start, $end])
        //     ->groupBy('penjualan.tanggal')
        //     ->pluck('total', 'penjualan.tanggal');

        // // Pendapatan dari tiket masuk
        // $tiket = DB::table('tiket_masuk')
        //     ->selectRaw('tanggal, SUM(harga) as total')
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->groupBy('tanggal')
        //     ->pluck('total', 'tanggal');

        // // Pengeluaran
        // $pengeluaran = DB::table('pengeluaran')
        //     ->selectRaw('tanggal, SUM(harga) as total')
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->groupBy('tanggal')
        //     ->pluck('total', 'tanggal');

        // // Rangkuman data per hari
        // $periode = [];
        // for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        //     $tanggalStr = $date->format('Y-m-d');

        //     $pendapatanPenjualan = $penjualan[$tanggalStr] ?? 0;
        //     $pendapatanTiket = $tiket[$tanggalStr] ?? 0;
        //     $totalPendapatan = $pendapatanPenjualan + $pendapatanTiket;
        //     $totalPengeluaran = $pengeluaran[$tanggalStr] ?? 0;

        //     $periode[] = [
        //         'tanggal' => $tanggalStr,
        //         'pendapatan_penjualan' => $pendapatanPenjualan,
        //         'pendapatan_tiket' => $pendapatanTiket,
        //         'pengeluaran' => $totalPengeluaran,
        //         'laba_bersih' => $totalPendapatan - $totalPengeluaran,
        //     ];
        // }

        // // Ukuran dan orientasi
        // $paperSize = $request->ukuran_kertas ?? 'A4';
        // $orientation = $request->orientasi_kertas ?? 'portrait';

        // $pdf = Pdf::loadView('backend.apps.laporan.laporan_laba_rugi.laba_rugi_pdf', [
        //     'periode' => $periode,
        //     'start' => $start->format('d-m-Y'),
        //     'end' => $end->format('d-m-Y')
        // ])->setPaper($paperSize, $orientation);

        // return $pdf->stream('laporan-laba-rugi.pdf');
    }
}
