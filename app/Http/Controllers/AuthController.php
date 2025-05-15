<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
   public function index(){
    if (Auth::user()){
        $userId = Auth::User()->id;
        return redirect()->route('profile', $userId);
    }
    return view('user-login');
   }

   public function loginAtttempt(Request $request)
   {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    
    if(Auth::attempt($credentials)){
        $request->session()->regenerate();

        $userId = Auth::User()->id;
        return redirect()->route('service-index');
    }

        return back()->withInput()->with('status', 'Login invalido');
   }

   public function logout(Request $request)
   {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
   }
}
