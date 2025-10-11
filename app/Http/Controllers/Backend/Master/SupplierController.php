<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:supplier-list', ['only' => ['index','getData']]);
        $this->middleware('permission:supplier-create', ['only' => ['store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
        $this->middleware('permission:supplier-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.master.supplier.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Supplier::orderBy('created_at', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('nama', 'LIKE', "%{$searchValue}%");
            });
        }
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()

         ->addColumn('action', function($row) {
            $x='';
            if (auth()->user()->can('supplier-show') || auth()->user()->can('supplier-edit') || auth()->user()->can('supplier-delete')) {

                $x.='<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                if (auth()->user()->can('supplier-show')) {
                    $x.=' <li><a class="dropdown-item btn px-3" href="'.route('supplier.show', $row->id).'" >Detail</a></li>';
                }
                if (auth()->user()->can('supplier-edit')) {
                    $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$row->id.'" >Edit</a></li>';
                }
                if (auth()->user()->can('supplier-delete')) {
                    $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                }
                $x .= '</ul></div>';

            }
            return '
            '.$x.'
            ';  
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


     public function store(Request $request)
     {
         $formattedTime = Carbon::now()->diffForHumans();
 
         // 🧩 Validasi input
         $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|max:150|unique:suppliers,nama',
             'no_telp'   => 'nullable|string|max:20',
             'alamat'    => 'nullable|string',
             'keterangan'=> 'nullable|string',
         ], [
             'nama.required' => 'Nama Supplier wajib diisi',
             'nama.unique'   => 'Nama Supplier sudah terdaftar',
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()]);
         }
 
         try {
             DB::beginTransaction();
 
             // ✅ Simpan data supplier (UUID otomatis dari model)
             $data = Supplier::create([
                 'nama'        => $request->input('nama'),
                 'no_telp'     => $request->input('no_telp'),
                 'alamat'      => $request->input('alamat'),
                 'keterangan'  => $request->input('keterangan'),
             ]);
 
             // 🧠 Catat log aktivitas (jika kamu pakai spatie/activitylog)
             $changes = ['attributes' => $data];
 
             activity('tambah supplier')
                 ->causedBy(Auth::user() ?? null)
                 ->performedOn($data)
                 ->withProperties($changes)
                 ->log('Menambahkan Supplier: ' . $data->nama);
 
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
        $data = Supplier::findOrFail($id);
        $html = view('backend.master.supplier.edit', [
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
        'nama'       => 'required|string|max:150|unique:suppliers,nama,' . $id . ',id',
        'no_telp'    => 'nullable|string|max:20',
        'alamat'     => 'nullable|string',
        'keterangan' => 'nullable|string',
    ], [
        'nama.required' => 'Nama Supplier wajib diisi',
        'nama.unique'   => 'Nama Supplier sudah digunakan oleh supplier lain',
    ]);
    

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\Supplier::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data supplier
        $data->update([
            'nama'        => $request->input('nama'),
            'no_telp'     => $request->input('no_telp'),
            'alamat'      => $request->input('alamat'),
            'keterangan'  => $request->input('keterangan'),
        ]);

        // 🧠 Catat perubahan
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit supplier')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Supplier: ' . $data->nama);

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

        $data = Supplier::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus supplier')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Supplier: ' . $data->nama);

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
        $records = Supplier::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Supplier::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete supplier')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Supplier: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data supplier berhasil dihapus.',
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
            $supplier = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $supplier = Supplier::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $supplier = Supplier::limit(30)->get();
            }
            return response()->json($supplier);
        }


}
