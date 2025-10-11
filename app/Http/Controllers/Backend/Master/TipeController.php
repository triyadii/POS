<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipe;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;
use Illuminate\Validation\Rule;


use Validator;

class TipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:tipe-list', ['only' => ['index','getData']]);
        $this->middleware('permission:tipe-create', ['only' => ['store']]);
        $this->middleware('permission:tipe-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:tipe-delete', ['only' => ['destroy']]);
        $this->middleware('permission:tipe-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.master.tipe.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Tipe::with('brand')->orderBy('created_at', 'desc');

        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
        
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('nama', 'LIKE', "%{$searchValue}%")
                      ->orWhereHas('brand', function ($q) use ($searchValue) {
                          $q->where('nama', 'LIKE', "%{$searchValue}%");
                      });
            });
        }
        
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()

         ->addColumn('brand_id', function ($row) {
            return $row->brand ? e($row->brand->nama) : '<span class="badge bg-danger">Tidak ada brand</span>';
        })
        


        ->addColumn('action', function($data) {
            return '
            <div class="text-end">
                <a href="#" 
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-show-tipe" 
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

        
           
            ->rawColumns(['action','brand_id'])
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
    $data = Tipe::findOrFail($id);
    return view('backend.master.tipe.show', compact('data'));
}



     public function store(Request $request)
     {
         $formattedTime = Carbon::now()->diffForHumans();
 
         // 🧩 Validasi input
         $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:150',
                Rule::unique('tipe', 'nama')->where(function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id);
                }),
            ],
            'brand_id' => 'required|exists:brands,id',
        ], [
            'nama.required' => 'Nama Tipe wajib diisi.',
            'nama.unique'   => 'Nama Tipe sudah terdaftar untuk brand ini.',
            'brand_id.required' => 'Brand wajib dipilih.',
            'brand_id.exists'   => 'Brand tidak ditemukan.',
        ]);
        
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()]);
         }
 
         try {
             DB::beginTransaction();
 
             // ✅ Simpan data tipe (UUID otomatis dari model)
             $data = Tipe::create([
                 'nama'        => $request->input('nama'),
                 'brand_id'  => $request->input('brand_id'),
             ]);
 
             // 🧠 Catat log aktivitas (jika kamu pakai spatie/activitylog)
             $changes = ['attributes' => $data];
 
             activity('tambah tipe')
                 ->causedBy(Auth::user() ?? null)
                 ->performedOn($data)
                 ->withProperties($changes)
                 ->log('Menambahkan Tipe: ' . $data->nama);
 
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
        $data = Tipe::findOrFail($id);
        $html = view('backend.master.tipe.edit', [
            'data' => $data,
            'brandSelected' => $data->findOrFail($id)->brand,
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
        'nama'       => 'required|string|max:150|unique:tipe,nama,' . $id . ',id',
        'keterangan' => 'nullable|string',
    ], [
        'nama.required' => 'Nama Tipe wajib diisi',
        'nama.unique'   => 'Nama Tipe sudah digunakan oleh tipe lain',
    ]);
    

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\Tipe::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data tipe
        $data->update([
            'nama'        => $request->input('nama'),
            'keterangan'  => $request->input('keterangan'),
        ]);

        // 🧠 Catat perubahan
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit tipe')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Tipe: ' . $data->nama);

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

        $data = Tipe::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus tipe')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Tipe: ' . $data->nama);

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
        $records = Tipe::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Tipe::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete tipe')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Tipe: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data tipe berhasil dihapus.',
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
            $tipe = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $tipe = Tipe::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $tipe = Tipe::limit(30)->get();
            }
            return response()->json($tipe);
        }


}
