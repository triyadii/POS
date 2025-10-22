<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\JenisPembayaran;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanHarianController extends Controller
{
    public function index(Request $request)
    {
        $jenisPembayaran = JenisPembayaran::select('id', 'nama')->get();
        return view('backend.laporan.laporan_penjualan_harian.index', compact('jenisPembayaran'));
    }

    /**
     * ==========================================================
     * PERUBAHAN BESAR: Query diubah ke tabel 'Penjualan' (Transaksi)
     * ==========================================================
     */
    public function getLaporanData(Request $request)
    {
        $query = Penjualan::query();
        $dateRangeExists = false;
        $jenisPembayaranId = $request->filter_jenis_pembayaran;

        $kategoriPenjualan = $request->filter_kategori_penjualan;

        if (!empty($request->filter_tanggal_start) && !empty($request->filter_tanggal_end)) {
            $startDate = Carbon::parse($request->filter_tanggal_start)->startOfDay();
            $endDate = Carbon::parse($request->filter_tanggal_end)->endOfDay();
            $dateRangeExists = true;

            $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        if (!empty($jenisPembayaranId)) {
            $query->where('jenis_pembayaran_id', $jenisPembayaranId);
        }

        if (!empty($kategoriPenjualan)) {
            $query->where('kategori_penjualan', $kategoriPenjualan);
        }

        // --- Statistik Box Atas & Footer ---
        // $statsQuery adalah query di tabel 'penjualan'
        $statsQuery = clone $query;

        $totalTransaksi = $dateRangeExists ? $statsQuery->count() : 0;
        $totalPendapatan = $dateRangeExists ? $statsQuery->sum('total_harga') : 0;

        // Ambil total potongan dari tabel Penjualan
        $total_potongan = $dateRangeExists ? $statsQuery->sum('potongan') : 0;

        // Ambil total Subtotal dari detail
        $total_subtotal = 0;
        $jumlahProdukTerjual = 0;
        $total_profit = 0;
        $total_biaya_lain = 0;
        $total_harga_beli = 0;

        if ($dateRangeExists) {
            $penjualanIds = (clone $statsQuery)->pluck('id');
            $details = PenjualanDetail::whereIn('penjualan_id', $penjualanIds)->get();

            $jumlahProdukTerjual = $details->sum('qty');
            $total_subtotal = $details->sum('subtotal');
            $total_harga_beli = $details->sum(function ($item) {
                return $item->harga_beli * $item->qty;
            });

            // Profit kotor = Subtotal Penjualan - Subtotal Harga Beli
            $total_profit = $total_subtotal - $total_harga_beli;
            $total_biaya_lain = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])->sum('total');
        }

        // $total_profit = $total_profit - $total_biaya_lain;
        $$total_profit = $total_profit - $total_biaya_lain; // Profit Bersih

        // ===================================
        // PERUBAHAN: Kalkulasi Total Akhir
        // ===================================
        $total_akhir = $total_subtotal - $total_potongan - $total_biaya_lain;

        // (Logika tunai/kredit perlu disesuaikan)
        $total_tunai = $dateRangeExists ? (clone $statsQuery)->whereHas('jenis_pembayaran', fn($q) => $q->whereRaw('LOWER(nama) = ?', ['tunai']))->sum('total_harga') : 0;
        $total_kredit = $dateRangeExists ? (clone $statsQuery)->whereHas('jenis_pembayaran', fn($q) => $q->whereRaw('LOWER(nama) != ?', ['tunai']))->sum('total_harga') : 0;


        // --- Query utama untuk DataTables ---
        $data = $query->with([
            'user:id,name',
            'jenis_pembayaran:id,nama',
        ])->select('penjualan.*');


        return \DataTables::of($data)
            ->addIndexColumn()
            // Kolom 1: Tombol Expander (Child Row)
            ->addColumn('expander', function ($data) {
                return '<button type="button" class="btn btn-sm btn-icon btn-light-primary btn-expand" data-id="' . $data->id . '"><i class="ki-outline ki-plus-square fs-3"></i></button>';
            })
            ->addColumn('tanggal', function ($data) {
                return Carbon::parse($data->tanggal_penjualan)->translatedFormat('d-m-Y');
            })
            ->addColumn('jenis_pembayaran', function ($data) {
                return optional($data->jenis_pembayaran)->nama ?? '-';
            })
            ->addColumn('kategori_penjualan', function ($data) {
                return ucwords($data->kategori_penjualan); // Format: 'offline' -> 'Offline'
            })
            ->addColumn('total_item', function ($data) {
                return $data->total_item; // Asumsi ada kolom total_item di tabel 'penjualan'
            })
            ->addColumn('sub_total_fmt', function ($data) {
                // Total Subtotal (Total Harga + Potongan)
                $subtotal = $data->total_harga + $data->potongan;
                return 'Rp ' . number_format($subtotal, 0, ',', '.');
            })
            ->addColumn('potongan_fmt', function ($data) {
                return 'Rp ' . number_format($data->potongan, 0, ',', '.');
            })
            ->addColumn('total_akhir_fmt', function ($data) {
                return 'Rp ' . number_format($data->total_harga, 0, ',', '.');
            })
            ->rawColumns(['expander', 'potongan_fmt'])
            ->with([
                'total_transaksi' => $totalTransaksi,
                'total_penjualan' => $totalPendapatan,
                'jumlah_produk_terjual' => $jumlahProdukTerjual,

                // Data Footer
                'footer_total_item' => $jumlahProdukTerjual,
                'footer_subtotal' => $total_subtotal,
                'footer_total_harga_beli' => $total_harga_beli,
                'footer_profit' => $total_profit, // Profit masih bisa dihitung
                'footer_potongan' => $total_potongan,
                'footer_pajak' => 0,
                'footer_biaya_lain' => $total_biaya_lain,
                'footer_total_akhir' => $total_akhir,
                'footer_bayar_tunai' => $total_tunai,
                'footer_bayar_kredit' => $total_kredit,
            ])
            ->make(true);
    }

    /**
     * ==========================================================
     * FUNGSI BARU: Untuk mengambil detail item (Child Row)
     * ==========================================================
     */
    public function getDetailItems(Request $request)
    {
        $request->validate(['id' => 'required|string']);

        $details = PenjualanDetail::where('penjualan_id', $request->id)
            ->with('barang:id,kode_barang,nama')
            ->get();

        // Render HTML untuk tabel anak
        $html = view('backend.laporan.laporan_penjualan_harian._partials.child-table', compact('details'))->render();

        return response()->json(['html' => $html]);
    }


    // FUNGSI EXPORT (Untuk saat ini, kita biarkan item-based)
    // Mengubah PDF ke transaction-based juga sangat kompleks
    public function export(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|in:A4,F4',
            'orientasi' => 'required|in:landscape',
            'tipe' => 'required|in:datatable',
            'start' => 'required|date',
            'end' => 'required|date',
            'jenis_pembayaran' => 'nullable|string',
            'kategori_penjualan' => 'nullable|string',
        ]);

        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();
        $jenisPembayaranId = $request->jenis_pembayaran;
        $kategoriPenjualan = $request->kategori_penjualan;

        $namaKategoriPenjualan = 'Semua';
        if (!empty($kategoriPenjualan)) {
            $namaKategoriPenjualan = ucwords($kategoriPenjualan); // 'offline' -> 'Offline'
        }

        $namaJenisPembayaran = 'Semua';
        if (!empty($jenisPembayaranId)) {
            $jenis_pembayaran = JenisPembayaran::find($jenisPembayaranId);
            if ($jenis_pembayaran) {
                $namaJenisPembayaran = $jenis_pembayaran->nama;
            }
        }

        // ===================================
        // PERUBAHAN: Query utama diubah ke 'Penjualan'
        // ===================================
        $query = Penjualan::query()
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->with([
                'user:id,name',
                'jenis_pembayaran:id,nama',
                'detail', // Eager load detail item
                'detail.barang:id,kode_barang,nama' // Eager load barang dari detail
            ])
            ->orderBy('tanggal_penjualan', 'asc');

        if (!empty($jenisPembayaranId)) {
            $query->where('jenis_pembayaran_id', $jenisPembayaranId);
        }

        if (!empty($kategoriPenjualan)) {
            $query->where('kategori_penjualan', $kategoriPenjualan);
        }

        // Variabel baru untuk view (daftar transaksi)
        $penjualanTransactions = $query->get();

        // --- Kalkulasi Statistik & Footer (Logika ini tetap diperlukan) ---
        // Kita ambil detail dari transaksi yang sudah di-load
        $penjualanDetails = $penjualanTransactions->pluck('detail')->flatten();

        $total_subtotal = $penjualanDetails->sum('subtotal');
        $total_harga_beli = $penjualanDetails->sum(function ($item) {
            return $item->harga_beli * $item->qty;
        });
        $total_profit_kotor = $total_subtotal - $total_harga_beli;
        $jumlahProdukTerjual = $penjualanDetails->sum('qty');

        // Ambil total potongan dari tabel 'penjualan'
        $total_potongan = $penjualanTransactions->sum('potongan');

        $total_biaya_lain = Pengeluaran::whereBetween('tanggal', [$start, $end])->sum('total');

        // <-- PERUBAHAN 7: Kalkulasi ulang profit bersih
        $total_profit = $total_profit_kotor - $total_biaya_lain;

        // Logika tunai/kredit berdasarkan transaksi, bukan detail
        $total_tunai = $penjualanTransactions->filter(function ($trx) {
            // Ubah nama menjadi huruf kecil sebelum membandingkan
            return strtolower(optional($trx->jenis_pembayaran)->nama) === 'tunai';
        })->sum('total_harga');

        $total_kredit = $penjualanTransactions->filter(function ($trx) {
            // Ubah nama menjadi huruf kecil sebelum membandingkan
            return strtolower(optional($trx->jenis_pembayaran)->nama) !== 'tunai';
        })->sum('total_harga');

        $total_akhir = $total_subtotal - $total_potongan - $total_biaya_lain;
        $totalTerbilang = $this->terbilang($total_akhir);

        $namaUser = Auth::user()->name;
        $tanggalCetak = Carbon::now();

        $data = compact(
            'penjualanTransactions', // <-- Variabel baru dikirim ke view
            'jumlahProdukTerjual',
            'total_subtotal',
            'total_harga_beli',
            'total_profit',
            'total_potongan',
            'total_biaya_lain',
            'total_tunai',
            'total_kredit',
            'total_akhir',
            'totalTerbilang',
            'start',
            'end',
            'namaUser',
            'tanggalCetak',
            'namaJenisPembayaran',
            'namaKategoriPenjualan'
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

    // ... (fungsi terbilang dan penyebut tidak berubah) ...
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
