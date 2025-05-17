<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

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

   /**
    * Display the forgot password form
    */
   public function forgotPassword()
   {
       return view('auth.forgot-password');
   }

   /**
    * Handle the forgot password form submission
    */
   public function sendResetLink(Request $request)
   {
       $request->validate([
           'email' => 'required|email',
       ]);

       // Send the password reset link
       $status = Password::sendResetLink(
           $request->only('email')
       );

       return $status === Password::RESET_LINK_SENT
                   ? back()->with(['success' => 'Link de recuperação enviado para seu email!'])
                   : back()->withErrors(['email' => __($status)]);
   }

   /**
    * Display the password reset form
    */
   public function resetPassword(Request $request, $token)
   {
       return view('auth.reset-password', [
           'token' => $token,
           'email' => $request->email
       ]);
   }

   /**
    * Handle the password reset form submission
    */
   public function updatePassword(Request $request)
   {
       $request->validate([
           'token' => 'required',
           'email' => 'required|email',
           'password' => 'required|min:7|confirmed',
       ]);

       // Find the user
       $user = User::where('email', $request->email)->first();
       
       // Validate password strength if user exists
       if ($user) {
           $strongPassword = $user->validatePassword($request->password);
           
           // Here we're using the validated strong password
           $status = Password::reset(
               $request->only('email', 'password', 'password_confirmation', 'token'),
               function ($user, $password) use ($strongPassword) {
                   $user->forceFill([
                       'password' => Hash::make($strongPassword),
                       'remember_token' => Str::random(60),
                   ])->save();

                   event(new PasswordReset($user));
               }
           );
       } else {
           $status = Password::INVALID_USER;
       }

       return $status === Password::PASSWORD_RESET
                   ? redirect()->route('login')->with('success', 'Senha redefinida com sucesso!')
                   : back()->withErrors(['email' => [__($status)]]);
   }
}
