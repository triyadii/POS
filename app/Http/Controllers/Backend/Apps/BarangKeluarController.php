<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\Barang;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth; 
use Validator;
use Str;


class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:barang-keluar-list', ['only' => ['index','getData']]);
        $this->middleware('permission:barang-keluar-create', ['only' => ['store']]);
        $this->middleware('permission:barang-keluar-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:barang-keluar-delete', ['only' => ['destroy']]);
        $this->middleware('permission:barang-keluar-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.apps.barang_keluar.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = BarangKeluar::orderBy('created_at', 'desc');
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
            $urlShow  = route('barang-keluar.show', $data->id);
            $urlPrint = route('barang-keluar.print', $data->id);
        
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
                : 'badge-light-secondary';
            $label = ucfirst($status);

            return '<span class="badge fw-semibold ' . $badgeClass . '">' . $label . '</span>';
        })

           
        ->rawColumns(['total_item', 'total_harga', 'status', 'action'])
            ->make(true);
    }
    

     public function show($id)
     {
         $data = BarangKeluar::with(['detail.barang'])->findOrFail($id);
     
         return view('backend.apps.barang_keluar.show', compact('data'));
     }


     ////==================DETAIL=====================////
     
     public function getDetailList($id)
     {
         $details = BarangKeluarDetail::with(['barang.kategori', 'barang.brand', 'barang.tipe'])
             ->where('barang_keluar_id', $id)
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

// 🔹 Kolom Harga Beli
->addColumn('harga_beli', function ($row) {
    return '
        <div class="text-end">
            Rp ' . number_format($row->harga_beli, 0, ',', '.') . '
        </div>
    ';
})

// 🔹 Kolom Harga Beli
->addColumn('harga_jual', function ($row) {
    return '
        <div class="text-end">
            Rp ' . number_format($row->barang?->harga_jual ?? '-', 0, ',', '.') . '
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
     
     
    // =========================================================
    // 🔹 Tambah Detail Barang Keluar
    // =========================================================
    public function addDetail(Request $request, $id)
    {
        $bm = BarangKeluar::findOrFail($id);

        // Cegah perubahan jika sudah final
        if (($bm->status ?? 'draft') === 'final') {
            return response()->json(['success' => false, 'message' => 'Transaksi sudah final, tidak bisa diubah.']);
        }

        // Validasi input
        $request->validate([
            'kode_barang' => 'required|string',
            'qty'         => 'required|integer|min:1',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->first();

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan.']);
        }

        // 🔸 Pastikan stok cukup
        if ($barang->stok < $request->qty) {
            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.']);
        }

        // 🔸 Cek apakah barang sudah ada di detail
        $existing = BarangKeluarDetail::where('barang_keluar_id', $id)
            ->where('barang_id', $barang->id)
            ->first();

        if ($existing) {
            $newQty = $existing->qty + $request->qty;

            // Cek stok lagi jika mau tambah
            if ($barang->stok < $newQty) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi untuk menambah qty.']);
            }

            $existing->update([
                'qty'      => $newQty,
                'subtotal' => $newQty * ($barang->harga_jual ?? 0),
            ]);
        } else {
            BarangKeluarDetail::create([
                'id'               => (string) Str::uuid(),
                'barang_keluar_id' => $id,
                'barang_id'        => $barang->id,
                'qty'              => $request->qty,
                'harga_jual'       => $barang->harga_jual ?? 0,
                'subtotal'         => $request->qty * ($barang->harga_jual ?? 0),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Barang berhasil ditambahkan ke transaksi.']);
    }

    // =========================================================
    // 🔹 Hapus Detail Barang Keluar
    // =========================================================
    public function deleteDetail($detailId)
    {
        $detail = BarangKeluarDetail::with('barangKeluar')->findOrFail($detailId);

        if (($detail->barangKeluar->status ?? 'draft') === 'final') {
            return response()->json(['success' => false, 'message' => 'Transaksi sudah final, tidak bisa dihapus.']);
        }

        $detail->delete();

        return response()->json(['success' => true, 'message' => 'Item berhasil dihapus.']);
    }

    // =========================================================
    // 🔹 Finalisasi Transaksi Barang Keluar
    // =========================================================
    public function finalize($id)
    {
        return DB::transaction(function () use ($id) {
            // Lock header + eager load detail + barang
            $bk = BarangKeluar::with(['detail.barang'])->lockForUpdate()->findOrFail($id);

            if (($bk->status ?? 'draft') === 'final') {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi sudah difinalisasi.',
                ]);
            }

            if ($bk->detail->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat finalisasi: belum ada item.',
                ]);
            }

            // 🔹 Validasi stok semua barang dulu
            foreach ($bk->detail as $d) {
                $stok = (int) ($d->barang->stok ?? 0);
                if ($stok < $d->qty) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok barang '{$d->barang->nama}' tidak mencukupi (tersisa: {$stok}).",
                    ]);
                }
            }

            // 🔹 Kurangi stok & hitung total
            $totalItem  = 0;
            $totalHarga = 0;

            foreach ($bk->detail as $d) {
                $qty   = (int) $d->qty;
                $harga = (float) ($d->harga_jual ?? 0);

                DB::table('barang')
                    ->where('id', $d->barang_id)
                    ->update([
                        'stok' => DB::raw("GREATEST(stok - {$qty}, 0)"), // tidak boleh minus
                    ]);

                $totalItem  += $qty;
                $totalHarga += $qty * $harga;
            }

            // 🔹 Update header
            $bk->update([
                'total_item'  => $totalItem,
                'total_harga' => $totalHarga,
                'status'      => 'final',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi barang keluar berhasil difinalisasi. Stok telah dikurangi.',
            ]);
        });
    }


