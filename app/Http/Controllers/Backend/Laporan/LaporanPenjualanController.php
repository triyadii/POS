<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Auth;

use Barryvdh\DomPDF\Facade\Pdf;


class LaporanPenjualanController extends Controller
{

    public function index(Request $request)
    {
        return view('backend.laporan.laporan_penjualan.index');
    }


    public function getChartData(Request $request)
    {
        $start = Carbon::parse($request->filter_tanggal_start);
        $end = Carbon::parse($request->filter_tanggal_end);

        // // Ambil data penjualan yang ada
        // $penjualanData = Penjualan::selectRaw('tanggal, SUM(total) as total')
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->groupBy('tanggal')
        //     ->orderBy('tanggal')
        //     ->pluck('total', 'tanggal'); // hasil: ['2024-06-21' => 2000000, ...]

        // // Generate semua tanggal dalam range
        // $periode = [];
        // for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        //     $tanggalStr = $date->format('Y-m-d');
        //     $periode[] = [
        //         'tanggal' => $tanggalStr,
        //         'total' => $penjualanData[$tanggalStr] ?? 0
        //     ];
        // }

        // return response()->json($periode);
    }



    public function getLaporanData(Request $request)
    {
        // $postsQuery = Penjualan::query(); // tanpa order dulu

        // if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
        //     $startDate = $request->filter_tanggal_start;
        //     $endDate = $request->filter_tanggal_end;

        //     $postsQuery->whereBetween('tanggal', [$startDate, $endDate]);

        //     // 🔢 Hitung Total Transaksi
        //     $totalTransaksi = $postsQuery->count();

        //     // 💰 Total Pendapatan
        //     $totalPendapatan = (clone $postsQuery)->sum('total');

        //     // 📦 Jumlah Produk Terjual
        //     $jumlahProdukTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($startDate, $endDate) {
        //         $q->whereBetween('tanggal', [$startDate, $endDate]);
        //     })->sum('quantity');

        //     // 💳 Jumlah Transaksi per Metode Pembayaran
        //     $defaultMethods = ['cash', 'transfer', 'hutang'];

        //     $metodeData = (clone $postsQuery)
        //         ->selectRaw('pembayaran, COUNT(*) as jumlah_transaksi, SUM(total) as total_uang')
        //         ->groupBy('pembayaran')
        //         ->get()
        //         ->mapWithKeys(function ($item) {
        //             return [$item->pembayaran => [
        //                 'pembayaran' => $item->pembayaran,
        //                 'jumlah' => $item->jumlah_transaksi,
        //                 'total' => $item->total_uang,
        //             ]];
        //         });

        //     $metodePembayaran = collect($defaultMethods)->mapWithKeys(function ($method) use ($metodeData) {
        //         return [
        //             $method => $metodeData[$method] ?? [
        //                 'pembayaran' => $method,
        //                 'jumlah' => 0,
        //                 'total' => 0,
        //             ]
        //         ];
        //     });


        //     // 🪑 Pendapatan per Meja (semua meja, termasuk yang tidak ada transaksi)
        //     $mejas = Meja::select('id', 'nomor_meja')->get();

        //     $penjualan = Penjualan::whereBetween('tanggal', [$startDate, $endDate])
        //         ->selectRaw('meja_id, SUM(total) as total')
        //         ->groupBy('meja_id')
        //         ->pluck('total', 'meja_id'); // hasil: [meja_id => total]

        //     $penjualanPerMeja = $mejas->map(function ($meja) use ($penjualan) {
        //         return [
        //             'nomor_meja' => $meja->nomor_meja,
        //             'total' => $penjualan[$meja->id] ?? 0,
        //         ];
        //     })->sortBy(function ($item) {
        //         // Ekstrak angka dari "Meja 1", "Meja 12", dll
        //         preg_match('/\d+/', $item['nomor_meja'], $matches);
        //         return isset($matches[0]) ? (int) $matches[0] : 0;
        //     })->values(); // reset index

        // } else {
        //     $totalTransaksi = 0;
        //     $totalPendapatan = 0;
        //     $jumlahProdukTerjual = 0;
        //     $metodePembayaran = [];
        //     $penjualanPerMeja = [];
        // }


        // // 📆 Total Penjualan Per Tanggal
        // $penjualanPerTanggal = (clone $postsQuery)
        //     ->selectRaw('tanggal, SUM(total) as total')
        //     ->groupBy('tanggal')
        //     ->orderBy('tanggal', 'asc')
        //     ->get()
        //     ->map(function ($item) {
        //         return [
        //             'tanggal' => Carbon::parse($item->tanggal)->translatedFormat('d F Y'),
        //             'total' => $item->total,
        //         ];
        //     });


        // $data = $postsQuery->select('*');

        // return \DataTables::of($data)
        //     ->addIndexColumn()


        //     ->addColumn('user_id', function ($data) {
        //         $user = $data->user ? $data->user->name : '-';

        //         return '
        //                 <div class="badge badge-light-secondary">' . $user . '</div>
        //             ';
        //     })

        //     ->addColumn('customer_id', function ($data) {
        //         $customer = $data->customer ? $data->customer->nama : '-';

        //         return '
        //                 <div class="badge badge-light-secondary">' . $customer . '</div>
        //             ';
        //     })
        //     ->addColumn('created_at', function ($data) {
        //         return '
        //             <div class="badge badge-light-secondary">' . $data->created_at->translatedFormat('d F Y, H:i:s') . '</div>
        //         ';
        //     })

        //     ->addColumn('total', function ($data) {
        //         $badgeClass = 'badge-secondary'; // default

        //         switch ($data->pembayaran) {
        //             case 'cash':
        //                 $badgeClass = 'badge-success';
        //                 break;
        //             case 'hutang':
        //                 $badgeClass = 'badge-warning';
        //                 break;
        //             case 'transfer':
        //                 $badgeClass = 'badge-info';
        //                 break;
        //         }

        //         return '
        //             <div class="badge ' . $badgeClass . '">Rp. ' . number_format($data->total, 0, ',', '.') . '</div>
        //         ';
        //     })

        //     ->addColumn('pembayaran', function ($data) {
        //         $badgeClass = 'badge-secondary'; // default
        //         $label = ucfirst($data->pembayaran); // Untuk tampilan teks

        //         switch ($data->pembayaran) {
        //             case 'cash':
        //                 $badgeClass = 'badge-success';
        //                 break;
        //             case 'hutang':
        //                 $badgeClass = 'badge-warning';
        //                 break;
        //             case 'transfer':
        //                 $badgeClass = 'badge-info';
        //                 break;
        //         }

        //         return '<div class="badge ' . $badgeClass . '">' . $label . '</div>';
        //     })

        //     ->addColumn('catatan', function ($data) {
        //         return $data->catatan ? e($data->catatan) : '-';
        //     })

        //     ->addColumn('meja_id', function ($data) {
        //         if ($data->meja && $data->meja->nomor_meja) {
        //             return '<span class="badge badge-secondary">' . $data->meja->nomor_meja . '</span>';
        //         }
        //         return '<span class="badge badge-light">-</span>';
        //     })




        //     ->rawColumns(['action', 'user_id', 'created_at', 'customer_id', 'total', 'pembayaran', 'catatan', 'meja_id'])
        //     ->with([
        //         'total_transaksi' => $totalTransaksi,
        //         'total_penjualan' => $totalPendapatan,
        //         'jumlah_produk_terjual' => $jumlahProdukTerjual,
        //         'metode_pembayaran' => $metodePembayaran,
        //         'penjualan_per_meja' => $penjualanPerMeja,
        //         'penjualan_per_tanggal' => $penjualanPerTanggal,
        //     ])
        //     ->make(true);
    }



