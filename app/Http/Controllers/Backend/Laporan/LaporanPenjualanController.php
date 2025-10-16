<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanController extends Controller
{


    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:laporan-global-list', ['only' => ['index', 'getLaporanData','export']]);
    }





    public function index(Request $request)
    {
        return view('backend.laporan.laporan_penjualan.index');
    }

    // DISESUAIKAN: Mengambil data untuk chart
    public function getChartData(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start)->startOfDay();
        $end = Carbon::parse($request->filter_tanggal_end)->endOfDay();

        // Ambil data penjualan yang ada
        $penjualanData = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal'); // hasil: ['2025-10-11' => 2000000, ...]

        // Generate semua tanggal dalam range agar chart tidak putus
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

    // DISESUAIKAN: Mengambil data untuk DataTables dan Statistik
    public function getLaporanData(Request $request)
    {
        $query = Penjualan::query();

        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        // Clone query untuk statistik agar tidak terpengaruh oleh DataTables
        $statsQuery = clone $query;
        $dateRangeExists = isset($startDate) && isset($endDate);

        // Menghitung Statistik
        $totalTransaksi = $dateRangeExists ? $statsQuery->count() : 0;
        $totalPendapatan = $dateRangeExists ? $statsQuery->sum('total_harga') : 0;

        $jumlahProdukTerjual = $dateRangeExists ? PenjualanDetail::whereHas('penjualan', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        })->sum('qty') : 0;

        // Query utama untuk DataTables dengan Eager Loading
        // Eager loading sangat penting untuk performa, agar tidak terjadi N+1 query problem
        $data = $query->with([
            'user:id,name',
            'detail',
            'detail.barang:id,kode_barang,nama,brand_id,tipe_id', // Ambil relasi barang
            'detail.barang.tipe:id,nama', // Ambil relasi tipe dari barang
            'detail.barang.brand:id,nama', // Ambil relasi brand dari barang
        ])->select('penjualan.*');

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($data) {
                return Carbon::parse($data->tanggal_penjualan)->translatedFormat('d F Y, H:i');
            })
            ->addColumn('user', function ($data) {
                return $data->user->name ?? '-';
            })
            ->addColumn('customer', function ($data) {
                return $data->customer_nama ?? 'Umum';
            })
            ->addColumn('total', function ($data) {
                return 'Rp ' . number_format($data->total_harga, 0, ',', '.');
            })
            ->addColumn('detail_barang', function ($data) {
                $details = '<ul class="list-unstyled mb-0">';
                foreach ($data->detail as $item) {
                    $details .= '<li class="border-bottom py-2">';
                    $details .= '<div class="fw-bold">' . e($item->barang->nama ?? 'N/A') . ' (' . e($item->barang->kode_barang ?? 'N/A') . ')</div>';
                    $details .= '<small class="text-muted">Tipe: ' . e($item->barang->tipe->nama ?? '-') . ' | Brand: ' . e($item->barang->brand->nama ?? '-') . '</small><br>';
                    $details .= '<span>Qty: ' . $item->qty . ' x Rp ' . number_format($item->harga_jual, 0, ',', '.') . '</span>';
                    // CATATAN: Model Anda belum memiliki 'harga_potongan'. Jika ada, tambahkan di sini.
                    // $details .= ' | Potongan: Rp ' . number_format($item->potongan_harga, 0, ',', '.');
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

    // DISESUAIKAN: Fungsi untuk export PDF
    public function export(Request $request)
    {
        // Validasi input
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:portrait,landscape',
            'tipe' => 'required|in:datatable',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Ambil data utama
        $penjualan = Penjualan::with([
            'user:id,name',
            'detail.barang:id,kode_barang,nama',
            'detail.barang.tipe:id,nama',
        ])
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        // Statistik
        $totalTransaksi = $penjualan->count();
        $totalPendapatan = $penjualan->sum('total_harga');
        $jumlahProdukTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($start, $end) {
            $q->whereBetween('tanggal_penjualan', [$start, $end]);
        })->sum('qty');

        $namaUser = Auth::user()->name; // Mengambil nama user yang login
        $tanggalCetak = Carbon::now();  // Mengambil waktu saat ini    $namaUser = Auth::user()->name; // Mengambil nama user yang login

        $data = compact(
            'penjualan',
            'totalTransaksi',
            'totalPendapatan',
            'jumlahProdukTerjual',
            'start',
            'end',
            'namaUser', // Variabel baru
            'tanggalCetak' // Variabel baru
        );

        $viewPath = 'backend.laporan.laporan_penjualan.';
        $viewName = '';

        switch ($request->tipe) {
            default:
                $viewName = 'laporan-data';
                break;
        }

        $pdf = Pdf::loadView($viewPath . $viewName, $data)
            ->setPaper($request->ukuran, $request->orientasi);

        return $pdf->stream('laporan_penjualan-' . $request->tipe . '.pdf');
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
