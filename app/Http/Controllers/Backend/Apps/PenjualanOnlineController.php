<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;

use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

use Validator;

use App\Models\PenjualanDetail;
use Illuminate\Support\Str;

class PenjualanOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:penjualan-online-list', ['only' => ['index','getData']]);
        $this->middleware('permission:penjualan-online-create', ['only' => ['store']]);
        $this->middleware('permission:penjualan-online-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:penjualan-online-delete', ['only' => ['destroy']]);
        $this->middleware('permission:penjualan-online-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.apps.penjualan_online.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Penjualan::where('kategori_penjualan','=','online')->orderBy('created_at', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('kode_transaksi', 'LIKE', "%{$searchValue}%");
            });
        }
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()
        ->addColumn('action', function($data) {
            return '

           


            <div class="text-end">

              <!-- 🖨️ Print Struk -->
        <a href="'.route('penjualan.print', $data->id).'" 
            target="_blank"
            class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1 btn-print-struk" 
            data-id="'.$data->id.'" title="Print Struk">
            <i class="ki-outline ki-printer fs-2"></i>
        </a>


                <a href="#" 
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-show-brand" 
                    data-id="'.$data->id.'" >
                    <i class="ki-outline ki-eye fs-2"></i>
                </a>
                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                    id="getEditRowData" data-id="'.$data->id.'">
                    <i class="ki-outline ki-pencil fs-2"></i>
                </a>
                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" 
                   data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">
                    <i class="ki-outline ki-trash fs-2"></i>
                </a>
            </div>';
        })

         // 🔹 Kolom Total Item (format angka Indonesia + rata kanan)
        ->addColumn('total_item', function ($data) {
            $total = number_format($data->total_item ?? 0, 0, ',', '.');
            return '<div class="text-end fw-semibold">' . $total . ' item</div>';
        })

        // 🔹 Kolom Total Harga (format Rupiah Indonesia + rata kanan)
        ->addColumn('total_harga', function ($data) {
            $harga = number_format($data->total_harga ?? 0, 0, ',', '.');
            return '<div class="text-end fw-bold ">Rp. ' . $harga . '</div>';
        })


         ->addColumn('potongan', function ($data) {
            $potongan = number_format($data->potongan ?? 0, 0, ',', '.');
            return '<div class="text-end fw-bold text-danger">Rp. ' . $potongan . '</div>';
        })


        ->addColumn('tanggal_penjualan', function ($data) {
            $tanggal = $data->tanggal_penjualan
                ? \Carbon\Carbon::parse($data->tanggal_penjualan)->format('d/m/Y H:i')
                : '-';

            return '<div class="fw-bold ">' . e($tanggal) . '</div>';
        })


       

        ->addColumn('jenis_pembayaran_id', function ($row) {
                return '
                <div class="d-flex flex-column">
                    <span class="fw-bold text-gray-800">' . e($row->jenis_pembayaran->nama) . '</span>
                    <span class="text-muted fs-7">Rek. ' . e($row->jenis_pembayaran->no_rekening) . '</span>
                </div>
            ';
            })



        ->addColumn('kode_transaksi', function ($row) {
                return '
                <div class="d-flex flex-column">
                    <span class="fw-bold text-gray-800">' . e($row->kode_transaksi) . '</span>
                    <span class="text-muted fs-7">Penjualan : ' . e($row->kategori_penjualan) . '</span>
                </div>
            ';
            })


            ->addColumn('total', function ($row) {
    // Hitung total akhir (pastikan nilai null dianggap 0)
    $total = ($row->total_harga ?? 0) - ($row->potongan ?? 0);

    // Format ke Rupiah
    $formatted = number_format($total, 0, ',', '.');

    // Tampilkan HTML styled (rata kanan, warna biru Metronic)
    return '<div class="text-end fw-bold text-primary">Rp ' . $formatted . '</div>';
})





            ->rawColumns(['action','total_item','total_harga','tanggal_penjualan','jenis_pembayaran_id','potongan','kode_transaksi','total'])
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function print($id)
{
    $penjualan = Penjualan::with('detail.barang')->findOrFail($id);

    // view untuk struk
    return view('backend.apps.penjualan_online.print', compact('penjualan'));
}


     public function show($id)
{
    $data = Penjualan::findOrFail($id);
    return view('backend.apps.penjualan_online.show', compact('data'));
}


