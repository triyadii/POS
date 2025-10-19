<?php
    
namespace App\Http\Controllers\Backend\Wilayah;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WilayahKabupaten;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class WilayahKabupatenController extends Controller

{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:regency-list', ['only' => ['index','getDataWilayahKabupaten']]);
        $this->middleware('permission:regency-create', ['only' => ['create','store']]);
        $this->middleware('permission:regency-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:regency-delete', ['only' => ['destroy']]);
        $this->middleware('permission:regency-massdelete', ['only' => ['massDelete']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ucwords($string);
    //ucwords(strtolower($string));

    public function index()
    {
        
        
        return view('backend.data_wilayah.wilayah_kabupaten.index');
    }

    public function getDataWilayahKabupaten(Request $request, WilayahKabupaten $wilayahkabupaten)
    {
       
        $postsQuery = WilayahKabupaten::orderBy('id', 'desc');
        
        $data = $postsQuery->select('*');

        return \DataTables::of($data)

       

        ->addColumn('action', function($data) {
            $x='';
            if (auth()->user()->can('regency-edit') || auth()->user()->can('regency-delete')) {

                $x.='<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
              
                if (auth()->user()->can('regency-edit')) {
                    $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
                }
                if (auth()->user()->can('regency-delete')) {
                    $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                }
                $x .= '</ul></div>';

            }
            return '
            '.$x.'
            ';  
        })

            

            



            ->addColumn('wilayahprovinsi', function ($data) {
                return $data->wilayahprovinsi->nama;
            })
           
            ->rawColumns(['action','wilayahprovinsi'])
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
        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
            'wilayah_provinsi_id' => 'required',
        ], [
            'nama.required' => 'Nama Kabupaten/Kota Wajib diisi',
            'wilayah_provinsi_id.required' => 'Nama Provinsi Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        try {
            \DB::beginTransaction();

        $wilayahkabupaten = new WilayahKabupaten;
        $wilayahkabupaten -> nama = $request->nama;
        $wilayahkabupaten -> wilayah_provinsi_id = $request->wilayah_provinsi_id;
        $wilayahkabupaten ->save();
 
        $changes = [
            'attributes' => $wilayahkabupaten
        ];

        activity('tambah kabupaten/kota')
            ->causedBy(Auth::user()->id)
            ->performedOn($wilayahkabupaten)
            ->withProperties($changes)
            ->log('Membuat data kabupaten/kota dengan nama '.$wilayahkabupaten->nama);


        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $wilayahkabupaten->nama . ' berhasil disimpan.', 
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
        $wilayahkabupaten = WilayahKabupaten::findOrFail($id);

        $html = view('backend.data_wilayah.wilayah_kabupaten.edit', 
        [
        'data' => $wilayahkabupaten->findOrFail($id),
        'provinceSelected' => $wilayahkabupaten->findOrFail($id)->wilayahprovinsi,
        
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
            'wilayah_provinsi_id' => 'required',
        ], [
            'nama.required' => 'Nama Kabupaten/Kota Wajib diisi',
            'wilayah_provinsi_id.required' => 'Nama Provinsi Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            \DB::beginTransaction();

        $wilayahkabupaten = WilayahKabupaten::findOrFail($id);
        $oldData = $wilayahkabupaten->getOriginal();
        $wilayahkabupaten -> nama = $request->nama;
        $wilayahkabupaten -> wilayah_provinsi_id = $request->wilayah_provinsi_id;
        $wilayahkabupaten->update();
    
        $changes = [
            'attributes' => $wilayahkabupaten,
            'old' => $oldData
        ];
        activity('edit kabupaten/kota')
        ->causedBy(Auth::user()->id)
        ->performedOn($wilayahkabupaten)
        ->withProperties($changes)
        ->log('Mengubah data kabupaten/kota '.$wilayahkabupaten->nama);
        \DB::commit();
    
        return response()->json([
            'success' => 'Data ' . $wilayahkabupaten->nama . ' berhasil diperbaharui.', 
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
            $wilayahkabupaten = WilayahKabupaten::findOrFail($id);
            $wilayahkabupaten->delete();

            $changes = [
                'attributes' => $wilayahkabupaten
            ];
            activity('hapus kabupaten/kota')
                ->causedBy(Auth::user()->id)
                ->performedOn($wilayahkabupaten)
                ->withProperties($changes)
                ->log('Menghapus data kabupaten/kota '.$wilayahkabupaten->nama);
 
            \DB::commit();

            return response()->json([
                'success' => 'Data ' . $wilayahkabupaten->nama . ' berhasil dihapus', 
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
                    $data = WilayahKabupaten::whereIn('id', $ids)->get();

                    // Hapus pengguna
                    WilayahKabupaten::whereIn('id', $ids)->delete();
            
                    \DB::commit();

                    // Log activity untuk setiap pengguna yang dihapus
                    foreach ($data as $data) {
                        activity('mass remove kabupaten/kota')
                            ->causedBy(Auth::user()) // Log siapa yang melakukan
                            ->performedOn($data) // Data user yang dihapus
                            ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                            ->log('Menghapus data kabupaten/kota ' . $data->nama);
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
            $wilayahkabupaten = [];
            $wilayahprovinsiID = $request->wilayahprovinsiID;
            if ($request->has('q')) {
                $search = $request->q;
                $wilayahkabupaten = WilayahKabupaten::select("id", "nama")
                    ->where('wilayah_provinsi_id', $wilayahprovinsiID)
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $wilayahkabupaten = WilayahKabupaten::where('wilayah_provinsi_id', $wilayahprovinsiID)->limit(10)->get();
            }
            return response()->json($wilayahkabupaten);
        }






}