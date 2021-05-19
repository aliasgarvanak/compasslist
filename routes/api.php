<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts',[PostsController::class, 'index']);
Route::prefix('/post')->group(function(){
    Route::post('/store',[PostsController::class,'store']);
    Route::get('/{id}',[PostsController::class,'edit']);
    Route::put('/{id}',[PostsController::class,'update']);
    Route::delete('/{id}',[PostsController::class,'destroy']);
});