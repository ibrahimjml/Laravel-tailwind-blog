<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

  Route::get('/user', function (Request $request) {
      return $request->user();
  });

  Route::post('/logout', [AuthController::class, 'logout']);
});

// login api to access token
Route::post('/login', [AuthController::class, 'login']);

// Blog Page
Route::get('/blog',[PostControllerApi::class,'blog'])->name('blog');

// view Post Page
Route::get('/posts/{post}',[PostControllerApi::class,'viewpost'])->name('view-post');

// create post
Route::post('/create',[PostControllerApi::class,'create'])->name('create-post');

// update post
Route::put('/post/update/{post}',[PostControllerApi::class,'update'])->name('update.post');

// Delete Post
Route::delete('/post/{post}',[PostControllerApi::class,'destroy'])->name('destroy');


