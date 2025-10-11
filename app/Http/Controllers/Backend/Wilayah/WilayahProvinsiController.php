<?php
    
namespace App\Http\Controllers\Backend\Wilayah;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WilayahProvinsi;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use Auth;
use Carbon\Carbon;

class WilayahProvinsiController extends Controller

{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:province-list', ['only' => ['index','getDataWilayahProvinsi']]);
        $this->middleware('permission:province-create', ['only' => ['create','store']]);
        $this->middleware('permission:province-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:province-delete', ['only' => ['destroy']]);
        $this->middleware('permission:province-massdelete', ['only' => ['massDelete']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        
        return view('backend.data_wilayah.wilayah_provinsi.index');
    }

    public function getDataWilayahProvinsi(Request $request)
    {
        $postsQuery = WilayahProvinsi::orderBy('id', 'desc');
        
        $data = $postsQuery->select('*');

        return \DataTables::of($data)

            ->addColumn('action', function($data) {
                $x='';
                if (auth()->user()->can('province-edit') || auth()->user()->can('province-delete')) {
    
                    $x.='<div class="dropdown text-end">
                    <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                                                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                  
                    if (auth()->user()->can('province-edit')) {
                        $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
                    }
                    if (auth()->user()->can('province-delete')) {
                        $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
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
    public function store(Request $request, WilayahProvinsi $wilayahprovinsi)
    {

        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Provinsi Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        try {
            \DB::beginTransaction();

        $wilayahprovinsi = new WilayahProvinsi;
        $wilayahprovinsi -> nama = $request->nama;
        $wilayahprovinsi ->save();

        $changes = [
            'attributes' => $wilayahprovinsi
        ];

        activity('tambah provinsi')
            ->causedBy(Auth::user()->id)
            ->performedOn($wilayahprovinsi)
            ->withProperties($changes)
            ->log('Membuat data provinsi dengan nama '.$wilayahprovinsi->nama);
 
        \DB::commit();
        

        return response()->json([
            'success' => 'Data ' . $wilayahprovinsi->nama . ' berhasil disimpan.', 
            'time' => $formattedTime, 
            'judul' => 'Berhasil']);
        } catch (\Exception $e) {
            \DB::rollback();
            $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.', 
                'time' => $formattedTime, 
                'judul' => 'Aplikasi Error', 
                'errorMessage' => $errorMessage]);
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
        $wilayahprovinsi = WilayahProvinsi::findOrFail($id);

        $html = view('backend.data_wilayah.wilayah_provinsi.edit', 
        [
        'data' => $wilayahprovinsi->findOrFail($id),
        
        ])->render();
                                                                																						
        return response()->json(['html'=>$html]);
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

        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Provinsi Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            \DB::beginTransaction();

        $wilayahprovinsi = WilayahProvinsi::findOrFail($id);
        $oldData = $wilayahprovinsi->getOriginal();
        $wilayahprovinsi -> nama = $request->nama;
        $wilayahprovinsi->update();
        $changes = [
            'attributes' => $wilayahprovinsi,
            'old' => $oldData
        ];
        activity('edit provinsi')
        ->causedBy(Auth::user()->id)
        ->performedOn($wilayahprovinsi)
        ->withProperties($changes)
        ->log('Mengubah data provinsi '.$wilayahprovinsi->nama);

        \DB::commit();
    
        return response()->json([
            'success' => 'Data ' . $wilayahprovinsi->nama . ' berhasil diperbaharui.', 
            'time' => $formattedTime, 
            'judul' => 'Berhasil']);
        } catch (\Exception $e) {
            \DB::rollback();
            $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.', 
                'time' => $formattedTime, 
                'judul' => 'Aplikasi Error', 
                'errorMessage' => $errorMessage]);
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
        $wilayahprovinsi = WilayahProvinsi::findOrFail($id);
        $wilayahprovinsi->delete();

        $changes = [
            'attributes' => $wilayahprovinsi
        ];
        activity('hapus provinsi')
            ->causedBy(Auth::user()->id)
            ->performedOn($wilayahprovinsi)
            ->withProperties($changes)
            ->log('Menghapus data provinsi '.$wilayahprovinsi->nama);
 
        \DB::commit();

    return response()->json([
        'success' => 'Data ' . $wilayahprovinsi->nama . ' berhasil dihapus', 
        'time' => $formattedTime, 
        'judul' => 'Berhasil']);
    } catch (\Exception $e) {
        \DB::rollback();
        $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
        return response()->json([
            'error' => 'Data Gagal dihapus', 
            'time' => $formattedTime, 
            'judul' => 'Gagal', 
            'errorMessage' => $errorMessage]);
    }

 
    }

    public function massDelete(Request $request)
        {
            $formattedTime = Carbon::now()->diffForHumans();
            try {
                \DB::beginTransaction();

                $ids = $request->ids;
            
                if (!empty($ids)) {
                    // Dapatkan data pengguna yang akan dihapus untuk logging
                    $data = WilayahProvinsi::whereIn('id', $ids)->get();

                    // Hapus pengguna
                    WilayahProvinsi::whereIn('id', $ids)->delete();
            
                    \DB::commit();

                    // Log activity untuk setiap pengguna yang dihapus
                    foreach ($data as $data) {
                        activity('mass remove provinsi')
                            ->causedBy(Auth::user()) // Log siapa yang melakukan
                            ->performedOn($data) // Data user yang dihapus
                            ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                            ->log('Menghapus data provinsi ' . $data->nama);
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => count($ids) . ' data deleted successfully!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No data selected for deletion.'
                    ]);
                }
            } catch (\Exception $e) {
                \DB::rollback();
                $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
                return response()->json(['error' => 'Data Gagal dihapus', 'time' => $formattedTime, 'judul' => 'Gagal', 'errorMessage' => $errorMessage]);
            }
        }


        public function select(Request $request)
        {
            $wilayahprovinsi = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $wilayahprovinsi = WilayahProvinsi::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $wilayahprovinsi = WilayahProvinsi::limit(10)->get();
            }
            return response()->json($wilayahprovinsi);
        }

    

    





}