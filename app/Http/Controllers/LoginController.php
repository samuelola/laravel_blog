<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class LoginController extends Controller
{
    
    public function signin(){

    	return view('auth.login');
    }


    public function loginn(LoginRequest $request, AuthService $authService){

      $validate = $request->validated();  
      $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;
      $credentials = $authService->loginUserCredentials($validate,$request);
      if (Auth::attempt($credentials,$remember_me)) {
            $request->session()->regenerate();
            return redirect()->route('posts.index');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);


    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
        // return redirect()->route('login');
    }
}
