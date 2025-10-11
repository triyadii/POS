<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.max' => 'Nama Lengkap maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata Sandi wajib diisi',
            'password.min' => 'Kata Sandi minimal 8 karakter',
            'password.confirmed' => 'Kata Sandi tidak sama',
           
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    

        public function register(Request $request)
    {
        // Validasi data input
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            // Return validation errors as JSON
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buat user baru, tapi jangan login
        $user = $this->create($request->all());

        // Trigger event Registered
        event(new Registered($user));

        // Return success response
        return response()->json(['message' => 'Registrasi berhasil! Silakan login untuk melanjutkan.'], 200);
    }

    
}
