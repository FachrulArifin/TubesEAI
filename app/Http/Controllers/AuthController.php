<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function homePage(){
        return view('index');
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
        dd($user);
        //return redirect()->route('showLogin');
    }

    public function loginAccount(Request $request){
        $data = $request->only('email', 'password');

        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect()->route('homePage');
        } else{
            return redirect()->back()->with('gagal', 'Email atau Password salah!');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('homePage');
    }
}