public function store(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    // 🧩 Validasi input nested repeater
    $validator = Validator::make($request->all(), [
        'penjualan_list' => 'required|array|min:1',
        'penjualan_list.*.jenis_pembayaran_id' => 'required|string|exists:jenis_pembayaran,id',
        'penjualan_list.*.barang_list' => 'required|array|min:1',
        'penjualan_list.*.barang_list.*.barang_id'  => 'required|string|exists:barang,id',
        'penjualan_list.*.barang_list.*.harga_jual' => 'required|string',
        'penjualan_list.*.barang_list.*.qty'        => 'required|numeric|min:1',
        'penjualan_list.*.barang_list.*.subtotal'   => 'required|string',
    ], [
        'penjualan_list.*.jenis_pembayaran_id.required' => 'Jenis pembayaran wajib dipilih.',
        'penjualan_list.*.jenis_pembayaran_id.exists'   => 'Jenis pembayaran tidak valid.',
        'penjualan_list.*.barang_list.*.barang_id.required' => 'Barang wajib dipilih.',
        'penjualan_list.*.barang_list.*.barang_id.exists'   => 'Barang tidak valid.',
        'penjualan_list.*.barang_list.*.qty.required'   => 'Qty wajib diisi.',
        'penjualan_list.*.barang_list.*.qty.min'        => 'Qty minimal 1.',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        DB::beginTransaction();

        // 🔁 Loop setiap transaksi penjualan
        foreach ($request->penjualan_list as $trx) {

            $total_harga = $this->cleanRupiah($trx['total_harga'] ?? 0);
            $potongan    = $this->cleanRupiah($trx['potongan'] ?? 0);
            $grand_total = $this->cleanRupiah($trx['grand_total'] ?? 0);

            // 🧠 Simpan header penjualan
            $penjualan = Penjualan::create([
                'id'                 => Str::uuid(),
                'kode_transaksi'     => $this->generateKodeTransaksi(),
                'tanggal_penjualan'  => now(),
                'user_id'            => Auth::id(),
                'jenis_pembayaran_id'=> $trx['jenis_pembayaran_id'],
                'total_item'         => count($trx['barang_list']),
                'total_harga'        => $total_harga,
                'potongan'           => $potongan,
                'grand_total'        => $grand_total,
                'kategori_penjualan' => 'online',
                'catatan'            => $trx['catatan'] ?? null,
            ]);

            // 🔹 Simpan detail & cek stok
            foreach ($trx['barang_list'] as $barang) {
                $barang_id = $barang['barang_id'];
                $qty       = (int) $barang['qty'];

                // 🧾 Ambil stok barang saat ini
                $barangModel = Barang::lockForUpdate()->find($barang_id);

                if (!$barangModel) {
                    throw new \Exception("Barang dengan ID $barang_id tidak ditemukan.");
                }

                if ($barangModel->stok <= 0) {
                    throw new \Exception("Stok barang '{$barangModel->nama}' kosong!");
                }

                if ($barangModel->stok < $qty) {
                    throw new \Exception("Stok barang '{$barangModel->nama}' tidak mencukupi. Sisa stok: {$barangModel->stok}");
                }

                // 🧮 Kurangi stok
                $barangModel->decrement('stok', $qty);

                // 💾 Simpan detail penjualan
                PenjualanDetail::create([
                    'id'           => Str::uuid(),
                    'penjualan_id' => $penjualan->id,
                    'barang_id'    => $barang_id,
                    'harga_jual'   => $this->cleanRupiah($barang['harga_jual']),
                    'qty'          => $qty,
                    'subtotal'     => $this->cleanRupiah($barang['subtotal']),
                ]);
            }

            // 🧠 Catat aktivitas
            activity('tambah penjualan')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($penjualan)
                ->withProperties(['penjualan_id' => $penjualan->id])
                ->log('Menambahkan transaksi penjualan baru.');
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data penjualan berhasil disimpan.',
            'time'    => $formattedTime,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error'        => 'Gagal menyimpan data: ' . $e->getMessage(),
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ], 500);
    }
}

