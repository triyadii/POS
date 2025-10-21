<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->put('login_error', trans('auth.failed'));
        throw ValidationException::withMessages(
            [
                'error' => [trans('Email atau Password yang anda masukkan salah.')],
            ]
        );
    }

    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|string',
                'password' => 'required|string',
                //'g-recaptcha-response' => 'required|captcha',
            ],
            [
                'email.required' => 'Email harus diisi',
                'password.required' => 'Password harus diisi'
                //'g-recaptcha-response.required' => 'Google Recaptcha wajib di isi'
            ]
        );
    }

    public function login(Request $request)
{
    $this->validateLogin($request); // Validasi input

    if (Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['success' => true, 'redirect' => $this->redirectTo]);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid credentials.']);
    }
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'You have logged out successfully.');
}

public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback and create user if necessary
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

       

        // Check if the user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Jika pengguna belum ada, buat pengguna baru
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'provider' => 'google',
                'id' => Uuid::uuid4(),
                'password' => Hash::make(Str::random(32)),
            ]);
        } else {
            // Jika pengguna sudah ada, perbarui avatar jika berbeda
            if ($user->avatar !== $googleUser->getAvatar()) {
                $user->update([
                    'avatar' => $googleUser->getAvatar(), // Update avatar
                ]);
            }
        }

         // Login user setelah dibuat
         Auth::login($user, true);

         return redirect()->to('/dashboard');  // Ganti ke halaman yang sesuai setelah login
    }



    

}
