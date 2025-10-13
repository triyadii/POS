<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
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
    }
    public function index(Request $request)
    {
        $produk = Barang::all();
        return view('backend.apps.penjualan.index', [
            'no_penjualan' => $this->generateNoPenjualan(),
            'produk' => $produk,
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
                'user_id' => auth()->id() ?? 'dummy-user',
                'total_item' => $request->total_item,
                'total_harga' => $request->total_harga,
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
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function historyData()
    {
        $penjualan = \App\Models\Penjualan::with([
            'detail.barang' => function ($q) {
                $q->select('id', 'nama');
            }
        ])
            ->select('id', 'kode_transaksi', 'tanggal_penjualan', 'customer_nama', 'total_item', 'total_harga', 'catatan')
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();
        return response()->json($penjualan);
    }


    private function generateNoPenjualan()
    {
        $kasirId = 'WAA';
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
}
