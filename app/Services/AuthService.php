<?php 

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthService {

    public function registerUser(array $data){

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return $user;
    }

    public function loginUserCredentials(array $userData , Request $request){
         $credentials['email'] = $userData['email'];
         $credentials['password'] = $userData['password'];
         
         return $credentials;
        
    }
}