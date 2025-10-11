<?php

namespace App\Http\Controllers\Backend\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Changelog;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:changelog-list', ['only' => ['index','getDataChangelog']]);
        $this->middleware('permission:changelog-show', ['only' => ['show']]);
        $this->middleware('permission:changelog-create', ['only' => ['store']]);
        $this->middleware('permission:changelog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:changelog-delete', ['only' => ['destroy']]);
        $this->middleware('permission:changelog-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.help.changelog.index');
    }

    public function getDataChangelog(Request $request, Changelog $changelog)
    {
        $postsQuery = Changelog::orderBy('created_at', 'desc');
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
            $x='';
            if (auth()->user()->can('changelog-show') || auth()->user()->can('changelog-edit') || auth()->user()->can('changelog-delete')) {

            $x.='<div class="dropdown text-end" >
            <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
      Actions
                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
  </button>
<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
            if (auth()->user()->can('changelog-show')) {
                $x.='<li><a class="dropdown-item btn px-3" href="'.route('changelog.show', $data->id).'" >Detail</a></li>';
            }
            if (auth()->user()->can('changelog-edit')) {
                $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
            }
            if (auth()->user()->can('changelog-delete')) {
                $x.='<li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Changelog::findOrFail($id);

        // Decode the JSON string into a PHP array
        $logs = json_decode($data->logs, true);

        // Extract only the "New" logs
        $newLogs = isset($logs['New']) ? $logs['New'] : [];
        $updateLogs = isset($logs['Update']) ? $logs['Update'] : [];
        $fixLogs = isset($logs['Fix']) ? $logs['Fix'] : [];

        return view('backend.help.changelog.show', compact('data', 'newLogs','updateLogs','fixLogs'));
    }



    public function store(Request $request)
    {
        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            //'logs' => 'required',
        ], [
            
            'nama.required' => 'Nama Perubahan',
            'deskripsi.required' => 'Deskripsi Perubahan wajib diisi',
            //'logs.required' => 'Logs Wajib diisi',
            ]);
            
        if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
        // Logika penyimpanan data
        try {
            \DB::beginTransaction();


        // Convert the nested arrays to a JSON string
        $logs = [
            'New' => $request->input('add-new-repeater'),
            'Update' => $request->input('add-update-repeater'),
            'Fix' => $request->input('add-fix-repeater'),
        ];

        // Create Store instance
        $data = Changelog::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'logs' => json_encode($logs),
        ]);

        $changes = [
            'attributes' => $data
        ];

        activity('tambah changelog')
            ->causedBy(Auth::user()->id)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Membuat changelog dengan nama '.$data->nama);
    
        \DB::commit();

        return response()->json([
            'success' => ' Data ' . $data->nama . ' berhasil disimpan.',
            'time' => $formattedTime,
            'judul' => 'Berhasil'
        ]);
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
        $data = Changelog::findOrFail($id);

        $html = view('backend.help.changelog.edit', 
            [
                'data' => $data->findOrFail($id)
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
            'deskripsi' => 'required',
            //'logs' => 'required',
        ], [
            
            'nama.required' => 'Nama Perubahan',
            'deskripsi.required' => 'Deskripsi Perubahan wajib diisi',
            //'logs.required' => 'Logs Wajib diisi',
            ]);
            
        if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
        // Logika penyimpanan data
        try {
            \DB::beginTransaction();

        // Convert the nested arrays to a JSON string
        // Convert the nested arrays to a JSON string
        $logs = [
            'New' => array_filter($request->input('logs.new', []), function($log) {
                return !empty($log['nama']) || !empty($log['deskripsi']);
            }),
            'Update' => $request->input('logs.update', []),
            'Fix' => $request->input('logs.fix', [])
        ];
        

        $data = Changelog::findOrFail($id);
        $oldData = $data->getOriginal();
        $data -> update([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'logs' => json_encode($logs),
        ]);

        //log activity
        $changes = [
            'attributes' => $data,
            'old' => $oldData
        ];
        activity('edit changelog')
        ->causedBy(Auth::user()->id)
        ->performedOn($data)
        ->withProperties($changes)
        ->log('Mengubah changelog dengan nama '.$data->nama);
    
        \DB::commit();

        return response()->json([
            'success' => ' Data ' . $data->nama . ' berhasil diperbaharui.',
            'time' => $formattedTime,
            'judul' => 'Berhasil'
        ]);
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

            $data = Changelog::findOrFail($id);
        
    
            $data->delete();

            // Log activity
        $changes = [
            'attributes' => $data
        ];
        activity('hapus changelog')
            ->causedBy(Auth::user()->id)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Menghapus changelog dengan nama '.$data->nama);

            \DB::commit();

            return response()->json([
                'success' => 'Data ' . $data->nama . ' berhasil dihapus', 
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
                $data = Changelog::whereIn('id', $ids)->get();

                // Hapus pengguna
                Changelog::whereIn('id', $ids)->delete();
        
                \DB::commit();

                // Log activity untuk setiap pengguna yang dihapus
                foreach ($data as $data) {
                    activity('mass remove changelog')
                        ->causedBy(Auth::user()) // Log siapa yang melakukan
                        ->performedOn($data) // Data user yang dihapus
                        ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                        ->log('Menghapus data changelog ' . $data->name);
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
}
