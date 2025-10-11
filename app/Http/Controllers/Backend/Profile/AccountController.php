<?php
    
namespace App\Http\Controllers\Backend\Profile;

use App\Http\Controllers\Controller;
    
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use File;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Auth;

use DataTables; 
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
    
class AccountController extends Controller
{


    function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware('permission:user-list', ['only' => ['index','getDataUser']]);
        // $this->middleware('permission:user-show', ['only' => ['show']]);
        // $this->middleware('permission:user-create', ['only' => ['create','store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
       
  
        return view('backend.profile.index');    
    }

    public function editAvatar($id, User $user)
    {
        
        
        $html = view('backend.profile.change_pic', 
        [
        'user' => $user->findOrFail($id)
        ])->render();
       
                                                                																						
        return response()->json(['html'=>$html]);
    }


    public function updateAvatar(Request $request, $id)
    {

        $formattedTime = Carbon::now()->diffForHumans();
        $validator = \Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpg,png|max:2048'
        ], [
            
            'avatar.required' => 'Foto wajib di upload',
            'avatar.mimes' => 'Foto harus format .jpg .png',
            'avatar.max' => 'Ukuran file Foto maksimal 2 MB'
            
        ]);
         
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        
        try {
            \DB::beginTransaction();

        $user = User::find($id);

        if ($request->hasFile('avatar')) {
			$user->hapus_avatar();
            $image = $request->file('avatar');
            $name = date('YmdHis') . $image->getClientOriginalName();
            $image->move('uploads/user/avatar/', $name);
            $user->avatar = $name;
        }

        $user->update();
        $changes = [
            'attributes' => $user
        ];

        activity('profile')
            ->causedBy(Auth::user()->id)
            ->performedOn($user)
            ->withProperties($changes)
            ->log('Mengganti Avatar');
 
        \DB::commit();
    
        return response()->json([
            'success' => 'Data berhasil diperbaharui.', 
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

    

   
}
