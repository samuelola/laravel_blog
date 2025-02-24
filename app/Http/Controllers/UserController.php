<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\UpdateUser;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Facades\CounterFacade;
use App\Services\UserService;

class UserController extends Controller
{
    
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['show','edit','update']),
        ];
        $this->authorizeResource(User::class,'user');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //  $counter = resolve(Counter::class);
        return view('users.show',[
            'user'=>$user,
            'counter' => CounterFacade::increment("user-{$user->id}")
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request, User $user, UserService $userService)
    {
        $userService->updateUserImage($request,$user);
        return redirect()->back()->withStatus('User Profile Image Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
