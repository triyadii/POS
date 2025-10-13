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

         


       

        
           
            ->rawColumns([])
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function show($id)
{
    $data = BarangMAsuk::findOrFail($id);
    return view('backend.apps.barang_masuk.show', compact('data'));
}



public function store(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    // 🧩 Validasi input header saja
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

        // 🔢 Generate kode transaksi unik
        $today = Carbon::now()->format('Ymd');
        $lastKode = BarangMasuk::whereDate('created_at', Carbon::today())
            ->orderBy('kode_transaksi', 'desc')
            ->first();
        $nextNumber = $lastKode
            ? intval(substr($lastKode->kode_transaksi, -4)) + 1
            : 1;
        $kodeTransaksi = 'BM-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // ✅ Simpan data header
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
        $data = Brand::findOrFail($id);
        $html = view('backend.apps.barang_masuk.edit', [
            'data' => $data 
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
