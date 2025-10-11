<?php
    
namespace App\Http\Controllers\Backend;  

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use DataTables; 
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
    
class UserController extends Controller
{


    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:user-list', ['only' => ['index','getUsers']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-massdelete', ['only' => ['massDelete']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $roles = Role::orderBy('id', 'desc')
        ->get();
       
  
        return view('backend.users.index',compact('roles'));
    }

    

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $postsQuery = User::with('roles')->orderBy('created_at', 'desc');

            // Filter berdasarkan role jika filterrole disetel
            $postsQuery->when(!empty($_GET["filterrole"]), function ($query) {
                $filterrole = $_GET["filterrole"];
                return $query->whereHas('roles', function ($query) use ($filterrole) {
                    $query->where('id', $filterrole);
                });
            });

            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $postsQuery->where(function ($query) use ($searchValue) {
                    $query->where('name', 'LIKE', "%{$searchValue}%")
                          ->orWhere('email', 'LIKE', "%{$searchValue}%");
                });
            }
    
            $data = $postsQuery->select('*');
    
    
            return \DataTables::of($data) 
                ->addIndexColumn()
                ->addColumn('avatar', function($row) {
                    if ($row->avatar) {
                        // Jika avatar ada dan berasal dari Google, gunakan URL dari provider Google
                        if ($row->provider == 'google') {
                            return ' <div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="' . $row->avatar . '" alt="' . $row->name . '" class="w-100" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="' . route('users.show', $row->id) . '" class="text-gray-800 text-hover-primary mb-1">' . $row->name . '</a>
                                            <span>' . $row->email . '</span>
                                        </div>
                                    </div>';
                        } else {
                            // Jika avatar ada, tetapi bukan dari Google (misalnya dari aplikasi Laravel)
                            return ' <div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="' . asset('uploads/user/avatar/' . $row->avatar) . '" alt="' . $row->name . '" class="w-100" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="' . route('users.show', $row->id) . '" class="text-gray-800 text-hover-primary mb-1">' . $row->name . '</a>
                                            <span>' . $row->email . '</span>
                                        </div>
                                    </div>';
                        }
                    } else {
                        // Jika avatar kosong, tampilkan huruf pertama dari nama pengguna
                        $initial = strtoupper(substr($row->name, 0, 1));
                        return '<div class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">' . $initial . '</div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="' . route('users.show', $row->id) . '" class="text-gray-800 text-hover-primary mb-1">' . $row->name . '</a>
                                        <span>' . $row->email . '</span>
                                    </div>
                                </div>';
                    }
                })
                
                ->addColumn('roles', function($row) {
    $roleNames = $row->getRoleNames(); // Ambil semua role dari user
    
    // Cek apakah user memiliki roles
    if ($roleNames->isEmpty()) {
        return 'no roles assigned'; // Teks default jika tidak ada role
    }
    
    // Jika ada roles, gabungkan menjadi string yang dipisahkan koma
    return implode(', ', $roleNames->toArray());
})

                ->addColumn('last_login_at', function($row) {
                    if ($row->last_login_at) {
                        $formattedTime = Carbon::parse($row->last_login_at)->diffForHumans();
                        return '<div class="badge badge-light fw-bold">' . $formattedTime . '</div>';
                    } else {
                        return '<div class="badge badge-light fw-bold">Never logged in</div>';
                    }
                })
                ->addColumn('last_login_ip', function($row) {
                    return '<div class="badge badge-light fw-bold">' . ($row->last_login_ip ?: 'N/A') . '</div>';
                })
                ->addColumn('joined_date', function($row) {
                    if ($row->created_at) {
                        $formattedTime = Carbon::parse($row->created_at)
                                            ->locale('id')  // Set locale to Indonesian
                                            ->translatedFormat('d F Y, H:i');
                        return '<div class="badge badge-light fw-bold">' . $formattedTime . '</div>';
                    } else {
                        return '<div class="badge badge-light fw-bold">N/A</div>';
                    }
                })
                
              

                ->addColumn('action', function($row) {
                    $x='';
                    if (auth()->user()->can('user-show') || auth()->user()->can('user-edit') || auth()->user()->can('user-delete')) {
        
                        $x.='<div class="dropdown text-end">
          <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
              Actions
                                            <i class="ki-outline ki-down fs-5 ms-1"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                        if (auth()->user()->can('user-show')) {
                            $x.=' <li><a class="dropdown-item btn px-3" href="'.route('users.show', $row->id).'" >Detail</a></li>';
                        }
                        if (auth()->user()->can('user-edit')) {
                            $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$row->id.'" >Edit</a></li>';
                        }
                        if (auth()->user()->can('user-delete')) {
                            $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                        }
                        $x .= '</ul></div>';
        
                    }
                    return '
                    '.$x.'
                    ';  
                })



              
                
                

                ->rawColumns(['avatar', 'roles', 'last_login_at', 'last_login_ip', 'joined_date', 'action'])
                ->make(true);
        }
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'required|mimes:jpg,png,svg|max:2048',
            'roles' => 'required',
        
        ], [
            
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.max' => 'Nama Lengkap maksimal 255 karakter',
           
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Kata Sandi minimal 8 krakter',
            'password.confirmed' => 'Kata Sandi tidak sama',
            'avatar.required' => 'Avatar wajib diisi',
            'avatar.mimes' => 'Avatar harus format .jpg .png .svg',
            'avatar.max' => 'Ukuran file Avatar maksimal 2 MB',
            'roles.required' => 'Role wajib diisi',
            
        
            ]);
            
       
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

       

        // Logika penyimpanan data
        try {
            \DB::beginTransaction();

        $data = new User;
        if ($request->hasFile('avatar')) {
			
            $image = $request->file('avatar');
            $name = date('YmdHis') . $image->getClientOriginalName();
            $image->move('uploads/user/avatar/', $name);
            $data->avatar = $name;
        }
        $data -> id = Uuid::uuid4();
        $data -> name = $request->name;
        $data -> email = $request->email;
        $data -> password = Hash::make($request->password);
        $data->assignRole($request->input('roles'));

        $data->save();


        $changes = [
            'attributes' => $data
        ];

        activity('tambah user')
            ->causedBy(Auth::user()->id)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Membuat akun user atas nama '.$data->name);

        \DB::commit();
       
        return response()->json([
            'success' => 'Data berhasil disimpan.', 
            'time' => $formattedTime, 
            'judul' => 'Berhasil'],201);
        } catch (\Exception $e) {
            \DB::rollback();
            $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.', 
                'time' => $formattedTime, 
                'judul' => 'Aplikasi Error', 
                'errorMessage' => $errorMessage],500);
        }
    
    
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
    public function show($id): View
    {
        // Menemukan user berdasarkan id
        $data = User::findOrFail($id);
      
        // Mengirim data ke view
        return view('backend.users.show', compact('data'));
    }
    

    public function getUserShowLog(Request $request, $id)
    {
        $postsQuery = Activity::with('causer')
            ->where('causer_id', $id)
            ->whereIn('log_name', ['login', 'logout']) // Tambahkan klausa whereIn untuk log_name
            ->orderBy('id', 'desc')
            ->take(5);

        $data = $postsQuery->get();


        return \DataTables::of($data) 

        ->addColumn('created_at', function ($data) {
            $x = '';
            if (empty($data->created_at)) {
                $x .= '<div class="text-end" role="group"> <label class="badge badge-warning">Belum Pernah Login</label></div>';
            } else {
                $x .= '<div class="text-end" role="group"><label class="badge badge-info">' . $data->created_at->diffForHumans() . '</label></div>';
            }
        
            return $x;
        })
        
       
        ->addColumn('description', function ($data) {
            return $data->description;
        })
        ->addColumn('ip', function ($data) {
            return $data->properties['agent']['ip'];
        })
        
        ->addColumn('os', function ($data) {
            return $data->properties['agent']['os'] . ' - ' . $data->properties['agent']['browser'];
        })
        
        ->addColumn('device', function ($data) {
            $x = '';
            
            if ($data->properties['agent']['device'] === 'Desktop') {
                $x .= '<i class="ki-outline ki-screen text-primary me-2"></i>' . $data->properties['agent']['device'];
            } elseif ($data->properties['agent']['device'] === 'Tablet') {
                $x .= '<i class="ki-outline ki-tablet text-success me-2"></i>' . $data->properties['agent']['device'];
            } elseif ($data->properties['agent']['device'] === 'Phone') {
                $x .= '<i class="ki-outline ki-phone text-warning me-2"></i>' . $data->properties['agent']['device'];
            } else {
                $x .= '<i class="ki-outline ki-question-2 text-danger me-2"></i>Unknown';
            }
        
            return $x;
        })
        
        

            ->rawColumns(['created_at', 'ip', 'description', 'browser', 'os', 'device'])
            ->make(true);
    }

    public function getUserShowLogActivity(Request $request, $id)
    {
        
        $postsQuery = Activity::with('causer')
        ->where('causer_id', $id)
        ->whereNotIn('log_name', ['login', 'logout']) // Tambahkan klausa whereNotIn untuk log_name
        ->orderBy('id', 'desc')
        ->take(5);

        $data = $postsQuery->get();

        return \DataTables::of($data) 

        ->addColumn('created_at', function ($data) {
            $x = '';
            if (empty($data->created_at)) {
                $x .= ' <div class="text-end" role="group"><label class="badge badge-warning text-end">Belum Pernah Login</label></div>';
            } else {
                $x .= ' <div class="text-end" role="group"><label class="badge badge-info">' . $data->created_at->format('d-m-Y H:i:s') . '</label></div>';

            }
        
            return $x;
        })
        
       
        ->addColumn('description', function ($data) {
            return $data->description;
        })
        ->addColumn('ip', function ($data) {
            return $data->properties['agent']['ip'];
        })
        

            ->rawColumns(['created_at', 'ip', 'description'])
            ->make(true);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
    
        // Kirim data ke view untuk di-render
        $html = view('backend.users.edit', [
            'user' => $user,
            'userRole' => $user->getRoleNames()->toArray(),
            'roles' => Role::where('guard_name', '=', 'web')->select(['id', 'name'])->get(),
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
    
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'confirmed',
            'avatar' => 'mimes:jpg,png,svg|max:2048',
            'roles' => 'required',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.max' => 'Nama Lengkap maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.confirmed' => 'Kata Sandi tidak sama',
            'avatar.mimes' => 'Avatar harus format .jpg .png .svg',
            'avatar.max' => 'Ukuran file Avatar maksimal 2 MB',
            'roles.required' => 'Role wajib diisi',
          
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    
        try {
            \DB::beginTransaction();
    
            $data = User::findOrFail($id);
            $oldData = $data->getOriginal();
    
            if ($request->hasFile('avatar')) {
                $data->hapus_avatar();
                $image = $request->file('avatar');
                $name = date('YmdHis') . $image->getClientOriginalName();
                $image->move('uploads/user/avatar/', $name);
                $data->avatar = $name;
            }
    
            $data->name = $request->name;
            $data->email = $request->email;
    
            if (!empty($request->password)) { 
                $data->password = Hash::make($request->password);
            }
    
            $data->save();
    
            // Sync roles
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $data->assignRole($request->input('roles'));
    
           
    
            // Log activity
            $changes = [
                'attributes' => $data,
                'old' => $oldData
            ];
    
            activity('edit user')
                ->causedBy(Auth::user()->id)
                ->performedOn($data)
                ->withProperties($changes)
                ->log('Mengubah akun user atas nama '.$data->name);
    
            \DB::commit();
    
            return response()->json([
                'success' => 'Data berhasil diperbaharui.',
                'time' => $formattedTime,
                'judul' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            $errorMessage = $e->getMessage();
            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
                'time' => $formattedTime,
                'judul' => 'Aplikasi Error',
                'errorMessage' => $errorMessage,
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
        $data = User::findOrFail($id);
       

        if(is_null($data->avatar)) {
            $data->delete();
		}else{
            $data->hapus_avatar();    
            $data->delete();
		}
 
        \DB::commit();

        // Log activity
        $changes = [
            'attributes' => $data
        ];
        activity('hapus user')
            ->causedBy(Auth::user()->id)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Menghapus akun user atas nama '.$data->name);

        return response()->json(['success' => 'Data berhasil dihapus', 'time' => $formattedTime, 'judul' => 'Berhasil']);
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
            $users = User::whereIn('id', $ids)->get();

            // Hapus pengguna
            User::whereIn('id', $ids)->delete();
    
            \DB::commit();

            // Log activity untuk setiap pengguna yang dihapus
            foreach ($users as $user) {
                activity('mass remove user')
                    ->causedBy(Auth::user()) // Log siapa yang melakukan
                    ->performedOn($user) // Data user yang dihapus
                    ->withProperties(['attributes' => $user->toArray()]) // Menyimpan data atribut pengguna
                    ->log('Menghapus akun user atas nama ' . $user->name);
            }

            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' users deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No users selected for deletion.'
            ]);
        }
    } catch (\Exception $e) {
        \DB::rollback();
        $errorMessage = $e->getMessage(); // Mendapatkan pesan kesalahan dari Exception
        return response()->json(['error' => 'Data Gagal dihapus', 'time' => $formattedTime, 'judul' => 'Gagal', 'errorMessage' => $errorMessage]);
    }
}

    

}
