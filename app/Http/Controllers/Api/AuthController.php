<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;


class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $data = $request->validated();
        $authService->registerUser($data);
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token-name')->plainTextToken,
        ], 201);
    }


    public function signin(LoginRequest $request, AuthService $authService)
    {
        $validate = $request->validated();
        $credentials = $authService->loginUserCredentials($validate,$request);
        $user = User::where('email', $credentials['email'])->first();
        if (Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token-name')->plainTextToken,
        ]);
    }

    public function logout(Request $request,)
    {
        if (Auth::user()) {
            auth()->user()->tokens()->delete();
             return response()->json('Logged out successfully');
        }
    }

}
