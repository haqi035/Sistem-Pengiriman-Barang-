<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginForm() {
        if (Auth::check()) {
            return match(Auth::user()->role) {
                'admin'   => redirect('/admin/dashboard'),
                'courier' => redirect('/courier/dashboard'),
                default   => redirect('/customer/dashboard'),
            };
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors(['email'=>'Akun tidak aktif.']);
            }
            return match(Auth::user()->role) {
                'admin'   => redirect('/admin/dashboard'),
                'courier' => redirect('/courier/dashboard'),
                default   => redirect('/customer/dashboard'),
            };
        }
        return back()->withErrors(['email'=>'Email atau password salah.'])->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}