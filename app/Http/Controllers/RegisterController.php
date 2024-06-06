<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Http\Requests\RegisterRequest;


class RegisterController extends Controller
{
    public function register(){
        
    	return view('auth.register');
    }


    protected function create(RegisterRequest $request)
    {
        $data = $request->validated();
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect()->route('posts.index');
       
    }



}
