<?php

namespace App\Http\Controllers\Backend\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Carbon\Carbon;
use App\Rules\MatchOldPassword;
use Auth;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $akun = Auth::user();
        return view('backend.profile.security.index', compact('akun'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $html = view('backend.profile.security.edit', compact('user'))->render();

        return response()->json(['html' => $html]);
    }

    public function update(Request $request, $id)
    {
        $formattedTime = Carbon::now()->diffForHumans();

        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:8'], // Aturan min:8 ditambahkan
            'new_confirm_password' =>'required|same:new_password'
        ], [
            'email.required' => 'Email wajib diisi',
            'current_password.required' => 'Password Terakhir wajib diisi',
            'new_password.required' => 'Password Baru wajib diisi',
            'new_password.min' => 'Password baru minimal harus 8 karakter', // Pesan kesalahan untuk panjang password
            'new_confirm_password.required' => 'Konfirmasi Password Baru wajib diisi',
            'new_confirm_password.same' => 'Password baru dan konfirmasi password baru tidak sama'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Update email dan password
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->new_password)
            ]);

            // Log activity
            activity('security')
                ->causedBy(Auth::user()) // Pengguna yang melakukan perubahan
                ->performedOn($user) // Objek user yang diubah
                ->withProperties([
                    'attributes' => $user->getOriginal() // Mengambil data user sebelumnya
                ])
                ->log('Mengganti password Akun');

            DB::commit();

            return response()->json([
                'success' => 'Data ' . $user->name . ' berhasil diperbaharui.',
                'time' => $formattedTime,
                'judul' => 'Berhasil'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e); // Menyimpan error ke file log Laravel

            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
                'time' => $formattedTime,
                'judul' => 'Aplikasi Error',
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}