// 🔹 Helper: bersihkan format rupiah
private function cleanRupiah($value)
{
    return (int) preg_replace('/[^\d]/', '', $value ?? 0);
}

// 🔹 Helper: generate kode transaksi otomatis
private function generateKodeTransaksi()
{
    $prefix = 'DB22-' . now()->format('Ymd');
    $last = Penjualan::where('kode_transaksi', 'like', "$prefix%")->count() + 1;
    return sprintf('%s-%04d', $prefix, $last);
}





//      public function store(Request $request)
//     {
//         $formattedTime = Carbon::now()->diffForHumans();

//         // 🧩 Validasi input nested repeater
//         $validator = Validator::make($request->all(), [
//     'penjualan_list' => 'required|array|min:1',
//     'penjualan_list.*.jenis_pembayaran_id' => 'required|string|exists:jenis_pembayaran,id',
//     'penjualan_list.*.barang_list' => 'required|array|min:1',
//     'penjualan_list.*.barang_list.*.barang_id'  => 'required|string|exists:barang,id',
//     'penjualan_list.*.barang_list.*.harga_jual' => 'required|string',
//     'penjualan_list.*.barang_list.*.qty'        => 'required|numeric|min:1',
//     'penjualan_list.*.barang_list.*.subtotal'   => 'required|string',
// ], [
//     'penjualan_list.*.jenis_pembayaran_id.required' => 'Jenis pembayaran wajib dipilih.',
//     'penjualan_list.*.jenis_pembayaran_id.exists'   => 'Jenis pembayaran tidak valid.',
//     'penjualan_list.*.barang_list.*.barang_id.required' => 'Barang wajib dipilih.',
//     'penjualan_list.*.barang_list.*.barang_id.exists'   => 'Barang tidak valid.',
//     'penjualan_list.*.barang_list.*.qty.required'   => 'Qty wajib diisi.',
// ]);


//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()]);
//         }

//         try {
//             DB::beginTransaction();

//             // 🔁 Loop setiap transaksi penjualan
//             foreach ($request->penjualan_list as $trx) {
//                 $total_harga = $this->cleanRupiah($trx['total_harga'] ?? 0);
//                 $potongan    = $this->cleanRupiah($trx['potongan'] ?? 0);
//                 $grand_total = $this->cleanRupiah($trx['grand_total'] ?? 0);

//                 // 🧠 Simpan Penjualan
//                 $penjualan = Penjualan::create([
//                     'id'                 => Str::uuid(),
//                     'kode_transaksi'     => $this->generateKodeTransaksi(),
//                     'tanggal_penjualan'  => now(),
//                     'user_id'            => Auth::id(),
//                     'jenis_pembayaran_id'=> $trx['jenis_pembayaran_id'],
//                     'total_item'         => count($trx['barang_list']),
//                     'total_harga'        => $total_harga,
//                     'potongan'           => $potongan,
//                     'grand_total'        => $grand_total,
//                     'kategori_penjualan' => 'online', // default, bisa diubah nanti
//                     'catatan'            => $trx['catatan'] ?? null,
//                 ]);

//                 // 🔹 Simpan Detail Barang
//                 foreach ($trx['barang_list'] as $barang) {
//                     PenjualanDetail::create([
//                         'id'            => Str::uuid(),
//                         'penjualan_id'  => $penjualan->id,
//                         'barang_id'     => $barang['barang_id'],
//                         'harga_jual'    => $this->cleanRupiah($barang['harga_jual']),
//                         'qty'           => $barang['qty'],
//                         'subtotal'      => $this->cleanRupiah($barang['subtotal']),
//                     ]);
//                 }

//                 // 🔹 Optional: Log aktivitas
//                 activity('tambah penjualan')
//                     ->causedBy(Auth::user() ?? null)
//                     ->performedOn($penjualan)
//                     ->withProperties(['penjualan_id' => $penjualan->id])
//                     ->log('Menambahkan transaksi penjualan baru.');
//             }

