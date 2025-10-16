<?php

namespace App\Http\Controllers\Backend\Stok;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Brand;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller

{


    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:stok-list', ['only' => ['index', 'getStokData']]);
    }



    // ... method index() dan getStokData() tidak berubah ...
    public function index()
    {
        $brands = Brand::orderBy('nama', 'asc')->get();
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        return view('backend.stok.index', compact('brands', 'kategori'));
    }

    public function getStokData(Request $request)
    {
        $query = Barang::with(['kategori', 'brand']);
        if ($request->filled('filter_kategori') && $request->filter_kategori != 'all') {
            $query->where('kategori_id', $request->filter_kategori);
        }
        if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
            $query->where('brand_id', $request->filter_brand);
        }
        $filteredData = (clone $query)->get();
        $totalStok = $filteredData->sum('stok');
        $totalJenisBarang = $filteredData->count();
        $stokKritis = $filteredData->where('stok', '<=', 10)->count();
        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kategori', fn($data) => $data->kategori->nama ?? '-')
            ->addColumn('brand', fn($data) => $data->brand->nama ?? '-')
            ->addColumn('size', fn($data) => $data->size ?? '-')
            ->addColumn('stok', function ($data) {
                $badgeClass = $data->stok <= 10 ? 'badge-light-danger' : 'badge-light-primary';
                return '<span class="badge ' . $badgeClass . '">' . $data->stok . '</span>';
            })
            ->rawColumns(['stok'])
            ->with(['total_stok' => $totalStok, 'total_jenis_barang' => $totalJenisBarang, 'stok_kritis' => $stokKritis,])
            ->make(true);
    }

    // // ===================================
    // // UBAH FUNGSI DI BAWAH INI
    // // ===================================
    // public function getChartData(Request $request)
    // {
    //     $query = Barang::query();
    //     if ($request->filled('filter_kategori') && $request->filter_kategori != 'all') {
    //         $query->where('kategori_id', $request->filter_kategori);
    //     }
    //     if ($request->filled('filter_brand') && $request->filter_brand != 'all') {
    //         $query->where('brand_id', $request->filter_brand);
    //     }

    //     // PERUBAHAN: Urutkan berdasarkan apakah stok > 0, lalu urutkan berdasarkan stok
    //     $data = $query->orderByRaw('stok > 0 DESC, stok ASC')
    //         ->take(10)
    //         ->get(['nama', 'stok'])
    //         ->pluck('stok', 'nama');

    //     return response()->json($data);
    // }

    public function export(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
        ]);

        $query = Barang::with(['kategori', 'brand']);

        if ($request->filled('kategori_id') && $request->kategori_id != 'all') {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('brand_id') && $request->brand_id != 'all') {
            $query->where('brand_id', $request->brand_id);
        }

        $barang = $query->orderBy('nama', 'asc')->get();

        // 2. Modifikasi array data yang dikirim ke view
        $data = [
            'barang' => $barang,
            'namaUser' => Auth::user()->name,       // Ambil nama user yang login
            'tanggalCetak' => Carbon::now(),        // Ambil waktu saat ini untuk tanggal cetak
        ];

        $pdf = Pdf::loadView('backend.stok.laporan-stok-pdf', $data)
            ->setPaper($request->ukuran, $request->orientasi);

        return $pdf->stream('laporan-stok-barang.pdf');
    }
}
