<?php
    
namespace App\Http\Controllers\Backend\Wilayah;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WilayahDesa;
use App\Models\WilayahKecamatan;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class WilayahDesaController extends Controller

{

    function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware('permission:village-list', ['only' => ['index','getDataWilayahDesa']]);
        // $this->middleware('permission:village-create', ['only' => ['create','store']]);
        // $this->middleware('permission:village-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:village-delete', ['only' => ['destroy']]);
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
        
        
        return view('backend.data_wilayah.wilayah_desa.index');
    }

    public function getDataWilayahDesa(Request $request, WilayahDesa $wilayahdesa)
    {
       
        $postsQuery = WilayahDesa::orderBy('id', 'desc');
        
        $data = $postsQuery->select('*');

        return \DataTables::of($data)
           

        ->addColumn('action', function($data) {
            $x='';
            if (auth()->user()->can('village-edit') || auth()->user()->can('village-delete')) {

                $x.='<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
              
                if (auth()->user()->can('village-edit')) {
                    $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
                }
                if (auth()->user()->can('village-delete')) {
                    $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                }
                $x .= '</ul></div>';

            }
            return '
            '.$x.'
            ';  
        })


            ->addColumn('wilayahkecamatan', function ($data) {
                return $data->wilayahkecamatan->nama;
            })

           
           
            ->rawColumns(['action','wilayahkecamatan'])
            ->make(true);
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, WilayahDesa $wilayahdesa)
    {

        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
            'wilayah_kecamatan_id' => 'required',
        ], [
            'nama.required' => 'Nama Desa/Kelurahan Wajib diisi',
            'wilayah_kecamatan_id.required' => 'Nama Kecamatan Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        try {
            \DB::beginTransaction();

        $wilayahdesa = new WilayahDesa;
        $wilayahdesa -> nama = $request->nama;
        $wilayahdesa -> wilayah_kecamatan_id = $request->wilayah_kecamatan_id;
        $wilayahdesa ->save();

        $changes = [
            'attributes' => $wilayahdesa
        ];

        activity('tambah desa/kelurahan')
            ->causedBy(Auth::user()->id)
            ->performedOn($wilayahdesa)
            ->withProperties($changes)
            ->log('Membuat data desa/kelurahan dengan nama '.$wilayahdesa->nama);
 
        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $wilayahdesa->nama . ' berhasil disimpan.', 
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
        $wilayahdesa = WilayahDesa::findOrFail($id);

        $html = view('backend.data_wilayah.wilayah_desa.edit', 
        [
        'data' => $wilayahdesa->findOrFail($id),
        'districtSelected' => $wilayahdesa->findOrFail($id)->wilayahkecamatan,
        
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
            'wilayah_kecamatan_id' => 'required',
        ], [
            'nama.required' => 'Nama Desa/Kelurahan Wajib diisi',
            'wilayah_kecamatan_id.required' => 'Nama Kecamatan Wajib diisi'
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            \DB::beginTransaction();

        $wilayahdesa = WilayahDesa::findOrFail($id);
        $oldData = $wilayahdesa->getOriginal();

        $wilayahdesa -> nama = $request->nama;
        $wilayahdesa -> wilayah_kecamatan_id = $request->wilayah_kecamatan_id;
        $wilayahdesa->update();
        $changes = [
            'attributes' => $wilayahdesa,
            'old' => $oldData
        ];
        activity('edit desa/kelurahan')
        ->causedBy(Auth::user()->id)
        ->performedOn($wilayahdesa)
        ->withProperties($changes)
        ->log('Mengubah data desa/kelurahan '.$wilayahdesa->nama);

        \DB::commit();
    
        return response()->json([
            'success' => 'Data ' . $wilayahdesa->nama . ' berhasil diperbaharui.', 
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
            $wilayahdesa = WilayahDesa::findOrFail($id);
            $wilayahdesa->delete();

            $changes = [
                'attributes' => $wilayahdesa
            ];
            activity('hapus desa/kelurahan')
                ->causedBy(Auth::user()->id)
                ->performedOn($wilayahdesa)
                ->withProperties($changes)
                ->log('Menghapus data desa/kelurahan '.$wilayahdesa->nama);

            \DB::commit();

            return response()->json([
                'success' => 'Data ' . $wilayahdesa->nama . ' berhasil dihapus', 
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
                    $data = WilayahDesa::whereIn('id', $ids)->get();

                    // Hapus pengguna
                    WilayahDesa::whereIn('id', $ids)->delete();
            
                    \DB::commit();

                    // Log activity untuk setiap pengguna yang dihapus
                    foreach ($data as $data) {
                        activity('mass remove desa/kelurahan')
                            ->causedBy(Auth::user()) // Log siapa yang melakukan
                            ->performedOn($data) // Data user yang dihapus
                            ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                            ->log('Menghapus data desa/kelurahan ' . $data->nama);
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
        $wilayahdesa = [];
        $wilayahkecamatanID = $request->wilayahkecamatanID;
        if ($request->has('q')) {
            $search = $request->q;
            $wilayahdesa = WilayahDesa::select("id", "nama")
                ->where('wilayah_kecamatan_id', $wilayahkecamatanID)
                ->Where('nama', 'LIKE', "%$search%")
                ->get();
        } else {
            $wilayahdesa = WilayahDesa::where('wilayah_kecamatan_id', $wilayahkecamatanID)->limit(10)->get();
        }
        return response()->json($wilayahdesa);
    }
    


}