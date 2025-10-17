<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\Barang;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth; 
use Validator;


class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:barang-masuk-list', ['only' => ['index','getData']]);
        $this->middleware('permission:barang-masuk-create', ['only' => ['store']]);
        $this->middleware('permission:barang-masuk-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:barang-masuk-delete', ['only' => ['destroy']]);
        $this->middleware('permission:barang-masuk-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.apps.barang_masuk.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = BarangMasuk::orderBy('created_at', 'desc');
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
            $urlShow  = route('barang-masuk.show', $data->id);
            $urlPrint = route('barang-masuk.print', $data->id);
        
            // === Tombol Print ===
            $printBtn = $data->status === 'final'
                ? '<a href="'.$urlPrint.'" target="_blank" 
                        class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1" 
                        title="Cetak / Print">
                        <i class="ki-outline ki-printer fs-2"></i>
                    </a>'
                : '';
        
            // === Tombol Edit & Hapus hanya muncul kalau belum final ===
            $editBtn = '';
            $deleteBtn = '';
        
            if ($data->status !== 'final') {
                $editBtn = '
                    <a href="#" 
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                        id="getEditRowData" data-id="'.$data->id.'" title="Edit">
                        <i class="ki-outline ki-pencil fs-2"></i>
                    </a>';
        
                $deleteBtn = '
                    <a href="#" 
                       class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" 
                       data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" 
                       id="getDeleteId" title="Hapus">
                        <i class="ki-outline ki-trash fs-2"></i>
                    </a>';
            }
        
            // === Return tombol gabungan ===
            return '
                <div class="text-end">
                    <a href="'.$urlShow.'" 
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                        title="Lihat Detail">
                        <i class="ki-outline ki-delivery-2 fs-2"></i>
                    </a>
                    '.$editBtn.'
                    '.$printBtn.'
                    '.$deleteBtn.'
                </div>';
        })
        
        
        

         ->addColumn('supplier_id', function ($row) {
            return $row->supplier ? e($row->supplier->nama) : '<span class="badge bg-danger">Tidak ada supplier</span>';
        })
       

        // 🔹 Kolom Total Item (format angka Indonesia + rata kanan)
        ->addColumn('total_item', function ($row) {
            $total = number_format($row->total_item ?? 0, 0, ',', '.');
            return '<div class="text-end fw-semibold">' . $total . '</div>';
        })

        // 🔹 Kolom Total Harga (format Rupiah Indonesia + rata kanan)
        ->addColumn('total_harga', function ($row) {
            $harga = number_format($row->total_harga ?? 0, 0, ',', '.');
            return '<div class="text-end fw-bold text-success">Rp ' . $harga . '</div>';
        })

        // 🔹 Kolom Status
        ->addColumn('status', function ($row) {
            $status = $row->status ?? 'draft';
            $badgeClass = $status === 'final'
                ? 'badge-light-success'
                : 'badge-light-warning';
            $label = ucfirst($status);

            return '<span class="badge fw-semibold ' . $badgeClass . '">' . $label . '</span>';
        })

        

           
        ->rawColumns(['supplier_id', 'total_item', 'total_harga', 'status', 'action'])
            ->make(true);
    }
    

     public function show($id)
     {
         $data = BarangMasuk::with(['supplier', 'detail.barang'])->findOrFail($id);
     
         return view('backend.apps.barang_masuk.show', compact('data'));
     }


     ////==================DETAIL=====================////
     
     public function getDetailList($id)
     {
         $details = BarangMasukDetail::with(['barang.kategori', 'barang.brand', 'barang.tipe'])
             ->where('barang_masuk_id', $id)
             ->orderBy('created_at', 'desc');
     
         return \DataTables::of($details)
             ->addIndexColumn()
     
             // 🔹 Kolom Barang (nama + kode)
             ->addColumn('barang_info', function ($row) {
                 $nama = e($row->barang?->nama ?? '-');
                 $kode = e($row->barang?->kode_barang ?? '-');
     
                 return '
                     <div class="d-flex align-items-center">
                         <div class="d-flex flex-column">
                             <span class="fw-bold text-gray-800">' . $nama . '</span>
                             <span class="text-muted fs-7">Kode: ' . $kode . '</span>
                         </div>
                     </div>
                 ';
             })
     
             // 🔹 Kolom Kategori
             ->addColumn('kategori', function ($row) {
                 $kategori = $row->barang?->kategori?->nama ?? '-';
                 if ($kategori === '-') {
                     return '<span class="badge badge-light-danger">Tidak ada</span>';
                 }
     
                 // Warna dinamis berdasarkan hash nama kategori
                 $hash = substr(md5(strtolower($kategori)), 0, 6);
                 $badgeColor = '#' . $hash;
     
                 return '<span class="badge fw-semibold" style="background-color:' . $badgeColor . '; color:#fff;">' . e($kategori) . '</span>';
             })
     
             // 🔹 Kolom Brand & Tipe
             ->addColumn('brand_tipe', function ($row) {
                 $brand = e($row->barang?->brand?->nama ?? '-');
                 $tipe = e($row->barang?->tipe?->nama ?? '-');
     
                 return '
                     <div class="d-flex flex-column">
                         <span class="fw-semibold text-gray-800">' . $brand . '</span>
                         <span class="text-muted fs-7">Tipe: ' . $tipe . '</span>
                     </div>
                 ';
             })
     
             // 🔹 Kolom Size
             ->addColumn('size', function ($row) {
                 $size = e($row->barang?->size ?? '-');
                 return '<span class="badge badge-secondary">' . $size . '</span>';
             })
     
             // 🔹 Kolom Qty
->addColumn('qty', function ($row) {
    return '
        <div class="text-end">
            <span class="fw-bold">' . number_format($row->qty, 0, ',', '.') . '</span>
        </div>
    ';
})

// 🔹 Kolom Harga Beli (editable)
->addColumn('harga_beli', function ($row) {
    return '
        <div class="text-end">
            <span class="editable-price text-primary fw-bold"
                  data-id="' . $row->id . '"
                  data-field="harga_beli">
                ' . number_format($row->harga_beli, 0, ',', '.') . '
            </span>
        </div>
    ';
})

// 🔹 Kolom Harga Jual (editable, ambil dari relasi barang)
->addColumn('harga_jual', function ($row) {
    return '
        <div class="text-end">
            <span class="editable-price text-success fw-bold"
                  data-id="' . ($row->barang?->id ?? '') . '"
                  data-field="harga_jual">
                ' . number_format($row->barang?->harga_jual ?? 0, 0, ',', '.') . '
            </span>
        </div>
    ';
})


// 🔹 Kolom Subtotal
->addColumn('subtotal', function ($row) {
    $total = $row->qty * $row->harga_beli;
    return '
        <div class="text-end">
            <span class="fw-bold text-success">Rp ' . number_format($total, 0, ',', '.') . '</span>
        </div>
    ';
})

     
             // 🔹 Kolom Aksi (hapus)
             ->addColumn('action', function ($row) {
                 return '
                     <div class="text-end">
                         <button class="btn btn-sm btn-light-danger btn-delete-detail" data-id="' . e($row->id) . '" title="Hapus">
                             <i class="ki-outline ki-trash fs-3"></i>
                         </button>
                     </div>
                 ';
             })
     
             ->rawColumns(['barang_info', 'kategori', 'brand_tipe', 'size', 'qty', 'harga_beli', 'subtotal', 'action','harga_jual'])
             ->make(true);
     }
     
     
     public function addDetail(Request $request, $id)
     {
        $bm = BarangMasuk::findOrFail($id); // di addDetail
if (($bm->status ?? 'draft') === 'final') {
    return response()->json(['success' => false, 'message' => 'Transaksi sudah final, tidak bisa diubah.']);
}


         $request->validate([
             'kode_barang' => 'required|string',
             'qty' => 'required|integer|min:1',
         ]);
     
         $barang = \App\Models\Barang::where('kode_barang', $request->kode_barang)->first();
     
         if (!$barang) {
             return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan']);
         }
     
         $existing = \App\Models\BarangMasukDetail::where('barang_masuk_id', $id)
             ->where('barang_id', $barang->id)
             ->first();
     
         if ($existing) {
             $existing->increment('qty', $request->qty);
             $existing->update(['subtotal' => $existing->qty * $existing->harga_beli]);
         } else {
             \App\Models\BarangMasukDetail::create([
                 'id' => \Str::uuid(),
                 'barang_masuk_id' => $id,
                 'barang_id' => $barang->id,
                 'qty' => $request->qty,
                 'harga_beli' => $barang->harga_beli ?? 0,
                 'subtotal' => $request->qty * ($barang->harga_beli ?? 0),
             ]);
         }
     
         return response()->json(['success' => true]);
     }

     public function updatePrice(Request $request)
{
    $request->validate([
        'id' => 'required|uuid',
        'field' => 'required|in:harga_beli,harga_jual',
        'value' => 'required|numeric|min:0',
    ]);

    if ($request->field === 'harga_beli') {
        // update di BarangMasukDetail
        $detail = \App\Models\BarangMasukDetail::findOrFail($request->id);
        $detail->update(['harga_beli' => $request->value]);
    } else {
        // update di Barang
        $barang = \App\Models\Barang::findOrFail($request->id);
        $barang->update(['harga_jual' => $request->value]);
    }

    return response()->json(['success' => true]);
}

     
     public function deleteDetail($detailId)
     {

        $detail = BarangMasukDetail::with('barangMasuk')->findOrFail($detailId); // di deleteDetail
if (($detail->barangMasuk->status ?? 'draft') === 'final') {
    return response()->json(['success' => false, 'message' => 'Transaksi sudah final, tidak bisa dihapus.']);
}



         $detail = \App\Models\BarangMasukDetail::findOrFail($detailId);
         $detail->delete();
     
         return response()->json(['success' => true]);
     }



