<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Supplier; // Ganti model yang di-import
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPembelianSupplierController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:laporan-pembelian-supplier-list', ['only' => ['index', 'getLaporanData','export']]);
    }



    /**
     * Hapus pengambilan data brand & kategori karena filter dihilangkan.
     */
    public function index()
    {
        return view('backend.laporan.laporan_pembelian_supplier.index');
    }

    /**
     * PERUBAHAN LOGIKA UTAMA: Mengambil data pembelian per supplier dari barang masuk.
     */
    public function getLaporanData(Request $request)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($request->filled('filter_tanggal_start') && $request->filled('filter_tanggal_end')) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
        }

        // Query diubah total untuk mengagregasi data dari barang masuk per supplier.
        $query = Supplier::query()
            ->select('suppliers.nama')
            ->selectRaw('SUM(bmd.qty) as total_qty_masuk')
            ->selectRaw('SUM(bmd.subtotal) as total_harga_beli')
            ->join('barang_masuk as bm', 'suppliers.id', '=', 'bm.supplier_id')
            ->join('barang_masuk_detail as bmd', 'bm.id', '=', 'bmd.barang_masuk_id')
            ->whereBetween('bm.tanggal_masuk', [$startDate, $endDate])
            ->groupBy('suppliers.id', 'suppliers.nama');

        // Kalkulasi statistik baru.
        $statsData = (clone $query)->get();
        $totalPembelian = $statsData->sum('total_harga_beli');
        $totalBarangDiterima = $statsData->sum('total_qty_masuk');
        $totalSupplier = $statsData->count();

        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('total_item', fn($data) => number_format($data->total_qty_masuk, 0, ',', '.') . ' Pcs')
            ->addColumn('total_pembelian', fn($data) => 'Rp ' . number_format($data->total_harga_beli, 0, ',', '.'))
            ->with([
                'total_pembelian' => $totalPembelian,
                'total_barang_diterima' => $totalBarangDiterima,
                'total_supplier' => $totalSupplier,
            ])
            ->make(true);
    }

    /**
     * PERUBAHAN LOGIKA CHART: Menampilkan 10 supplier teratas berdasarkan nilai pembelian.
     */
    public function getChartData(Request $request)
    {
        $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        $query = Supplier::query()
            ->select('suppliers.nama')
            ->selectRaw('SUM(bmd.subtotal) as total_pembelian')
            ->join('barang_masuk as bm', 'suppliers.id', '=', 'bm.supplier_id')
            ->join('barang_masuk_detail as bmd', 'bm.id', '=', 'bmd.barang_masuk_id')
            ->whereBetween('bm.tanggal_masuk', [$startDate, $endDate])
            ->groupBy('suppliers.id', 'suppliers.nama')
            ->orderBy('total_pembelian', 'desc')
            ->take(10);

        $data = $query->get()->pluck('total_pembelian', 'nama');
        return response()->json($data);
    }

    /**
     * PERUBAHAN LOGIKA EXPORT: Export data pembelian per supplier.
     */
    public function export(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
            'tipe' => 'required|in:datatable',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Query sama dengan getLaporanData.
        $query = Supplier::query()
            ->select('suppliers.nama')
            ->selectRaw('SUM(bmd.qty) as total_qty_masuk')
            ->selectRaw('SUM(bmd.subtotal) as total_harga_beli')
            ->join('barang_masuk as bm', 'suppliers.id', '=', 'bm.supplier_id')
            ->join('barang_masuk_detail as bmd', 'bm.id', '=', 'bmd.barang_masuk_id')
            ->whereBetween('bm.tanggal_masuk', [$start, $end])
            ->groupBy('suppliers.id', 'suppliers.nama');

        $dataSupplier = $query->orderBy('total_harga_beli', 'desc')->get();

        // Ganti nama variabel statistik.
        $totalPembelian = $dataSupplier->sum('total_harga_beli');
        $totalBarangDiterima = $dataSupplier->sum('total_qty_masuk');
        $namaUser = Auth::user()->name;
        $tanggalCetak = Carbon::now();

        $data = compact(
            'dataSupplier',
            'totalPembelian',
            'totalBarangDiterima',
            'start',
            'end',
            'namaUser',
            'tanggalCetak'
        );

        $viewPath = 'backend.laporan.laporan_pembelian_supplier.';
        $pdf = Pdf::loadView($viewPath . 'laporan-data', $data)->setPaper($request->ukuran, $request->orientasi);
        return $pdf->stream('laporan-pembelian-supplier.pdf');
    }
}