//             DB::commit();

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Data penjualan berhasil disimpan.',
//                 'time'    => $formattedTime,
//             ]);

//         } catch (\Exception $e) {
//             DB::rollBack();

//             return response()->json([
//                 'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
//                 'time'         => $formattedTime,
//                 'judul'        => 'Aplikasi Error',
//                 'errorMessage' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     // 🔹 Helper: bersihkan format rupiah
//     private function cleanRupiah($value)
//     {
//         return (int) preg_replace('/[^\d]/', '', $value ?? 0);
//     }

//     // 🔹 Helper: generate kode transaksi otomatis
//     private function generateKodeTransaksi()
//     {
//         $prefix = 'DB22-ONLINE-' . now()->format('Ymd');
//         $last = Penjualan::where('kode_transaksi', 'like', "$prefix%")->count() + 1;
//         return sprintf('%s-%04d', $prefix, $last);
//     }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $data = Penjualan::with(['detail.barang', 'jenis_pembayaran'])
        ->findOrFail($id);

    $html = view('backend.apps.penjualan_online.edit', compact('data'))->render();

    return response()->json(['html' => $html]);
}


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function update(Request $request, $id)
// {
//     $formattedTime = Carbon::now()->diffForHumans();

//     $validator = \Validator::make($request->all(), [
//         'jenis_pembayaran_id' => 'required|uuid|exists:jenis_pembayaran,id',
//         'barang_list' => 'required|array|min:1',
//         'barang_list.*.barang_id' => 'required|uuid|exists:barang,id',
//         'barang_list.*.harga_jual' => 'required|string',
//         'barang_list.*.qty' => 'required|numeric|min:1',
//         'barang_list.*.subtotal' => 'required|string',
//         'potongan' => 'nullable|string',
//     ], [
//         'jenis_pembayaran_id.required' => 'Jenis pembayaran wajib dipilih.',
//         'barang_list.required' => 'Minimal 1 barang harus ditambahkan.',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()]);
//     }

//     try {
//         \DB::beginTransaction();

//         // 🧾 Ambil penjualan lama + detail-nya
//         $penjualan = Penjualan::with('detail')->findOrFail($id);
//         $oldDetails = $penjualan->detail->keyBy('barang_id');

//         $total_harga = $this->cleanRupiah($request->input('total_harga'));
//         $potongan    = $this->cleanRupiah($request->input('potongan'));
//         $grand_total = $this->cleanRupiah($request->input('grand_total'));

//         // 🔹 Update header penjualan
//         $penjualan->update([
//             'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
//             'total_harga'         => $total_harga,
//             'potongan'            => $potongan,
//             'grand_total'         => $grand_total,
//             'catatan'             => $request->catatan,
//             'updated_at'          => now(),
//         ]);

//         $newDetails = collect($request->barang_list)->keyBy('barang_id');

//         // 1️⃣ Barang yang dihapus → stok dikembalikan
//         foreach ($oldDetails as $barang_id => $oldDetail) {
//             if (!$newDetails->has($barang_id)) {
//                 $barang = Barang::lockForUpdate()->find($barang_id);
//                 if ($barang) {
//                     $barang->increment('stok', $oldDetail->qty);
//                 }
//                 $oldDetail->delete();
//             }
//         }

//         // 2️⃣ Barang yang baru / diedit
//         foreach ($newDetails as $barang_id => $newDetail) {
//             $barang = Barang::lockForUpdate()->find($barang_id);
//             if (!$barang) {
//                 throw new \Exception("Barang dengan ID {$barang_id} tidak ditemukan.");
//             }

//             $qty_baru = (int)$newDetail['qty'];
//             $harga_jual = $this->cleanRupiah($newDetail['harga_jual']);
//             $subtotal = $this->cleanRupiah($newDetail['subtotal']);

//             if (isset($oldDetails[$barang_id])) {
//                 // Barang sudah ada sebelumnya
//                 $old_qty = (int)$oldDetails[$barang_id]->qty;

