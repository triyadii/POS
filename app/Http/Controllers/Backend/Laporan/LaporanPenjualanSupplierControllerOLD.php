<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Brand;
use App\Models\Kategori;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanSupplierController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('nama', 'asc')->get();
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        return view('backend.laporan.laporan_penjualan_supplier.index', compact('brands', 'kategori'));
    }

    public function getLaporanData(Request $request)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
        }

        // Query utama: Ambil barang yang terjual, lalu cari supplier terakhirnya via subquery
        $query = Barang::query()
            ->select('barang.id', 'barang.nama', 'barang.kode_barang')
            ->selectRaw('SUM(penjualan_detail.qty) as total_qty_terjual')
            ->selectRaw('SUM(penjualan_detail.subtotal) as total_pendapatan')
            ->selectRaw('(
                SELECT s.nama FROM suppliers s
                JOIN barang_masuk bm ON s.id = bm.supplier_id
                JOIN barang_masuk_detail bmd ON bm.id = bmd.barang_masuk_id
                WHERE bmd.barang_id = barang.id
                ORDER BY bm.tanggal_masuk DESC, bm.created_at DESC
                LIMIT 1
            ) as supplier_terakhir')
            ->join('penjualan_detail', 'barang.id', '=', 'penjualan_detail.barang_id')
            ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$startDate, $endDate])
            ->groupBy('barang.id', 'barang.nama', 'barang.kode_barang');

        if ($request->filled('filter_kategori') && $request->filter_kategori != 'all') {
            $query->where('barang.kategori_id', $request->filter_kategori);
        }
        if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
            $query->where('barang.brand_id', $request->filter_brand);
        }

        $statsData = (clone $query)->get();
        $totalPendapatan = $statsData->sum('total_pendapatan');
        $totalProdukTerjual = $statsData->sum('total_qty_terjual');
        $totalJenisProduk = $statsData->count();

        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('total_item', fn($data) => number_format($data->total_qty_terjual, 0, ',', '.') . ' Pcs')
            ->addColumn('total_penjualan', fn($data) => 'Rp ' . number_format($data->total_pendapatan, 0, ',', '.'))
            ->addColumn('supplier', fn($data) => $data->supplier_terakhir ?? '-')
            ->with([
                'total_pendapatan' => $totalPendapatan,
                'total_produk_terjual' => $totalProdukTerjual,
                'total_jenis_produk' => $totalJenisProduk,
            ])
            ->make(true);
    }

    // Chart sekarang menampilkan 10 produk terlaris
    public function getChartData(Request $request)
    {
        $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        $query = Barang::query()
            ->select('barang.nama')
            ->selectRaw('SUM(penjualan_detail.qty) as total_terjual')
            ->join('penjualan_detail', 'barang.id', '=', 'penjualan_detail.barang_id')
            ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$startDate, $endDate])
            ->groupBy('barang.nama')
            ->orderBy('total_terjual', 'desc')
            ->take(10);

        if ($request->filled('filter_kategori') && $request->filter_kategori != 'all') {
            $query->where('barang.kategori_id', $request->filter_kategori);
        }
        if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
            $query->where('barang.brand_id', $request->filter_brand);
        }

        $data = $query->pluck('total_terjual', 'nama');

        return response()->json($data);
    }

    public function export(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
            'tipe' => 'required|in:statistik,datatable,gabungan',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        $query = Barang::query()
            ->select('barang.id', 'barang.nama', 'barang.kode_barang')
            ->selectRaw('SUM(penjualan_detail.qty) as total_qty_terjual')
            ->selectRaw('SUM(penjualan_detail.subtotal) as total_pendapatan')
            ->selectRaw('(SELECT s.nama FROM suppliers s JOIN barang_masuk bm ON s.id = bm.supplier_id JOIN barang_masuk_detail bmd ON bm.id = bmd.barang_masuk_id WHERE bmd.barang_id = barang.id ORDER BY bm.tanggal_masuk DESC, bm.created_at DESC LIMIT 1) as supplier_terakhir')
            ->join('penjualan_detail', 'barang.id', '=', 'penjualan_detail.barang_id')
            ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$start, $end])
            ->groupBy('barang.id', 'barang.nama', 'barang.kode_barang');

        if ($request->filled('kategori_id') && $request->kategori_id != 'all') {
            $query->where('barang.kategori_id', $request->kategori_id);
        }
        if ($request->filled('brand_id') && $request->brand_id != 'all') {
            $query->where('barang.brand_id', $request->brand_id);
        }

        $dataBarang = $query->orderBy('total_pendapatan', 'desc')->get();
        $totalPendapatan = $dataBarang->sum('total_pendapatan');
        $totalProdukTerjual = $dataBarang->sum('total_qty_terjual');
        $totalJenisProduk = $dataBarang->count();

        $data = compact(
            'dataBarang',
            'totalPendapatan',
            'totalProdukTerjual',
            'totalJenisProduk',
            'start',
            'end'
        );

        $viewPath = 'backend.laporan.laporan_penjualan_supplier.';
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
        return $pdf->stream('laporan-penjualan-supplier-alt.pdf');
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
