<?php
    
namespace App\Http\Controllers\Backend;  

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Auth;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:role-list', ['only' => ['index','getDataRoles']]);
        $this->middleware('permission:role-show', ['only' => ['show']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->middleware('permission:role-massdelete', ['only' => ['massDelete']]);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $permission = Permission::all()->groupBy('category');


        return view('backend.roles.index',compact('permission'));
    }

    public function getDataRoles(Request $request, Role $role)
    {
        
        //$postsQuery = Role::where('id','!=','1')->orderBy('id', 'desc');
        $postsQuery = Role::orderBy('id', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('name', 'LIKE', "%{$searchValue}%");
            });
        }

        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
        

        ->addColumn('action', function($data) {
            $x='';
            if (auth()->user()->can('role-show') || auth()->user()->can('role-edit') || auth()->user()->can('role-delete')) {

                $x.='<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                if (auth()->user()->can('role-show')) {
                    $x.=' <li><a class="dropdown-item btn px-3" href="'.route('roles.show', $data->id).'" >Detail</a></li>';
                }
                if (auth()->user()->can('role-edit')) {
                    $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$data->id.'" >Edit</a></li>';
                }
                if (auth()->user()->can('role-delete')) {
                    $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                }
                $x .= '</ul></div>';

            }
            return '
            '.$x.'
            ';  
        })

        ->editColumn('name',function($data){
            $x='';
                $x.=' <label class="badge badge-primary">'.$data->name.'</label>'; 
            return '
                '.$x.'
                ';  
        })

        ->editColumn('guard_name',function($data){
            $x='';
                $x.=' <label class="badge badge-primary">'.$data->guard_name.'</label>'; 
            return '
                '.$x.'
                ';  
        })
           
            ->rawColumns(['action','name','guard_name'])
            ->make(true);
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ], [
            'name.unique' => 'Nama Hak Akses sudah terdaftar',
            'name.required' => 'Nama Hak Akses wajib diisi',
            'permission.required' => 'Permission wajib diisi',
            ]);
            
           
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            
            }
            // Logika penyimpanan data
        try {
            \DB::beginTransaction();
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->permissions()->sync($request->input('permission')); 
        
        $changes = [
            'attributes' => $role
        ];

        activity('tambah role')
            ->causedBy(Auth::user()->id)
            ->performedOn($role)
            ->withProperties($changes)
            ->log('Membuat role dengan nama '.$role->name);


        \DB::commit();
       

       
        return response()->json([
            'success' => ' Data ' . $role->name . ' berhasil disimpan.',
            'time' => $formattedTime,
            'judul' => 'Berhasil'
        ]);
                } catch (\Exception $e) {
            \DB::rollback();
            $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
            return response()->json(['error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.', 'time' => $formattedTime, 'judul' => 'Aplikasi Error', 'errorMessage' => $errorMessage]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $role = Role::findOrFail($id);
    $rolePermissions = $role->permissions;

    $allPermissions = Permission::all()->groupBy('category');

    // Filter permissions to include only those associated with the role
    $permissions = collect();
    foreach ($allPermissions as $category => $categoryItems) {
        $filteredPermissions = $categoryItems->filter(function ($item) use ($rolePermissions) {
            return $rolePermissions->contains('id', $item->id);
        });

        if ($filteredPermissions->isNotEmpty()) {
            $permissions[$category] = $filteredPermissions;
        }
    }

    return view('backend.roles.show', compact('role', 'rolePermissions', 'permissions'));
}
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $html = view('backend.roles.edit', 
        [
        'role' => $role->findOrFail($id),
        'permission' => Permission::all()->groupBy('category'),
        'rolePermissions' => DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                            ->all(),

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
        'name' => 'required|unique:roles,name,' . $id,
        'permission' => 'required|array',
        'permission.*' => 'exists:permissions,id', // Menyakinkan bahwa setiap permission yang diinput benar-benar ada
    ], [
        'name.unique' => 'Nama Hak Akses sudah terdaftar',
        'name.required' => 'Nama Hak Akses wajib diisi',
        'permission.required' => 'Permission wajib diisi',
        'permission.*.exists' => 'Permission yang dipilih tidak valid',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();
         
        // Temukan role berdasarkan ID
        $role = Role::findOrFail($id);
        $oldData = $role->getOriginal();


        
        $role->name = $request->input('name');
        

        // Update permission dan simpan perubahan
        $role->permissions()->sync($request->input('permission'));

        $role->save();

        $changes = [
            'attributes' => $role,
            'old' => $oldData
        ];
        activity('edit role')
        ->causedBy(Auth::user()->id)
        ->performedOn($role)
        ->withProperties($changes)
        ->log('Mengubah role '.$role->name);

        \DB::commit();

        return response()->json(['success' => 'Data ' . $role->name . ' berhasil diperbaharui.', 'time' => $formattedTime, 'judul' => 'Berhasil']);
    } catch (\Exception $e) {
        \DB::rollback();
        $errorMessage = $e->getMessage();
        return response()->json(['error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.', 'time' => $formattedTime, 'judul' => 'Aplikasi Error', 'errorMessage' => $errorMessage]);
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

            // Temukan role berdasarkan ID
            $role = Role::findOrFail($id);
            
            // Hapus role
            $role->delete();

            $changes = [
                'attributes' => $role
            ];
            activity('hapus role')
                ->causedBy(Auth::user()->id)
                ->performedOn($role)
                ->withProperties($changes)
                ->log('Menghapus role '.$role->name);

            \DB::commit();

            return response()->json(['success' => 'Data ' . $role->name . ' berhasil dihapus', 'time' => $formattedTime, 'judul' => 'Berhasil']);
            } catch (\Exception $e) {
                \DB::rollback();
                $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
                return response()->json(['error' => 'Data Gagal dihapus', 'time' => $formattedTime, 'judul' => 'Gagal', 'errorMessage' => $errorMessage]);
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
                    $data = Role::whereIn('id', $ids)->get();

                    // Hapus pengguna
                    Role::whereIn('id', $ids)->delete();
            
                    \DB::commit();

                    // Log activity untuk setiap pengguna yang dihapus
                    foreach ($data as $data) {
                        activity('mass remove role')
                            ->causedBy(Auth::user()) // Log siapa yang melakukan
                            ->performedOn($data) // Data user yang dihapus
                            ->withProperties(['attributes' => $data->toArray()]) // Menyimpan data atribut pengguna
                            ->log('Menghapus akun role dengan nama ' . $data->name);
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
            $role = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $role = Role::select("id", "name")
                    ->Where('name', 'LIKE', "%$search%")
                    ->get();
            } else {
                $role = Role::limit(30)->get();
            }
            return response()->json($role);
        }
}