public function finalize($id)
{
    return DB::transaction(function () use ($id) {
        // Lock header + eager load detail+barang
        $bm = BarangMasuk::with(['detail.barang'])->lockForUpdate()->findOrFail($id);

        // Sudah final? hentikan (idempotent)
        if (($bm->status ?? 'draft') === 'final') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi sudah difinalisasi.'
            ]);
        }

        // Wajib punya detail
        if ($bm->detail->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat finalisasi: belum ada item.'
            ]);
        }

        // Hitung total
        $totalItem  = $bm->detail->sum('qty');
        $totalHarga = $bm->detail->sum(fn($d) => $d->qty * $d->harga_beli);

        // Tambah stok per barang (atomic)
        foreach ($bm->detail as $d) {
            // pastikan stok integer & tidak null
            $current = (int) ($d->barang->stok ?? 0);
            $added   = (int) $d->qty;

            // UPDATE barang SET stok = stok + qty, harga_beli = last price (opsional)
            DB::table('barang')
                ->where('id', $d->barang_id)
                ->update([
                    'stok'       => $current + $added,
                    // kalau mau pakai last purchase price:
                    'harga_beli' => $d->harga_beli ?? $d->barang->harga_beli,
                ]);
        }

        // Kunci header
        $bm->update([
            'total_item'  => $totalItem,
            'total_harga' => $totalHarga,
            'status'      => 'final',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil difinalisasi. Stok barang telah diperbarui.',
        ]);
    });
}


