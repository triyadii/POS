<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\JenisPembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Str;
// use App\Models\Kas;


class PenjualanController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:kasir-list', ['only' => ['index', 'getData','store','historyData']]);
        $this->middleware('permission:daftar-penjualan-list', ['only' => ['daftarPenjualan','dataPenjualan']]);
    }
    public function index(Request $request)
    {
        $produk = Barang::all();
        $pembayaran = JenisPembayaran::all();
        return view('backend.apps.penjualan.index', [
            'no_penjualan' => $this->generateNoPenjualan(),
            'produk' => $produk,
            'pembayaran' => $pembayaran
        ]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // ✅ Buat ID baru manual
            $penjualanId = (string) Str::uuid();
            // Simpan ke tabel penjualan
            $penjualan = Penjualan::create([
                'id' => $penjualanId,
                'kode_transaksi' => $request->no_penjualan,
                'tanggal_penjualan' => $request->tanggal,
                'customer_nama' => $request->customer_nama,
                'jenis_pembayaran_id' => $request->pembayaran,
                'user_id' => auth()->id() ?? 'dummy-user',
                'total_item' => $request->total_item,
                'total_harga' => preg_replace('/[^\d]/', '', $request->total),
                'catatan' => $request->catatan,
            ]);


            // ✅ Simpan detail dengan penjualan_id yang pasti ada
            foreach ($request->items as $item) {
                PenjualanDetail::create([
                    'id' => (string) Str::uuid(),
                    'penjualan_id' => $penjualanId, // 👈 gunakan ID yang sudah dibuat
                    'barang_id' => $item['barang_id'],
                    'qty' => $item['qty'],
                    'harga_jual' => $item['harga_jual'],
                    'subtotal' => $item['subtotal'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
                $barang = Barang::find($item['barang_id']);
                if ($barang) {
                    $barang->stok -= $item['qty'];
                    $barang->save();
                }
            }


            DB::commit();
            // ✅ Generate kode transaksi berikutnya
            $nextNo = $this->generateNextNoPenjualan();
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan',
                'no_penjualan_baru' => $nextNo,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function historyData()
    {
        $penjualan = Penjualan::with([
            'detail.barang:id,nama',
            'pembayaran:id,nama' // ✅ relasi jenis_pembayaran
        ])
            ->select(
                'id',
                'kode_transaksi',
                'tanggal_penjualan',
                'customer_nama',
                'jenis_pembayaran_id', // ✅ tambahkan kolom ini!
                'total_item',
                'total_harga',
                'catatan'
            )
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        return response()->json($penjualan);
    }

    protected function generateNextNoPenjualan()
    {
        $kasirId = 'DB22';
        $tanggal = \Carbon\Carbon::now()->format('Ymd');
        $today = \Carbon\Carbon::now()->toDateString();

        // Ambil kode terakhir untuk hari ini dengan pola yang sama
        $lastPenjualan = \DB::table('penjualan')
            ->whereDate('created_at', $today)
            ->where('kode_transaksi', 'like', "{$kasirId}-{$tanggal}-%")
            ->orderByDesc('kode_transaksi')
            ->value('kode_transaksi');

        if ($lastPenjualan) {
            // Ambil 6 digit terakhir dari kode terakhir
            $lastNumber = (int) substr($lastPenjualan, -6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $urutan = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return "{$kasirId}-{$tanggal}-{$urutan}";
    }


    private function generateNoPenjualan()
    {
        $kasirId = 'DB22';
        $tanggal = Carbon::now()->format('Ymd');
        $today = Carbon::now()->toDateString();

        // Ambil no_penjualan terakhir hari ini
        $lastPenjualan = DB::table('penjualan')
            ->whereDate('created_at', $today)
            ->where('kode_transaksi', 'like', "{$kasirId}-{$tanggal}-%")
            ->orderByDesc('kode_transaksi')
            ->value('kode_transaksi');

        if ($lastPenjualan) {
            // Ekstrak angka urut dari no_penjualan terakhir
            $lastNumber = (int) substr($lastPenjualan, -6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $urutan = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return "{$kasirId}-{$tanggal}-{$urutan}";
    }
    public function daftarPenjualan()
    {
        // Menampilkan halaman daftar penjualan (list view)
        return view('backend.apps.penjualan.daftar');
    }

    public function dataPenjualan()
    {
        // Ambil data penjualan dengan relasi detail & barang
        $penjualan = Penjualan::with([
            'detail.barang:id,nama',
            'user:id,name'
        ])
            ->select(
                'id',
                'kode_transaksi',
                'tanggal_penjualan',
                'customer_nama',
                'total_item',
                'total_harga',
                'catatan',
                'user_id'
            )
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        return response()->json($penjualan);
    }
    public function generateNoTransaksi()
    {
        $prefix = 'DB22';
        $tanggal = now()->format('Ymd');

        $countHariIni = \App\Models\Penjualan::whereDate('created_at', now())->count() + 1;
        $kode = sprintf('%s-%s-%06d', $prefix, $tanggal, $countHariIni);

        return response()->json(['no_penjualan' => $kode]);
    }
    public function produkData()
    {
        $produk = Barang::select('id', 'nama', 'harga_jual', 'stok')
            ->with('kategori:id,nama')
            ->get();

        return response()->json($produk);
    }
}
