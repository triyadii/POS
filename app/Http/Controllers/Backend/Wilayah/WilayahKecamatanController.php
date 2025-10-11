<?php
    
namespace App\Http\Controllers\Backend\Wilayah;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WilayahKecamatan;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class WilayahKecamatanController extends Controller

{

    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:district-list', ['only' => ['index','getDataWilayahKecamatan']]);
        $this->middleware('permission:district-create', ['only' => ['create','store']]);
        $this->middleware('permission:district-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:district-delete', ['only' => ['destroy']]);
        $this->middleware('permission:district-massdelete', ['only' => ['massDelete']]);

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
        
        
        return view('backend.data_wilayah.wilayah_kecamatan.index');
    }

    public function getDataWilayahKecamatan(Request $request, WilayahKecamatan $wilayahkecamatan)
    {
       
        $postsQuery = WilayahKecamatan::orderBy('id', 'desc');
        
        $data = $postsQuery->select('*');

        return \DataTables::of($data)
           


            ->addColumn('action', function($data) {
                $x='';
                if (auth()->user()->can('district-edit') || auth()->user()->can('district-delete')) {
    
                    $x.='<div class="dropdown text-end">
                    <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                                                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                  
                    if (auth()->user()->can('district-edit')) {
                        $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
                    }
                    if (auth()->user()->can('district-delete')) {
                        $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                    }
                    $x .= '</ul></div>';
    
                }
                return '
                '.$x.'
                ';  
            })


            ->addColumn('wilayahkabupaten', function ($data) {
                return $data->wilayahkabupaten->nama;
            })

           
           
            ->rawColumns(['action','wilayahkabupaten'])
            ->make(true);
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, WilayahKecamatan $wilayahkecamatan)
    {

        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
            'wilayah_kabupaten_id' => 'required',
        ], [
            'nama.required' => 'Nama Kecamatan Wajib diisi',
            'wilayah_kabupaten_id.required' => 'Nama Kabupaten/Kota Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        try {
            \DB::beginTransaction();

        $wilayahkecamatan = new WilayahKecamatan;
        $wilayahkecamatan -> nama = $request->nama;
        $wilayahkecamatan -> wilayah_kabupaten_id = $request->wilayah_kabupaten_id;
        $wilayahkecamatan ->save();

        $changes = [
            'attributes' => $wilayahkecamatan
        ];

        activity('tambah kecamatan')
            ->causedBy(Auth::user()->id)
            ->performedOn($wilayahkecamatan)
            ->withProperties($changes)
            ->log('Membuat data kecamatan dengan nama '.$wilayahkecamatan->nama);
 
        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $wilayahkecamatan->nama . ' berhasil disimpan.', 
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
        $wilayahkecamatan = WilayahKecamatan::findOrFail($id);

        $html = view('backend.data_wilayah.wilayah_kecamatan.edit', 
        [
        'data' => $wilayahkecamatan->findOrFail($id),
        'regencySelected' => $wilayahkecamatan->findOrFail($id)->wilayahkabupaten,
        
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
            'wilayah_kabupaten_id' => 'required',
        ], [
            'nama.required' => 'Nama Kecamatan Wajib diisi',
            'wilayah_kabupaten_id.required' => 'Nama Kabupaten/Kota Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            \DB::beginTransaction();

        $wilayahkecamatan = WilayahKecamatan::findOrFail($id);
        $oldData = $wilayahkecamatan->getOriginal();
        $wilayahkecamatan -> nama = $request->nama;
        $wilayahkecamatan -> wilayah_kabupaten_id = $request->wilayah_kabupaten_id;
        $wilayahkecamatan->update();
    

        $changes = [
            'attributes' => $wilayahkecamatan,
            'old' => $oldData
        ];
        activity('edit kecamatan')
        ->causedBy(Auth::user()->id)
        ->performedOn($wilayahkecamatan)
        ->withProperties($changes)
        ->log('Mengubah data kecamatan '.$wilayahkecamatan->nama);
        \DB::commit();
        
        
        return response()->json([
            'success' => 'Data ' . $wilayahkecamatan->nama . ' berhasil diperbaharui.', 
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
            $wilayahkecamatan = WilayahKecamatan::findOrFail($id);
            $wilayahkecamatan->delete();

            $changes = [
                'attributes' => $wilayahkecamatan
            ];
            activity('hapus kecamatan')
                ->causedBy(Auth::user()->id)
                ->performedOn($wilayahkecamatan)
                ->withProperties($changes)
                ->log('Menghapus data kecamatan '.$wilayahkecamatan->nama);

            \DB::commit();

            return response()->json([
                'success' => 'Data ' . $wilayahkecamatan->nama . ' berhasil dihapus', 
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
                    $data = WilayahKecamatan::whereIn('id', $ids)->get();

                    // Hapus pengguna
                    WilayahKecamatan::whereIn('id', $ids)->delete();
            
                    \DB::commit();

                    // Log activity untuk setiap pengguna yang dihapus
                    foreach ($data as $data) {
                        activity('mass remove kecamatan')
                            ->causedBy(Auth::user()) // Log siapa yang melakukan
                            ->performedOn($data) // Data user yang dihapus
                            ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                            ->log('Menghapus data kecamatan ' . $data->nama);
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
            $wilayahkecamatan = [];
            $wilayahkabupatenID = $request->wilayahkabupatenID;
            if ($request->has('q')) {
                $search = $request->q;
                $wilayahkecamatan = WilayahKecamatan::select("id", "nama")
                    ->where('wilayah_kabupaten_id', $wilayahkabupatenID)
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $wilayahkecamatan = WilayahKecamatan::where('wilayah_kabupaten_id', $wilayahkabupatenID)->limit(10)->get();
            }
            return response()->json($wilayahkecamatan);
        }

    

   





}