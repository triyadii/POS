<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanBrandController extends Controller
{
    /**
     * Menampilkan halaman laporan dan mengirim data brand untuk filter.
     */
    public function index()
    {
        $brands = Brand::orderBy('nama', 'asc')->get();
        return view('backend.laporan.laporan_penjualan_brand.index', compact('brands'));
    }

    /**
     * Mengambil data untuk DataTables (sekarang data transaksional).
     */
    public function getLaporanData(Request $request)
    {
        $query = Penjualan::query();

        // Filter berdasarkan rentang tanggal
        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        // Filter BARU: berdasarkan brand yang dipilih
        if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
            $brandId = $request->filter_brand;
            $query->whereHas('detail.barang', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        $dateRangeExists = isset($startDate) && isset($endDate);

        // Menghitung statistik berdasarkan data yang sudah difilter
        $totalTransaksi = $dateRangeExists ? (clone $query)->count() : 0;
        $totalPendapatan = $dateRangeExists ? (clone $query)->sum('total_harga') : 0;
        $penjualanIds = $dateRangeExists ? (clone $query)->pluck('id') : [];
        $jumlahProdukTerjual = $dateRangeExists ? PenjualanDetail::whereIn('penjualan_id', $penjualanIds)->sum('qty') : 0;

        // Eager loading untuk performa
        $data = $query->with([
            'user:id,name',
            'detail.barang:id,kode_barang,nama,brand_id,tipe_id,kategori_id',
            'detail.barang.tipe:id,nama',
            'detail.barang.brand:id,nama',
            'detail.barang.kategori:id,nama'
        ]);

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', fn($data) => Carbon::parse($data->tanggal_penjualan)->translatedFormat('d F Y, H:i'))
            ->addColumn('user', fn($data) => $data->user->name ?? '-')
            ->addColumn('customer', fn($data) => $data->customer_nama ?? 'Umum')
            ->addColumn('total', fn($data) => 'Rp ' . number_format($data->total_harga, 0, ',', '.'))
            ->addColumn('detail_barang', function ($data) {
                $details = '<ul class="list-unstyled mb-0">';
                foreach ($data->detail as $item) {
                    $details .= '<li class="border-bottom py-2">';
                    $details .= '<div class="fw-bold">' . e($item->barang->nama ?? 'N/A') . ' (' . e($item->barang->kode_barang ?? 'N/A') . ')</div>';
                    $details .= '<small class="text-muted">Kategori: ' . e($item->barang->kategori->nama ?? '-') . ' | Tipe: ' . e($item->barang->tipe->nama ?? '-') . ' | Brand: ' . e($item->barang->brand->nama ?? '-') . '</small><br>';
                    $details .= '<span>Qty: ' . $item->qty . ' x Rp ' . number_format($item->harga_jual, 0, ',', '.') . '</span>';
                    $details .= '<span class="float-end fw-semibold">Rp ' . number_format($item->subtotal, 0, ',', '.') . '</span>';
                    $details .= '</li>';
                }
                $details .= '</ul>';
                return $details;
            })
            ->rawColumns(['detail_barang'])
            ->with([
                'total_transaksi' => $totalTransaksi,
                'total_penjualan' => $totalPendapatan,
                'jumlah_produk_terjual' => $jumlahProdukTerjual,
            ])
            ->make(true);
    }

    /**
     * Mengambil data untuk chart (penjualan harian berdasarkan filter).
     */
    public function getChartData(Request $request)
    {
        $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
        $query = Penjualan::query()
            ->select(DB::raw('DATE(tanggal_penjualan) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->groupBy('tanggal')->orderBy('tanggal');

        if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
            $brandId = $request->filter_brand;
            $query->whereHas('detail.barang', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        $penjualanData = $query->pluck('total', 'tanggal');
        $periode = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $tanggalStr = $date->format('Y-m-d');
            $periode[] = ['tanggal' => $tanggalStr, 'total' => $penjualanData[$tanggalStr] ?? 0];
        }
        return response()->json($periode);
    }

    /**
     * Fungsi untuk export ke PDF (data transaksional).
     */
    public function export(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
            'tipe' => 'required|in:statistik,datatable,gabungan',
            'start' => 'required|date',
            'end' => 'required|date',
            'brand_id' => 'nullable|string',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();
        $brandId = $request->brand_id;

        $query = Penjualan::with([
            'user:id,name',
            'detail.barang:id,kode_barang,nama,brand_id,kategori_id',
            'detail.barang.tipe:id,nama',
            'detail.barang.brand:id,nama',
            'detail.barang.kategori:id,nama'
        ])
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->orderBy('tanggal_penjualan', 'asc');

        if ($brandId && $brandId != 'all') {
            $query->whereHas('detail.barang', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        $penjualan = $query->get();
        $totalTransaksi = $penjualan->count();
        $totalPenjualan = $penjualan->sum('total_harga');
        $jumlahItemTerjual = $penjualan->flatMap->detail->sum('qty');
        $data = compact('penjualan', 'totalTransaksi', 'totalPenjualan', 'jumlahItemTerjual', 'start', 'end');
        $viewPath = 'backend.laporan.laporan_penjualan_brand.';
        $viewName = '';
        switch ($request->tipe) {
            case 'statistik':
                $viewName = 'laporan-statistik';
                break;
            case 'datatable':
                $viewName = 'laporan-data';
                break;
            default:
                $viewName = 'laporan-gabungan';
                break;
        }
        $pdf = Pdf::loadView($viewPath . $viewName, $data)->setPaper($request->ukuran, $request->orientasi);
        return $pdf->stream('laporan-penjualan-brand.pdf');
    }
}
