<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostCommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts',PostsController::class);
Route::post('/addcomment/{post}',[PostCommentController::class,'store'])->name('addcomment');
Route::resource('users',UserController::class);
Route::get('register',[RegisterController::class,'register'])->name('signup');
Route::get('/',[LoginController::class,'signin'])->name('signin');

Route::post('register',[RegisterController::class,'register'])->name('register');
Route::post('signin',[LoginController::class,'loginn'])->name('loginn');
Route::post('logout',[LoginController::class,'logout'])->name('logout');