///===============================END DETAIL==========================////

public function print($id)
{
    $data = BarangKeluar::with(['detail.barang'])->findOrFail($id);

    // Jika mau langsung view HTML print-friendly:
    return view('backend.apps.barang_keluar.print', compact('data'));

    // atau kalau mau versi PDF:
    // $pdf = \PDF::loadView('backend.apps.barang_keluar.print', compact('data'));
    // return $pdf->stream('BarangKeluar-'.$data->kode_transaksi.'.pdf');
}



public function store(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    // 🧩 Validasi input header saja
    $validator = Validator::make($request->all(), [
        'tanggal_keluar' => 'required|date',
        'catatan'       => 'nullable|string',
    ], [
        'tanggal_keluar.required' => 'Tanggal keluar wajib diisi',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        DB::beginTransaction();

        // 🔢 Generate kode transaksi unik
        $today = Carbon::now()->format('Ymd');
        $lastKode = BarangKeluar::whereDate('created_at', Carbon::today())
            ->orderBy('kode_transaksi', 'desc')
            ->first();
        $nextNumber = $lastKode
            ? intval(substr($lastKode->kode_transaksi, -4)) + 1
            : 1;
        $kodeTransaksi = 'BK-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // ✅ Simpan data header
        $data = BarangKeluar::create([
            'kode_transaksi' => $kodeTransaksi,
            'tanggal_keluar'  => $request->tanggal_keluar,
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
        $data = BarangKeluar::findOrFail($id);
        $html = view('backend.apps.barang_keluar.edit', [
            'data' => $data,
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
        'tanggal_keluar' => 'required|date',
        'catatan'       => 'nullable|string',
    ], [
        'tanggal_keluar.required' => 'Tanggal keluar wajib diisi',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\BarangKeluar::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data header
        $data->update([
            'tanggal_keluar' => $request->input('tanggal_keluar'),
            'catatan'       => $request->input('catatan'),
        ]);

        // 🧠 Catat perubahan (jika pakai Spatie Activity Log)
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit barang keluar')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Barang Keluar: ' . $data->kode_transaksi);

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

        $data = BarangKeluar::findOrFail($id);
        $details = BarangKeluarDetail::where('barang_keluar_id', $id)->get();

        // 🔁 Kembalikan stok barang (kurangi sesuai qty)
        foreach ($details as $detail) {
            $barang = Barang::find($detail->barang_id);
            if ($barang) {
                $barang->stok = max(0, ($barang->stok ?? 0) - $detail->qty);
                $barang->save();
            }
        }

        // 🗑️ Hapus semua detail dulu
        BarangKeluarDetail::where('barang_keluar_id', $id)->delete();

        // 🗑️ Hapus header transaksi
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus barang keluar')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties([
                'attributes' => $data->toArray(),
                'details'    => $details->toArray()
            ])
            ->log('Menghapus Transaksi Barang Keluar: ' . $data->kode_transaksi);

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

        $records = BarangKeluar::whereIn('id', $ids)->get();

        foreach ($records as $record) {
            $details = BarangKeluarDetail::where('barang_keluar_id', $record->id)->get();

            // 🔁 Kembalikan stok barang
            foreach ($details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok = max(0, ($barang->stok ?? 0) - $detail->qty);
                    $barang->save();
                }
            }

            // 🗑️ Hapus detail & header
            BarangKeluarDetail::where('barang_keluar_id', $record->id)->delete();
            $record->delete();
        }

        DB::commit();

        // 🧠 Log di luar transaksi
        foreach ($records as $record) {
            activity('mass delete barang keluar')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Transaksi Barang Keluar: ' . $record->kode_transaksi);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' transaksi barang keluar berhasil dihapus.',
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
