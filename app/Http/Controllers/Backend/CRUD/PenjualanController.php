<?php

namespace App\Http\Controllers\Backend\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\StrukSetting;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Kas;


class PenjualanController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }



    public function index(Request $request)
    {
        // $today = \Carbon\Carbon::today()->toDateString();
        // $kas = \App\Models\Kas::whereDate('tanggal', $today)->first();
        return view('backend.crud.penjualan.index', [
            'no_penjualan' => $this->generateNoPenjualan(),
            // 'kas' => $kas
        ]);
    }






    // public function cetakStruk($id)
    // {
    //     $penjualan = Penjualan::where('no_penjualan', $id)
    //         ->with(['details.produk', 'meja', 'customer'])
    //         ->firstOrFail();

    //     $setting = StrukSetting::first();

    //     return view('backend.crud.penjualan.struk', compact('penjualan', 'setting'));
    // }


    //      public function store(Request $request)
    //     {
    //         $formattedTime = Carbon::now()->diffForHumans();

    //         // Validasi data utama dan produk
    //         $validator = \Validator::make($request->all(), [
    //             'no_penjualan'   => 'required|string|max:255|unique:penjualan,no_penjualan',
    //             'customer_id'    => 'required|exists:customer,id',
    //             'meja_id'    => 'required|exists:meja,id',
    //             'tanggal'        => 'required|date',
    //             'total'          => 'required|numeric|min:1',
    //             'uang_diterima'  => 'required|numeric|min:0',
    //             'kembalian'      => 'nullable|numeric|min:0',
    //             'pembayaran'     => 'required|in:cash,transfer,hutang',
    //             'produk'         => 'required|array|min:1',

    //             // Validasi tiap item produk
    //             'produk.*.produk_id'   => 'required|exists:produk,id',
    //             'produk.*.quantity'    => 'required|integer|min:1',

    //             'produk.*.expired_at'  => 'nullable|date',

    //         ], [
    //             'no_penjualan.required' => 'Nomor penjualan wajib diisi.',
    //             'no_penjualan.unique' => 'Nomor penjualan sudah digunakan.',
    //             'customer_id.required' => 'Customer wajib dipilih.',
    //             'customer_id.exists' => 'Customer tidak valid.',
    //             'meja_id.required' => 'Meja wajib dipilih.',
    //             'meja_id.exists' => 'Meja tidak valid.',
    //             'tanggal.required' => 'Tanggal wajib diisi.',
    //             'tanggal.date' => 'Format tanggal tidak valid.',
    //             'total.required' => 'Total wajib diisi.',
    //             'total.numeric' => 'Total harus berupa angka.',
    //             'total.min' => 'Total minimal Rp1.',
    //             'uang_diterima.required' => 'Uang diterima wajib diisi.',
    //             'uang_diterima.numeric' => 'Uang diterima harus berupa angka.',
    //             'uang_diterima.min' => 'Uang diterima minimal Rp0.',
    //             'kembalian.numeric' => 'Kembalian harus berupa angka.',
    //             'kembalian.min' => 'Kembalian tidak boleh negatif.',
    //             'pembayaran.required' => 'Metode pembayaran wajib dipilih.',
    //             'pembayaran.in' => 'Metode pembayaran tidak valid.',
    //             'produk.required' => 'Produk minimal 1 harus ditambahkan.',
    //             'produk.*.produk_id.required' => 'Produk harus dipilih.',
    //             'produk.*.produk_id.exists' => 'Produk tidak ditemukan.',
    //             'produk.*.quantity.required' => 'Quantity wajib diisi.',
    //             'produk.*.quantity.integer' => 'Quantity harus angka bulat.',

    //         ]);






    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         DB::beginTransaction();
    //         try {
    //             $penjualan = new Penjualan();
    //             $penjualan->id = Str::orderedUuid();
    //             $penjualan->no_penjualan = $request->no_penjualan;
    //             $penjualan->customer_id = $request->customer_id;
    //             $penjualan->meja_id = $request->meja_id;
    //             $penjualan->uang_diterima = $request->uang_diterima;
    //             $penjualan->kembalian = $request->kembalian;
    //             $penjualan->total = $request->total;
    //             $penjualan->pembayaran = $request->pembayaran;
    //             $penjualan->catatan = $request->catatan;
    //             $penjualan->tanggal = $request->tanggal;
    //             $penjualan->user_id = auth()->id();
    //             $penjualan->save();

    //             foreach ($request->produk as $item) {
    //                 $produk = Produk::findOrFail($item['produk_id']);

    //                 PenjualanDetail::create([
    //                     'id' => Str::uuid(),
    //                     'penjualan_id' => $penjualan->id,
    //                     'produk_id' => $produk->id,
    //                     'quantity' => $item['quantity'],
    //                     'harga_jual' => $item['harga_jual'],
    //                     'subtotal' => $item['harga_jual'] * $item['quantity'],
    //                 ]);


    //                 $produk->save();
    //             }


    //             // Ambil kas aktif hari ini
    //             $kas = \App\Models\Kas::whereDate('tanggal', now()->toDateString())->first();

    //             // Validasi kasir masih aktif (belum ditutup)
    //             if (!$kas || $kas->kasir_tutup_at !== null) {
    //                 throw new \Exception('Kasir belum dibuka atau sudah ditutup. Penjualan tidak dapat diproses.');
    //             }

    //             // Simpan ke kas_transaksi
    //             \App\Models\KasTransaksi::create([
    //                 'id' => Str::uuid(),
    //                 'kas_id' => $kas->id,
    //                 'sumber' => 'penjualan',
    //                 'ref_id' => $penjualan->id,
    //                 'keterangan' => 'Penjualan #' . $penjualan->no_penjualan,
    //                 'nominal' => $penjualan->total,
    //                 'tipe' => 'masuk',
    //             ]);

    //             activity('tambah penjualan')
    //                 ->causedBy(auth()->user())
    //                 ->performedOn($penjualan)
    //                 ->withProperties(['attributes' => $penjualan])
    //                 ->log('Membuat penjualan dengan nomor ' . $penjualan->no_penjualan);

    //             DB::commit();

    //             return response()->json([
    //                 'success' => 'Data berhasil disimpan.',
    //                 'time' => $formattedTime,
    //                 'judul' => 'Berhasil',
    //                     'no_penjualan' => $penjualan->no_penjualan, // INI YANG DIPAKAI UNTUK STRUK

    //                 'no_penjualan_baru' => $this->generateNoPenjualan(), 
    //             ]);
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             return response()->json([
    //                 'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //                 'time' => $formattedTime,
    //                 'judul' => 'Gagal'
    //             ], 500);
    //         }
    //     }


    private function generateNoPenjualan()
    {
        $kasirId = 'WAA'; // bisa juga pakai: auth()->user()->kode_kasir ?? 'PB';
        $tanggal = Carbon::now()->format('Ymd');
        $today = Carbon::now()->toDateString();

        $countHariIni = DB::table('penjualan')
            ->whereDate('created_at', $today)
            ->count() + 1;

        $urutan = str_pad($countHariIni, 6, '0', STR_PAD_LEFT);

        return "{$kasirId}-{$tanggal}-{$urutan}";
    }

    //     // public function apiGenerateNoPenjualan()
    //     // {
    //     //     return response()->json([
    //     //         'no_penjualan' => $this->generateNoPenjualan(),
    //     //     ]);
    //     // }

    //    private function generateNoPenjualan()
    // {
    //     $kasirId = 'WAA';
    //     $tanggal = Carbon::now()->format('Ymd');
    //     $today = Carbon::now()->toDateString();

    //     // Ambil no_penjualan terakhir hari ini
    //     $lastPenjualan = DB::table('penjualan')
    //         ->whereDate('created_at', $today)
    //         ->where('no_penjualan', 'like', "{$kasirId}-{$tanggal}-%")
    //         ->orderByDesc('no_penjualan')
    //         ->value('no_penjualan');

    //     if ($lastPenjualan) {
    //         // Ekstrak angka urut dari no_penjualan terakhir
    //         $lastNumber = (int) substr($lastPenjualan, -6);
    //         $nextNumber = $lastNumber + 1;
    //     } else {
    //         $nextNumber = 1;
    //     }

    //     $urutan = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

    //     return "{$kasirId}-{$tanggal}-{$urutan}";
    // }



}
