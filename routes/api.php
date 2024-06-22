<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostCommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('/status', function(){
        return response()->json(['status'=>'OK']);
    })->name('status');
    Route::apiResource('posts.comments', PostCommentController::class);
});