//                 // ⚖️ Jika qty berubah → sesuaikan stok
//                 if ($qty_baru != $old_qty) {
//                     $selisih = $qty_baru - $old_qty;
//                     // Jika selisih > 0 → kurangi stok, jika negatif → tambah stok
//                     if ($selisih > 0) {
//                         if ($barang->stok < $selisih) {
//                             throw new \Exception("Stok barang '{$barang->nama}' tidak mencukupi. Sisa stok: {$barang->stok}");
//                         }
//                         $barang->decrement('stok', $selisih);
//                     } elseif ($selisih < 0) {
//                         $barang->increment('stok', abs($selisih));
//                     }
//                 }

//                 // Update detail
//                 $oldDetails[$barang_id]->update([
//                     'harga_jual' => $harga_jual,
//                     'qty'        => $qty_baru,
//                     'subtotal'   => $subtotal,
//                 ]);

//             } else {
//                 // Barang baru ditambahkan → kurangi stok
//                 if ($barang->stok < $qty_baru) {
//                     throw new \Exception("Stok barang '{$barang->nama}' tidak mencukupi. Sisa stok: {$barang->stok}");
//                 }

//                 $barang->decrement('stok', $qty_baru);

//                 PenjualanDetail::create([
//                     'id'           => (string) \Str::uuid(),
//                     'penjualan_id' => $penjualan->id,
//                     'barang_id'    => $barang_id,
//                     'harga_jual'   => $harga_jual,
//                     'qty'          => $qty_baru,
//                     'subtotal'     => $subtotal,
//                 ]);
//             }
//         }

//         // 🧾 Update total_item
//         $penjualan->update(['total_item' => count($newDetails)]);

//         // 📜 Log aktivitas
//         activity('edit penjualan')
//             ->causedBy(\Auth::user() ?? null)
//             ->performedOn($penjualan)
//             ->withProperties(['penjualan_id' => $penjualan->id])
//             ->log('Mengubah transaksi penjualan.');

//         \DB::commit();

//         return response()->json([
//             'success' => 'Transaksi penjualan berhasil diperbarui.',
//             'time'    => $formattedTime,
//         ]);
//     } catch (\Exception $e) {
//         \DB::rollBack();
//         return response()->json([
//             'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
//             'time'         => $formattedTime,
//             'judul'        => 'Aplikasi Error',
//             'errorMessage' => $e->getMessage(),
//         ], 500);
//     }
// }

