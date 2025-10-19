<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPengeluaran;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

use Validator;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:kategori-pengeluaran-list', ['only' => ['index','getData']]);
        $this->middleware('permission:kategori-pengeluaran-create', ['only' => ['store']]);
        $this->middleware('permission:kategori-pengeluaran-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:kategori-pengeluaran-delete', ['only' => ['destroy']]);
        $this->middleware('permission:kategori-pengeluaran-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.master.kategori_pengeluaran.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = KategoriPengeluaran::orderBy('created_at', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('nama', 'LIKE', "%{$searchValue}%");
            });
        }
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()

         


        ->addColumn('action', function($data) {
            return '
            <div class="text-end">
                <a href="#" 
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-show-kategori-pengeluaran" 
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

        
           
            ->rawColumns(['action'])
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
    $data = KategoriPengeluaran::findOrFail($id);
    return view('backend.master.kategori_pengeluaran.show', compact('data'));
}



     public function store(Request $request)
     {
         $formattedTime = Carbon::now()->diffForHumans();
 
         // 🧩 Validasi input
         $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|max:150',
             'keterangan'=> 'nullable|string',
         ], [
             'nama.required' => 'Nama Kategori Pengeluaran wajib diisi',
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()]);
         }
 
         try {
             DB::beginTransaction();
 
             // ✅ Simpan data kategori pengeluaran (UUID otomatis dari model)
             $data = KategoriPengeluaran::create([
                 'nama'        => $request->input('nama'),
                 'keterangan'  => $request->input('keterangan'),
             ]);
 
             // 🧠 Catat log aktivitas (jika kamu pakai spatie/activitylog)
             $changes = ['attributes' => $data];
 
             activity('tambah kategori pengeluaran')
                 ->causedBy(Auth::user() ?? null)
                 ->performedOn($data)
                 ->withProperties($changes)
                 ->log('Menambahkan KategoriPengeluaran: ' . $data->nama);
 
             DB::commit();
 
             return response()->json([
                 'success' => 'Data ' . $data->nama . ' berhasil disimpan.',
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
        $data = KategoriPengeluaran::findOrFail($id);
        $html = view('backend.master.kategori_pengeluaran.edit', [
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
    $formattedTime = Carbon::now()->diffForHumans();

    // 🧩 Validasi input
    $validator = \Validator::make($request->all(), [
        'nama'       => 'required|string|max:150',
        'keterangan' => 'nullable|string',
    ], [
        'nama.required' => 'Nama Kategori Pengeluaran wajib diisi',
        'nama.unique'   => 'Nama Kategori Pengeluaran sudah digunakan',
    ]);
    

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\KategoriPengeluaran::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data kategori pengeluaran
        $data->update([
            'nama'        => $request->input('nama'),
            'keterangan'  => $request->input('keterangan'),
        ]);

        // 🧠 Catat perubahan
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit kategori pengeluaran')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data KategoriPengeluaran: ' . $data->nama);

        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $data->nama . ' berhasil diperbaharui.',
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
        \DB::beginTransaction();

        $data = KategoriPengeluaran::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus kategori pengeluaran')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus KategoriPengeluaran: ' . $data->nama);

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
        $records = KategoriPengeluaran::whereIn('id', $ids)->get();

        // Hapus sekaligus
        KategoriPengeluaran::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete kategori pengeluaran')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus KategoriPengeluaran: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data kategori pengeluaran berhasil dihapus.',
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
            $kategori_pengeluaran = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $kategori_pengeluaran = KategoriPengeluaran::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $kategori_pengeluaran = KategoriPengeluaran::limit(30)->get();
            }
            return response()->json($kategori_pengeluaran);
        }


}
