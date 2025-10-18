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
        $this->middleware('permission:kasir-list', ['only' => ['index', 'getData', 'store', 'historyData']]);
        $this->middleware('permission:daftar-penjualan-list', ['only' => ['daftarPenjualan', 'dataPenjualan']]);
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

        $validator = \Validator::make($request->all(), [
            'no_penjualan' => 'required|string|max:50',
            'tanggal'      => 'required|date',
            'customer'     => 'required|string|max:150',
            'pembayaran'   => 'required|uuid|exists:jenis_pembayaran,id',
            'items'        => 'required|array|min:1',
            'items.*.barang_id' => 'required|uuid|exists:barang,id',
            'items.*.qty'       => 'required|numeric|min:1',
        ], [
            'no_penjualan.required' => 'Nomor penjualan wajib diisi.',
            'tanggal.required'      => 'Tanggal penjualan wajib diisi.',
            'customer.required'     => 'Nama customer wajib diisi.',
            'pembayaran.required'   => 'Jenis pembayaran wajib dipilih.',
            'pembayaran.exists'     => 'Jenis pembayaran tidak valid.',
            'items.required'        => 'Daftar produk tidak boleh kosong.',
            'items.min'             => 'Minimal 1 produk harus dipilih.',
            'items.*.barang_id.required' => 'Setiap item wajib memiliki barang.',
            'items.*.barang_id.exists'   => 'Barang tidak ditemukan di database.',
            'items.*.qty.required'       => 'Jumlah qty wajib diisi.',
            'items.*.qty.min'            => 'Qty minimal 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }


        DB::beginTransaction();
        try {
            // ✅ Buat ID baru manual
            $penjualanId = (string) Str::uuid();
            // Simpan ke tabel penjualan
            $penjualan = Penjualan::create([
                'id' => $penjualanId,
                'kode_transaksi' => $request->no_penjualan,
                'tanggal_penjualan' => $request->tanggal,
                'customer_nama' => $request->customer,
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
                    'harga_beli' => $item['harga_beli'],
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
        $today = Carbon::today()->toDateString();
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
            ->whereDate('tanggal_penjualan', $today)
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

    public function dataPenjualan(Request $request)
    {
        // Ambil data penjualan dengan relasi detail & barang
        $penjualan = Penjualan::with([
            'detail.barang:id,nama',
            'user:id,name',
            'jenis_pembayaran:id,nama'
        ])
            ->select(
                'id',
                'kode_transaksi',
                'tanggal_penjualan',
                'customer_nama',
                'jenis_pembayaran_id',
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
    public function getJenisPembayaran()
    {
        $list = JenisPembayaran::select('id', 'nama')->orderBy('nama')->get();
        return response()->json($list);
    }
    // Ambil daftar penjualan (untuk DataTable + filter)
    public function getData(Request $request)
    {
        $query = Penjualan::with([
            'jenis_pembayaran:id,nama',
            'detail.barang:id,nama,kode_barang'
        ]);

        // Filter metode pembayaran (tidak wajib)
        if (!empty($request->metode_pembayaran)) {
            $query->whereHas('jenis_pembayaran', function ($q) use ($request) {
                $q->where('nama', $request->metode_pembayaran);
            });
        }

        // Filter nama barang
        if (!empty($request->barang)) {
            $keyword = strtolower($request->barang);
            $query->whereHas('detail.barang', function ($q) use ($keyword) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$keyword}%"]);
            });
        }

        // Filter tanggal
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
        } elseif (!empty($request->start_date)) {
            $query->whereDate('tanggal_penjualan', '>=', $request->start_date);
        } elseif (!empty($request->end_date)) {
            $query->whereDate('tanggal_penjualan', '<=', $request->end_date);
        }

        // Pencarian global (bisa berdiri sendiri)
        if (!empty($request->search)) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_transaksi) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(customer_nama) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(catatan) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('jenis_pembayaran', fn($sub) => $sub->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"]))
                    ->orWhereHas('detail.barang', fn($sub) => $sub->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"]));
            });
        }

        $data = $query->latest()->get();

        // Tambahkan nama barang
        $data->transform(function ($p) {
            $p->nama_barang = $p->detail
                ->map(fn($d) => $d->barang->nama ?? $d->barang->kode_barang ?? '-')
                ->unique()
                ->join(', ');
            return $p;
        });

        return response()->json(['data' => $data]);
    }


    // Detail penjualan by ID
    public function getDetail(Request $request)
    {
        $penjualan = Penjualan::with(['detail.barang'])->find($request->id);
        return response()->json($penjualan);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id'                   => 'required|uuid|exists:penjualan,id',
            'customer'             => 'nullable|string|max:150',
            'jenis_pembayaran_id'  => 'nullable|uuid|exists:jenis_pembayaran,id',
            'catatan'              => 'nullable|string|max:500',
            'items'                => 'array',
            'items.*.id'           => 'nullable|string', // uuid untuk existing, "new-xxx" untuk baru
            'items.*.barang_id'    => 'nullable|uuid|exists:barang,id',
            'items.*.qty'          => 'required|integer|min:1',
            'items.*.harga_jual'   => 'nullable|integer|min:0',
            'items.*.hapus'        => 'nullable' // <-- jangan boolean keras; kita normalize manual
        ]);

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::with('detail')->lockForUpdate()->findOrFail($request->id);

            // Normalisasi items
            $items = collect($request->input('items', []))->map(function ($row) {
                $row['qty']        = (int)($row['qty'] ?? 0);
                $row['harga_jual'] = isset($row['harga_jual']) ? (int)$row['harga_jual'] : null;
                // konversi "hapus" ke boolean aman
                $row['hapus'] = filter_var($row['hapus'] ?? false, FILTER_VALIDATE_BOOLEAN);
                return $row;
            });

            // index detail lama by id
            $oldDetails = $penjualan->detail->keyBy('id');

            foreach ($items as $row) {
                $detailId  = $row['id'] ?? null;
                $barangId  = $row['barang_id'] ?? null;
                $qtyBaru   = max(1, (int)$row['qty']);

                // ==== A) UPDATE / HAPUS detail existing ====
                if ($detailId && Str::isUuid($detailId) && $oldDetails->has($detailId)) {
                    /** @var PenjualanDetail $detail */
                    $detail = $oldDetails[$detailId];

                    if ($row['hapus'] === true) {
                        // kembalikan stok lama, lalu hapus detail
                        Barang::where('id', $detail->barang_id)->increment('stok', $detail->qty);
                        $detail->delete();
                        continue;
                    }

                    // update qty & stok via delta
                    $delta = $detail->qty - $qtyBaru; // + berarti stok dikembalikan, - berarti stok dikurangi lagi
                    if ($delta !== 0) {
                        Barang::where('id', $detail->barang_id)->increment('stok', $delta);
                    }

                    $harga = $detail->harga_jual; // harga existing dipakai jika tidak diubah
                    if (!is_null($row['harga_jual'])) {
                        $harga = (int)$row['harga_jual'];
                    }

                    $detail->qty      = $qtyBaru;
                    $detail->harga_jual = $harga;
                    $detail->subtotal = $harga * $qtyBaru;
                    $detail->save();
                    continue;
                }

                // ==== B) TAMBAH detail baru ====
                if ($barangId) {
                    $barang = Barang::findOrFail($barangId);
                    $harga  = !is_null($row['harga_jual']) ? (int)$row['harga_jual'] : (int)$barang->harga_jual;

                    if ($barang->stok < $qtyBaru) {
                        throw new \RuntimeException("Stok {$barang->nama} tidak cukup.");
                    }

                    $barang->decrement('stok', $qtyBaru);

                    PenjualanDetail::create([
                        'id'           => (string) Str::uuid(),
                        'penjualan_id' => $penjualan->id,
                        'barang_id'    => $barang->id,
                        'qty'          => $qtyBaru,
                        'harga_beli'   => 0,
                        'harga_jual'   => $harga,
                        'subtotal'     => $harga * $qtyBaru,
                    ]);
                }
                // Catatan penting: kita TIDAK menghapus detail yang tidak disebut di payload.
            }

            // Update header penjualan
            if ($request->filled('customer')) {
                $penjualan->customer_nama = $request->customer;
            }
            if ($request->filled('jenis_pembayaran_id')) {
                $penjualan->jenis_pembayaran_id = $request->jenis_pembayaran_id;
            }
            if ($request->filled('catatan')) {
                $penjualan->catatan = $request->catatan;
            }

            // Recalculate total
            $penjualan->load('detail');
            $penjualan->total_item  = (int)$penjualan->detail->sum('qty');
            $penjualan->total_harga = (int)$penjualan->detail->sum('subtotal');
            $penjualan->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Penjualan berhasil diperbarui']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }
    public function hapus(Request $request)
    {
        $penjualan = Penjualan::with('detail.barang')->find($request->id);

        if (!$penjualan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data penjualan tidak ditemukan.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok barang
            foreach ($penjualan->detail as $detail) {
                if ($detail->barang) {
                    $detail->barang->stok += $detail->qty;
                    $detail->barang->save();
                }
            }

            // Hapus detail & penjualan
            $penjualan->detail()->delete();
            $penjualan->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data penjualan berhasil dihapus dan stok dikembalikan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