public function update(Request $request, $id)
{
    $formattedTime = Carbon::now()->diffForHumans();

    $validator = \Validator::make($request->all(), [
        'jenis_pembayaran_id' => 'required|uuid|exists:jenis_pembayaran,id',
        'barang_list' => 'required|array|min:1',
        'barang_list.*.detail_id'  => 'nullable|uuid',
        'barang_list.*.barang_id'  => 'required|uuid|exists:barang,id',
        'barang_list.*.harga_jual' => 'required|string',
        'barang_list.*.qty'        => 'required|numeric|min:1',
        'barang_list.*.subtotal'   => 'required|string',
        'potongan' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        $penjualan = Penjualan::with('detail')->findOrFail($id);

        $total_harga = $this->cleanRupiah($request->input('total_harga'));
        $potongan    = $this->cleanRupiah($request->input('potongan'));
        $grand_total = $this->cleanRupiah($request->input('grand_total'));

        // Header
        $penjualan->update([
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'total_harga'         => $total_harga,
            'potongan'            => $potongan,
            'grand_total'         => $grand_total,
            'catatan'             => $request->catatan,
        ]);

        // Index detail lama by ID
        $oldDetailsById = $penjualan->detail->keyBy('id');

        // Kumpulkan id detail yang masih ada di request (baris lama yang dipertahankan/diubah)
        $keepIds = collect($request->barang_list)
            ->pluck('detail_id')
            ->filter() // buang null/empty (baris baru tidak punya id)
            ->values();

        // 1) Detail lama yang dihapus → kembalikan stok & delete
        foreach ($oldDetailsById as $oldId => $oldDetail) {
            if (!$keepIds->contains($oldId)) {
                $barangOld = Barang::lockForUpdate()->find($oldDetail->barang_id);
                if ($barangOld) {
                    $barangOld->increment('stok', $oldDetail->qty);
                }
                $oldDetail->delete();
            }
        }

        // 2) Proses semua baris yang dikirim dari form
        $barangList = collect($request->barang_list);

        foreach ($barangList as $row) {
            $detailId   = $row['detail_id'] ?? null;
            $barangId   = $row['barang_id'];
            $qtyBaru    = (int) $row['qty'];
            $hargaJual  = $this->cleanRupiah($row['harga_jual']);
            $subtotal   = $this->cleanRupiah($row['subtotal']);

            if ($detailId && isset($oldDetailsById[$detailId])) {
                // === Baris lama (update) ===
                $old = $oldDetailsById[$detailId];

                $barangOld = Barang::lockForUpdate()->find($old->barang_id);
                $barangNew = Barang::lockForUpdate()->find($barangId);
                if (!$barangNew) throw new \Exception("Barang baru tidak ditemukan.");

                if ($old->barang_id !== $barangId) {
                    // Barang berubah → kembalikan stok yang lama, kurangi stok yang baru
                    if ($barangOld) {
                        $barangOld->increment('stok', $old->qty);
                    }
                    if ($barangNew->stok < $qtyBaru) {
                        throw new \Exception("Stok barang '{$barangNew->nama}' tidak mencukupi. Sisa stok: {$barangNew->stok}");
                    }
                    $barangNew->decrement('stok', $qtyBaru);

                } else {
                    // Barang sama → sesuaikan selisih qty
                    $selisih = $qtyBaru - (int)$old->qty;
                    if ($selisih > 0) {
                        if ($barangNew->stok < $selisih) {
                            throw new \Exception("Stok barang '{$barangNew->nama}' tidak mencukupi. Sisa stok: {$barangNew->stok}");
                        }
                        $barangNew->decrement('stok', $selisih);
                    } elseif ($selisih < 0) {
                        $barangNew->increment('stok', abs($selisih));
                    }
                }

                // Update detail lama
                $old->update([
                    'barang_id'  => $barangId,
                    'harga_jual' => $hargaJual,
                    'qty'        => $qtyBaru,
                    'subtotal'   => $subtotal,
                ]);

            } else {
                // === Baris baru (create) ===
                $barang = Barang::lockForUpdate()->find($barangId);
                if (!$barang) throw new \Exception("Barang tidak ditemukan.");
                if ($barang->stok < $qtyBaru) {
                    throw new \Exception("Stok barang '{$barang->nama}' tidak mencukupi. Sisa stok: {$barang->stok}");
                }
                $barang->decrement('stok', $qtyBaru);

                PenjualanDetail::create([
                    'id'           => (string) \Str::uuid(),
                    'penjualan_id' => $penjualan->id,
                    'barang_id'    => $barangId,
                    'harga_jual'   => $hargaJual,
                    'qty'          => $qtyBaru,
                    'subtotal'     => $subtotal,
                ]);
            }
        }

        // total_item
        $penjualan->update(['total_item' => PenjualanDetail::where('penjualan_id', $penjualan->id)->count()]);

        \DB::commit();

        return response()->json([
            'success' => 'Transaksi penjualan berhasil diperbarui.',
            'time'    => $formattedTime,
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();
        return response()->json([
            'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
            'judul'        => 'Aplikasi Error',
            'errorMessage' => $e->getMessage(),
            'time'         => $formattedTime,
        ], 422);
    }
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $formattedTime = Carbon::now()->diffForHumans();

    try {
        \DB::beginTransaction();

        $data = Brand::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus brand')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Brand: ' . $data->nama);

        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $data->nama . ' berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Data gagal dihapus.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}


public function massDelete(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    try {
        \DB::beginTransaction();

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada data yang dipilih untuk dihapus.',
            ]);
        }

        // Ambil semua data sebelum dihapus (untuk log)
        $records = Brand::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Brand::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete brand')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Brand: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data brand berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan saat menghapus data.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}



    public function select(Request $request)
        {
            $brand = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $brand = Brand::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $brand = Brand::limit(30)->get();
            }
            return response()->json($brand);
        }


}