///===============================END DETAIL==========================////

public function print($id)
{
    $data = BarangMasuk::with(['supplier', 'detail.barang'])->findOrFail($id);

    // Jika mau langsung view HTML print-friendly:
    return view('backend.apps.barang_masuk.print', compact('data'));

    // atau kalau mau versi PDF:
    // $pdf = \PDF::loadView('backend.apps.barang_masuk.print', compact('data'));
    // return $pdf->stream('BarangMasuk-'.$data->kode_transaksi.'.pdf');
}

public function store(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    $validator = Validator::make($request->all(), [
        'tanggal_masuk' => 'required|date',
        'supplier_id'   => 'required|exists:suppliers,id',
        'catatan'       => 'nullable|string',
    ], [
        'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
        'supplier_id.required'   => 'Supplier wajib dipilih',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        DB::beginTransaction();

        // ✅ Gunakan tanggal_masuk sebagai dasar
        $tanggal = Carbon::parse($request->tanggal_masuk)->format('Ymd');
        $prefix = 'BM-' . $tanggal . '-';

        // Ambil kode terakhir pada tanggal yang sama
        $last = BarangMasuk::whereDate('tanggal_masuk', $request->tanggal_masuk)
            ->where('kode_transaksi', 'like', $prefix . '%')
            ->orderBy('kode_transaksi', 'desc')
            ->lockForUpdate() // cegah race condition
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->kode_transaksi, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $kodeTransaksi = $prefix . $nextNumber;

        $data = BarangMasuk::create([
            'kode_transaksi' => $kodeTransaksi,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'supplier_id'    => $request->supplier_id,
            'user_id'        => Auth::id(),
            'catatan'        => $request->catatan,
            'total_item'     => 0,
            'total_harga'    => 0,
        ]);

        DB::commit();

        return response()->json([
            'success' => 'Transaksi ' . $data->kode_transaksi . ' berhasil dibuat.',
            'id'      => $data->id,
            'kode'    => $data->kode_transaksi,
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
            'time'         => $formattedTime,
            'judul'        => 'Aplikasi Error',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BarangMasuk::findOrFail($id);
        $html = view('backend.apps.barang_masuk.edit', [
            'data' => $data,
            'supplierSelected' => $data->findOrFail($id)->supplier,
        ])->render();

        return response()->json(['html' => $html]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $formattedTime = \Carbon\Carbon::now()->diffForHumans();

    // 🧩 Validasi input
    $validator = \Validator::make($request->all(), [
        'tanggal_masuk' => 'required|date',
        'supplier_id'   => 'required|exists:suppliers,id',
        'catatan'       => 'nullable|string',
    ], [
        'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
        'supplier_id.required'   => 'Supplier wajib dipilih',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\BarangMasuk::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data header
        $data->update([
            'tanggal_masuk' => $request->input('tanggal_masuk'),
            'supplier_id'   => $request->input('supplier_id'),
            'catatan'       => $request->input('catatan'),
        ]);

        // 🧠 Catat perubahan (jika pakai Spatie Activity Log)
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit barang masuk')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Barang Masuk: ' . $data->kode_transaksi);

        \DB::commit();

        return response()->json([
            'success' => 'Transaksi ' . $data->kode_transaksi . ' berhasil diperbaharui.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
            'time'         => $formattedTime,
            'judul'        => 'Aplikasi Error',
            'errorMessage' => $e->getMessage(),
        ]);
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
        DB::beginTransaction();

        $data = BarangMasuk::findOrFail($id);
        $details = BarangMasukDetail::where('barang_masuk_id', $id)->get();

        // 🔁 Kembalikan stok barang (kurangi sesuai qty)
        foreach ($details as $detail) {
            $barang = Barang::find($detail->barang_id);
            if ($barang) {
                $barang->stok = max(0, ($barang->stok ?? 0) - $detail->qty);
                $barang->save();
            }
        }

        // 🗑️ Hapus semua detail dulu
        BarangMasukDetail::where('barang_masuk_id', $id)->delete();

        // 🗑️ Hapus header transaksi
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus barang masuk')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties([
                'attributes' => $data->toArray(),
                'details'    => $details->toArray()
            ])
            ->log('Menghapus Transaksi Barang Masuk: ' . $data->kode_transaksi);

        DB::commit();

        return response()->json([
            'success' => 'Transaksi ' . $data->kode_transaksi . ' berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

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
        DB::beginTransaction();

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada data yang dipilih untuk dihapus.',
            ]);
        }

        $records = BarangMasuk::whereIn('id', $ids)->get();

        foreach ($records as $record) {
            $details = BarangMasukDetail::where('barang_masuk_id', $record->id)->get();

            // 🔁 Kembalikan stok barang
            foreach ($details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok = max(0, ($barang->stok ?? 0) - $detail->qty);
                    $barang->save();
                }
            }

            // 🗑️ Hapus detail & header
            BarangMasukDetail::where('barang_masuk_id', $record->id)->delete();
            $record->delete();
        }

        DB::commit();

        // 🧠 Log di luar transaksi
        foreach ($records as $record) {
            activity('mass delete barang masuk')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Transaksi Barang Masuk: ' . $record->kode_transaksi);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' transaksi barang masuk berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan saat menghapus data.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}




}
