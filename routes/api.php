<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostCommentController;
use App\Http\Controllers\Api\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/signin',[AuthController::class,'signin']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::group(['prefix' => 'v1'], function () {
    Route::get('/status', function(){
        return response()->json(['status'=>'OK']);
    })->name('status');
    Route::apiResource('posts.comments', PostCommentController::class)->middleware('auth:sanctum');
});
// Route::fallback(function(){
//     return response()->json([
//         'message'=> 'Not Found'
//     ],404);
// })->name('api.fallback');
