<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil data pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah pengguna ada dan passwordnya cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Jika login berhasil, buat sesi
            Auth::login($user);

            return redirect()->intended('home')->with('success', 'Login berhasil!');
        }

        // Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->withInput($request->only('email'));
    }

    public function doLogout()
    {
        // Hapus semua data session
        session()->flush();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }

    protected function redirectTo()
    {
        session()->flash('success', 'You are logged in!');
        return $this->redirectTo;
    }
}
