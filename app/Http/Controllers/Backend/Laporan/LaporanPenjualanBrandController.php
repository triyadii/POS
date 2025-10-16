<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanBrandController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:laporan-penjualan-brand-list', ['only' => ['index', 'getLaporanData','export']]);
    }
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
        // ... Logika query dan statistik tidak berubah ...
        $query = Penjualan::query();
        $startDate = null;
        $endDate = null;
        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }
        $brandId = ($request->filled('filter_brand') && $request->filter_brand != 'all') ? $request->filter_brand : null;
        if ($brandId) {
            $query->whereHas('detail.barang', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }
        $dateRangeExists = isset($startDate) && isset($endDate);
        $totalTransaksi = $dateRangeExists ? (clone $query)->count() : 0;
        $detailQuery = PenjualanDetail::query();
        if ($dateRangeExists) {
            $detailQuery->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
            });
        }
        if ($brandId) {
            $detailQuery->whereHas('barang', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }
        $totalPendapatan = $dateRangeExists ? (clone $detailQuery)->sum('subtotal') : 0;
        $jumlahProdukTerjual = $dateRangeExists ? (clone $detailQuery)->sum('qty') : 0;
        $data = $query->with(['user:id,name', 'detail.barang:id,kode_barang,nama,brand_id,tipe_id,kategori_id', 'detail.barang.tipe:id,nama', 'detail.barang.brand:id,nama', 'detail.barang.kategori:id,nama']);

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', fn($data) => Carbon::parse($data->tanggal_penjualan)->translatedFormat('d F Y, H:i'))
            ->addColumn('user', fn($data) => $data->user->name ?? '-')
            ->addColumn('customer', fn($data) => $data->customer_nama ?? 'Umum')
            ->addColumn('total', function ($data) use ($brandId) {
                // ... Logika addColumn('total') tidak berubah ...
                $total = $brandId ? $data->detail->filter(fn($item) => $item->barang->brand_id == $brandId)->sum('subtotal') : $data->total_harga;
                return 'Rp ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('detail_barang', function ($data) use ($brandId) {
                $details = '<ul class="list-unstyled mb-0">';
                foreach ($data->detail as $item) {
                    if ($brandId && optional($item->barang)->brand_id != $brandId) {
                        continue;
                    }

                    $details .= '<li class="border-bottom py-2">';
                    $details .= '<div class="fw-bold">' . e($item->barang->nama ?? 'N/A') . ' (' . e($item->barang->kode_barang ?? 'N/A') . ')</div>';
                    $details .= '<small class="text-muted">Kategori: ' . e(optional($item->barang->kategori)->nama ?? '-') . ' | Tipe: ' . e(optional($item->barang->tipe)->nama ?? '-') . ' | Brand: ' . e(optional($item->barang->brand)->nama ?? '-') . '</small>';

                    // ===================================
                    // PERUBAHAN DI SINI
                    // ===================================
                    $details .= '<div class="d-flex justify-content-between">
                                    <span>Qty: ' . $item->qty . ' x Rp ' . number_format($item->harga_jual, 0, ',', '.') . '</span>
                                    <span class="fw-semibold">Rp ' . number_format($item->subtotal, 0, ',', '.') . '</span>
                                 </div>';

                    $details .= '</li>';
                }
                $details .= '</ul>';
                return $details;
            })
            ->rawColumns(['detail_barang'])
            ->with(['total_transaksi' => $totalTransaksi, 'total_penjualan' => $totalPendapatan, 'jumlah_produk_terjual' => $jumlahProdukTerjual])
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
        // ... (kode validasi dan query tidak berubah)
        //
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
            'tipe' => 'required|in:datatable',
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

        // ... (kode kalkulasi statistik tidak berubah)

        $totalTransaksi = $penjualan->count();

        $filteredDetails = $penjualan->flatMap->detail->when($brandId && $brandId != 'all', function ($collection) use ($brandId) {
            return $collection->filter(fn($item) => optional($item->barang)->brand_id == $brandId);
        });

        $totalPenjualan = $filteredDetails->sum('subtotal');
        $jumlahItemTerjual = $filteredDetails->sum('qty');
        $totalPenjualanTerbilang = $this->terbilang($totalPenjualan);

        // ==========================================================
        // PERUBAHAN DI SINI: Tambahkan data user dan tanggal cetak
        // ==========================================================
        $namaUser = Auth::user()->name; // Mengambil nama user yang login
        $tanggalCetak = Carbon::now();  // Mengambil waktu saat ini

        // Tambahkan variabel baru ke dalam compact()
        $data = compact(
            'penjualan',
            'totalTransaksi',
            'totalPenjualan',
            'jumlahItemTerjual',
            'start',
            'end',
            'brandId',
            'totalPenjualanTerbilang',
            'namaUser', // Variabel baru
            'tanggalCetak' // Variabel baru
        );

        $viewPath = 'backend.laporan.laporan_penjualan_brand.';
        $viewName = '';
        switch ($request->tipe) {
            default:
                // Kita akan membuat view ini di langkah berikutnya
                $viewName = 'laporan-data';
                break;
        }
        $pdf = Pdf::loadView($viewPath . $viewName, $data)->setPaper($request->ukuran, $request->orientasi);
        return $pdf->stream('laporan-penjualan-brand.pdf');
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
