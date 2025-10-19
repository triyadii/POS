<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

use Validator;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:satuan-list', ['only' => ['index','getData']]);
        $this->middleware('permission:satuan-create', ['only' => ['store']]);
        $this->middleware('permission:satuan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:satuan-delete', ['only' => ['destroy']]);
        $this->middleware('permission:satuan-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.master.satuan.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Satuan::orderBy('created_at', 'desc');
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
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-show-satuan" 
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
    $data = Satuan::findOrFail($id);
    return view('backend.master.satuan.show', compact('data'));
}



     public function store(Request $request)
     {
         $formattedTime = Carbon::now()->diffForHumans();
 
         // 🧩 Validasi input
         $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|max:150|unique:satuan,nama',
             'singkatan'=> 'nullable|string',
         ], [
             'nama.required' => 'Nama Satuan wajib diisi',
             'nama.unique'   => 'Nama Satuan sudah terdaftar',
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()]);
         }
 
         try {
             DB::beginTransaction();
 
             // ✅ Simpan data satuan (UUID otomatis dari model)
             $data = Satuan::create([
                 'nama'        => $request->input('nama'),
                 'singkatan'  => $request->input('singkatan'),
             ]);
 
             // 🧠 Catat log aktivitas (jika kamu pakai spatie/activitylog)
             $changes = ['attributes' => $data];
 
             activity('tambah satuan')
                 ->causedBy(Auth::user() ?? null)
                 ->performedOn($data)
                 ->withProperties($changes)
                 ->log('Menambahkan Satuan: ' . $data->nama);
 
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
        $data = Satuan::findOrFail($id);
        $html = view('backend.master.satuan.edit', [
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
        'nama'       => 'required|string|max:150|unique:satuan,nama,' . $id . ',id',
        'singkatan' => 'nullable|string',
    ], [
        'nama.required' => 'Nama Satuan wajib diisi',
        'nama.unique'   => 'Nama Satuan sudah digunakan oleh satuan lain',
    ]);
    

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\Satuan::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data satuan
        $data->update([
            'nama'        => $request->input('nama'),
            'singkatan'  => $request->input('singkatan'),
        ]);

        // 🧠 Catat perubahan
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit satuan')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Satuan: ' . $data->nama);

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

        $data = Satuan::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus satuan')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Satuan: ' . $data->nama);

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
        $records = Satuan::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Satuan::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete satuan')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Satuan: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data satuan berhasil dihapus.',
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
            $satuan = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $satuan = Satuan::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $satuan = Satuan::limit(30)->get();
            }
            return response()->json($satuan);
        }


}
