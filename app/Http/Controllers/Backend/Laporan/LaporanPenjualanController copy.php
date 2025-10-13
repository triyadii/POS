<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use DB;
use DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.laporan.laporan_penjualan.index');
    }

    public function getChartData(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        $penjualanData = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        $periode = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $tanggalStr = $date->format('Y-m-d');
            $periode[] = [
                'tanggal' => $tanggalStr,
                'total' => $penjualanData[$tanggalStr] ?? 0
            ];
        }

        return response()->json($periode);
    }

    public function getLaporanData(Request $request)
    {
        $query = Penjualan::with('user')->select('penjualan.*');

        if ($request->filled('filter_tanggal_start') && $request->filled('filter_tanggal_end')) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        // Clone query untuk statistik agar tidak terpengaruh oleh pagination DataTables
        $statsQuery = clone $query;
        $totalTransaksi = $statsQuery->count();
        $totalPenjualan = $statsQuery->sum('total_harga');

        // Hitung jumlah item terjual dari detail
        $jumlahItemTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($request) {
            if ($request->filled('filter_tanggal_start') && $request->filled('filter_tanggal_end')) {
                $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
                $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();
                $q->whereBetween('tanggal_penjualan', [$start, $end]);
            }
        })->sum('qty');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('details_control', function ($row) {
                return ''; // Kolom kosong untuk tombol expand
            })
            ->editColumn('tanggal_penjualan', function ($row) {
                return Carbon::parse($row->tanggal_penjualan)->translatedFormat('d F Y');
            })
            ->addColumn('kasir', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->editColumn('total_harga', function ($row) {
                return 'Rp ' . number_format($row->total_harga, 0, ',', '.');
            })
            ->rawColumns(['details_control'])
            ->with([
                'total_transaksi' => $totalTransaksi,
                'total_penjualan' => $totalPenjualan,
                'jumlah_item_terjual' => $jumlahItemTerjual,
            ])
            ->make(true);
    }

    public function getPenjualanDetail($id)
    {
        $details = PenjualanDetail::with('barang.tipe')->where('penjualan_id', $id)->get();

        // Buat HTML untuk child row
        $html = view('backend.laporan.laporan_penjualan.detail_item', compact('details'))->render();

        return response()->json(['html' => $html]);
    }

    public function exportPdf(Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Eager load semua relasi yang dibutuhkan dalam satu query
        $penjualan = Penjualan::with(['user', 'detail.barang.tipe'])
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        // Statistik
        $totalTransaksi = $penjualan->count();
        $totalPenjualan = $penjualan->sum('total_harga');
        $jumlahItemTerjual = $penjualan->flatMap(function ($p) {
            return $p->detail;
        })->sum('qty');

        $data = compact(
            'penjualan',
            'totalTransaksi',
            'totalPenjualan',
            'jumlahItemTerjual',
            'start',
            'end'
        );

        $pdf = Pdf::loadView('backend.laporan.laporan_penjualan.laporan_penjualan_pdf', $data)
            ->setPaper($request->ukuran ?? 'a4', $request->orientasi ?? 'portrait');

        return $pdf->stream('laporan-penjualan-detail.pdf');
    }
}
