<?php
    
    namespace App\Http\Controllers\Backend\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Validator;
use Auth;
use Illuminate\Support\Str;
use File;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use App\Models\AkunBank;
use App\Models\KontakDarurat;



    
class ProfileController extends Controller
{ 
   
    function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('backend.profile.profile.index');

    }

    public function edit($id)
{
    // Fetch the user with the related karyawan model
    $user = User::findOrFail($id);
    
    // Prepare the view with the user data and selected regions
    $html = view('backend.profile.profile.edit', [
        'user' => $user
    ])->render();

    return response()->json(['html' => $html]);
}

    
    

public function update(Request $request, $id)
{
    $formattedTime = Carbon::now()->diffForHumans();

    $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:100',
        
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
       
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        DB::beginTransaction();

        // Ambil data pengguna
        $user = User::findOrFail($id);
        $user->update(['name' => $request->input('name')]);

      


        // Activity logging
        activity('profile')
            ->causedBy(Auth::user()->id)
            ->performedOn($user)
            ->withProperties(['attributes' => $user->toArray()])
            ->log('Mengubah Data Profile Akun');

        DB::commit();

        return response()->json([
            'success' => 'Data ' . $user->name . ' berhasil diperbaharui.',
            'time' => $formattedTime,
            'judul' => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
            'time' => $formattedTime,
            'judul' => 'Aplikasi Error',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}


    

   
    
   
}