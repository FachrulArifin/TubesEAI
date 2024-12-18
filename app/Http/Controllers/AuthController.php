<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function homePage(){
        $data = Products::all();
        return view('index', compact('data'));
    }
    public function showPageLogin(){
        return view('login');
    }

    public function showPageRegister(){
        return view('register');
    }

    public function createAccount(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('showLogin');
    }

    public function loginAccount(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Regenerate session
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->route('homePage');
            } else {
                Auth::logout(); // Logout jika role tidak valid
                return redirect()->route('login')->with('gagal', 'Role tidak dikenali!');
            }
        }

        return redirect()->back()->with('gagal', 'Email atau Password salah!');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('homePage');
    }
}

