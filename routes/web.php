<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts',PostsController::class)->middleware('auth');
Route::get('register',[RegisterController::class,'register'])->name('signup');
Route::get('/',[LoginController::class,'signin'])->name('signin');

Route::post('register',[RegisterController::class,'register'])->name('register');
Route::post('signin',[LoginController::class,'loginn'])->name('loginn');
Route::post('logout',[LoginController::class,'logout'])->name('logout');