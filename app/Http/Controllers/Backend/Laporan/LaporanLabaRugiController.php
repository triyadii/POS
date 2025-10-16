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

class LaporanLabaRugiController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:laporan-laba-rugi-list', ['only' => ['index', 'getProfitLossData', 'exportLabaRugiPdf']]);
    }



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

        $paperSize = $request->ukuran_kertas ?? 'A4';
        $orientation = $request->orientasi_kertas ?? 'portrait';

        // 2. Modifikasi data yang akan dikirim ke view
        $pdf = Pdf::loadView('backend.laporan.laporan_laba_rugi.laba_rugi_pdf', [
            'periode' => $periode,
            'start' => $start, // Kirim sebagai objek Carbon
            'end' => $end,     // Kirim sebagai objek Carbon
            'namaUser' => Auth::user()->name,       // Ambil nama user yang login
            'tanggalCetak' => Carbon::now()         // Ambil waktu saat ini
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
        // KODE BARU (Mengambil harga_beli langsung dari 'penjualan_detail')
        $pengeluaran = PenjualanDetail::select(
            DB::raw('DATE(penjualan.tanggal_penjualan) as tanggal'),
            // Menggunakan harga_beli dari penjualan_detail, bukan dari barang
            DB::raw('SUM(penjualan_detail.qty * penjualan_detail.harga_beli) as total')
        )
            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
            // Join ke tabel 'barang' sudah tidak diperlukan lagi untuk kalkulasi ini
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