    public function export(Request $request)
    {
        // $ukuran = $request->ukuran; // A4 / F4
        // $orientasi = $request->orientasi; // portrait / landscape
        // $tipe = $request->tipe; // statistik / datatable / gabungan
        // $start = $request->start;
        // $end = $request->end;

        // if (!$ukuran || !$orientasi || !$tipe || !$start || !$end) {
        //     return abort(400, 'Data tidak lengkap');
        // }

        // // Ambil data utama
        // $penjualan = Penjualan::with(['meja:id,nomor_meja', 'user:id,name', 'customer:id,nama'])
        //     ->whereBetween('tanggal', [$start, $end])
        //     ->get();

        // // Statistik
        // $totalTransaksi = $penjualan->count();
        // $totalPendapatan = $penjualan->sum('total');

        // $jumlahProdukTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($start, $end) {
        //     $q->whereBetween('tanggal', [$start, $end]);
        // })->sum('quantity');

        // $metodePembayaran = ['cash' => ['jumlah' => 0, 'total' => 0], 'transfer' => ['jumlah' => 0, 'total' => 0], 'hutang' => ['jumlah' => 0, 'total' => 0]];
        // foreach ($penjualan->groupBy('pembayaran') as $key => $group) {
        //     $metodePembayaran[$key] = [
        //         'jumlah' => $group->count(),
        //         'total' => $group->sum('total'),
        //     ];
        // }

        // $mejas = Meja::select('id', 'nomor_meja')->get();
        // $pendapatanPerMeja = $mejas->map(function ($meja) use ($penjualan) {
        //     $total = $penjualan->where('meja_id', $meja->id)->sum('total');
        //     return [
        //         'nomor_meja' => $meja->nomor_meja,
        //         'total' => $total
        //     ];
        // })->sortBy(function ($item) {
        //     preg_match('/\d+/', $item['nomor_meja'], $matches);
        //     return isset($matches[0]) ? (int) $matches[0] : 0; // non-numeric meja di akhir
        // })->values();


        // // Siapkan data untuk view
        // $data = compact(
        //     'penjualan',
        //     'totalTransaksi',
        //     'totalPendapatan',
        //     'jumlahProdukTerjual',
        //     'metodePembayaran',
        //     'pendapatanPerMeja',
        //     'start',
        //     'end'
        // );

        // // Pilih view berdasarkan tipe
        // if ($tipe === 'statistik') {
        //     $view = view('backend.apps.laporan.laporan_penjualan.laporan-statistik', $data);
        // } elseif ($tipe === 'datatable') {
        //     $view = view('backend.apps.laporan.laporan_penjualan.laporan-data', $data);
        // } else {
        //     $view = view('backend.apps.laporan.laporan_penjualan.laporan-gabungan', $data);
        // }

        // // Export PDF
        // $pdf = Pdf::loadHTML($view)->setPaper($ukuran, $orientasi);
        // return $pdf->stream('laporan-penjualan.pdf');
    }
}
