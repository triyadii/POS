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

class LaporanPenjualanHarianController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.laporan.laporan_penjualan_harian.index');
    }

    // DISESUAIKAN: Mengambil data untuk DataTables (LOGIKA DIUBAH TOTAL)
    public function getLaporanData(Request $request)
    {
        // =======================================================
        // PERUBAHAN: Query utama sekarang ke PenjualanDetail
        // =======================================================
        $query = PenjualanDetail::query();
        $dateRangeExists = false;

        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $dateRangeExists = true;

            // Filter berdasarkan tanggal di relasi 'penjualan'
            $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
            });
        }

        // --- Statistik Box Atas (berdasarkan Penjualan) ---
        $statsQuery = Penjualan::query();
        if ($dateRangeExists) {
            $statsQuery->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }
        $totalTransaksi = $dateRangeExists ? $statsQuery->count() : 0;
        $totalPendapatan = $dateRangeExists ? $statsQuery->sum('total_harga') : 0;
        // Hitung total item terjual dari query detail
        $jumlahProdukTerjual = $dateRangeExists ? (clone $query)->sum('qty') : 0;


        // --- Query Footer & Summary Box (berdasarkan PenjualanDetail) ---
        $footerData = $dateRangeExists ? (clone $query)->with('penjualan.pembayaran')->get() : collect();

        $total_subtotal = $footerData->sum('subtotal');
        // Profit = subtotal - (harga_beli * qty)
        $total_profit = $footerData->sum(function ($item) {
            return $item->subtotal - ($item->harga_beli * $item->qty);
        });

        // Asumsi 'Tunai' adalah nama. Jika Anda punya ID, itu lebih baik.
        $total_tunai = $footerData->filter(function ($item) {
            return optional(optional($item->penjualan)->pembayaran)->nama === 'Tunai';
        })->sum('subtotal');

        $total_kredit = $footerData->filter(function ($item) {
            return optional(optional($item->penjualan)->pembayaran)->nama !== 'Tunai';
        })->sum('subtotal');

        // Sesuai permintaan: Total Akhir = Sub Total (untuk saat ini)
        $total_akhir = $total_subtotal;


        // --- Query utama untuk DataTables (Berdasarkan PenjualanDetail) ---
        $data = $query->with([
            'penjualan:id,kode_transaksi,tanggal_penjualan,user_id,jenis_pembayaran_id',
            'penjualan.user:id,name',
            'penjualan.pembayaran:id,nama',
            'barang:id,kode_barang,nama',
        ])->select('penjualan_detail.*'); // Ambil semua data dari detail


        return \DataTables::of($data)
            ->addIndexColumn()
            // 1. Tanggal Transaksi
            ->addColumn('tanggal', function ($detail) {
                return $detail->penjualan ? Carbon::parse($detail->penjualan->tanggal_penjualan)->translatedFormat('d-m-Y') : '-';
            })
            // 2. Nomor Transaksi
            ->addColumn('kode_transaksi', function ($detail) {
                return $detail->penjualan->kode_transaksi ?? '-';
            })
            // 3. List Barang (Nama Barang)
            ->addColumn('nama_barang', function ($detail) {
                return optional($detail->barang)->nama ?? 'N/A';
            })
            // 4. Qty (sudah ada di $detail->qty)
            // ===================================
            // BARU: Kolom Harga Jual
            // ===================================
            ->addColumn('harga_jual_fmt', function ($detail) {
                return 'Rp ' . number_format($detail->harga_jual, 0, ',', '.');
            })
            // 6. Harga Beli
            ->addColumn('harga_beli_fmt', function ($detail) {
                return 'Rp ' . number_format($detail->harga_beli, 0, ',', '.');
            })
            // 7. Sub Total
            ->addColumn('sub_total_fmt', function ($detail) {
                return 'Rp ' . number_format($detail->subtotal, 0, ',', '.');
            })
            // 8. Profit
            ->addColumn('profit', function ($detail) {
                $profit = $detail->subtotal - ($detail->harga_beli * $detail->qty);
                return 'Rp ' . number_format($profit, 0, ',', '.');
            })
            // 9. Potongan
            ->addColumn('potongan', function ($detail) {
                return 0; // Sesuai permintaan
            })
            // 10. Pajak
            ->addColumn('pajak', function ($detail) {
                return 0; // Sesuai permintaan
            })
            // 11. Biaya Lain
            ->addColumn('biaya_lain', function ($detail) {
                return 0; // Sesuai permintaan
            })
            // 12. Total Akhir
            ->addColumn('total_akhir', function ($detail) {
                // Sesuai permintaan: (sub total - diskon - pajak - biaya lain)
                $total_akhir = $detail->subtotal - 0 - 0 - 0; // Hardcoded for now
                return 'Rp ' . number_format($total_akhir, 0, ',', '.');
            })
            // 13. Bayar Tunai
            ->addColumn('bayar_tunai', function ($detail) {
                if (optional(optional($detail->penjualan)->pembayaran)->nama === 'Tunai') {
                    return 'Rp ' . number_format($detail->subtotal, 0, ',', '.');
                }
                return '0';
            })
            // 14. Bayar Kredit
            ->addColumn('bayar_kredit', function ($detail) {
                if (optional(optional($detail->penjualan)->pembayaran)->nama !== 'Tunai') {
                    return 'Rp ' . number_format($detail->subtotal, 0, ',', '.');
                }
                return '0';
            })
            ->rawColumns([]) // Tidak ada raw HTML di data baris
            ->with([
                // Data Statistik Box Atas
                'total_transaksi' => $totalTransaksi,
                'total_penjualan' => $totalPendapatan,
                'jumlah_produk_terjual' => $jumlahProdukTerjual,

                // Data Footer & Summary Box
                'footer_total_item' => $jumlahProdukTerjual,
                'footer_subtotal' => $total_subtotal,
                'footer_profit' => $total_profit,
                'footer_potongan' => 0, // Hardcode
                'footer_pajak' => 0, // Hardcode
                'footer_biaya_lain' => 0, // Hardcode
                'footer_total_akhir' => $total_akhir,
                'footer_bayar_tunai' => $total_tunai,
                'footer_bayar_kredit' => $total_kredit,
            ])
            ->make(true);
    }

    // =======================================================
    // PERUBAHAN TOTAL: FUNGSI EXPORT
    // (Logika query disamakan dengan getLaporanData)
    // =======================================================
    public function export(Request $request)
    {
        // Validasi input
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:landscape',
            'tipe' => 'required|in:datatable',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // --- Query utama untuk PDF (Berdasarkan PenjualanDetail) ---
        $query = PenjualanDetail::query()
            ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$start, $end])
            ->with([
                'penjualan:id,kode_transaksi,tanggal_penjualan,user_id,jenis_pembayaran_id',
                'penjualan.user:id,name',
                'penjualan.pembayaran:id,nama',
                'barang:id,kode_barang,nama',
            ])
            ->select('penjualan_detail.*') // Must select detail columns
            ->orderBy('penjualan.tanggal_penjualan', 'asc');

        $penjualanDetails = $query->get(); // Ambil semua data

        // --- Kalkulasi Statistik & Footer ---
        $total_subtotal = $penjualanDetails->sum('subtotal');
        $total_profit = $penjualanDetails->sum(function ($item) {
            return $item->subtotal - ($item->harga_beli * $item->qty);
        });
        $jumlahProdukTerjual = $penjualanDetails->sum('qty');

        $total_tunai = $penjualanDetails->filter(function ($item) {
            return optional(optional($item->penjualan)->pembayaran)->nama === 'Tunai';
        })->sum('subtotal');

        $total_kredit = $penjualanDetails->filter(function ($item) {
            return optional(optional($item->penjualan)->pembayaran)->nama !== 'Tunai';
        })->sum('subtotal');

        $total_akhir = $total_subtotal; // Sesuai permintaan
        $totalTerbilang = $this->terbilang($total_akhir); // Ganti sumber terbilang

        $namaUser = Auth::user()->name;
        $tanggalCetak = Carbon::now();

        // --- Kirim data baru ke View PDF ---
        $data = compact(
            'penjualanDetails', // Variabel baru
            'jumlahProdukTerjual',
            'total_subtotal',
            'total_profit',
            'total_tunai',
            'total_kredit',
            'total_akhir',
            'totalTerbilang', // Variabel baru
            'start',
            'end',
            'namaUser',
            'tanggalCetak'
        );

        $viewPath = 'backend.laporan.laporan_penjualan_harian.';
        $viewName = '';

        switch ($request->tipe) {
            default:
                $viewName = 'laporan-data';
                break;
        }

        $pdf = Pdf::loadView($viewPath . $viewName, $data)
            ->setPaper($request->ukuran, $request->orientasi);

        return $pdf->stream('laporan_penjualan_harian-' . $request->tipe . '.pdf');
    }

    // Fungsi terbilang dan penyebut tidak berubah
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
