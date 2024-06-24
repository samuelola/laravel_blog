<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class RegisterController extends Controller
{
    public function register(){
        
    	return view('auth.register');
    }


    protected function create(RegisterRequest $request, AuthService $authService)
    {
        $data = $request->validated();
        $authService->registerUser($data);
        return redirect()->route('posts.index');
       
    }



}
