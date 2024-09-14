<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PublicController::class,'index']);

Route::get('/register',[AuthController::class,'registerpage'])->name('register')->middleware('guest');
Route::post('/register',[AuthController::class,'register'])->name('register')->middleware('guest');

Route::get('/login',[AuthController::class,'loginpage'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'login'])->name('login')->middleware('guest');

Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');

Route::get('/blog',[PostController::class,'blog'])->name('blog')->middleware('auth');

Route::get('/post/{slug}',[PublicController::class,'viewpost'])->name('blog')->middleware('auth');


Route::get('/create',[PostController::class,'createpage'])->name('create')->middleware('auth');
Route::post('/create',[PostController::class,'create'])->name('create')->middleware('auth');

Route::get('/user/{user}',[PublicController::class,'viewpostByuser']);

Route::get('/edit-avatar/{user}',[PublicController::class,'editpage'])->middleware('can:update,user');
Route::put('/edit-avatar/{user}',[PublicController::class,'edit'])->middleware('can:update,user');


Route::get('/edit-profile/{user}',[PublicController::class,'editprofilepage'])->middleware('can:update,user');
Route::put('/edit-email/{user}',[PublicController::class,'editemail'])->middleware('can:update,user');
Route::put('/change-name/{user}',[PublicController::class,'editname'])->middleware('can:update,user');
Route::put('/change-phone/{user}',[PublicController::class,'editphone'])->middleware('can:update,user');
Route::put('/change-pass/{user}',[PublicController::class,'editpassword'])->middleware('can:update,user');

Route::delete('/post/delete/{slug}',[PostController::class,'delete'])->name('delete.post')->middleware('post.owner');

Route::post('/post/{post}/like',[PostController::class,'like'])->middleware('auth');


Route::get('/search/',[PublicController::class,'search'])->name('blog.search');

Route::post('/comment/{post}',[CommentController::class,'comment'])->middleware('auth');

Route::delete('/comment/{comment}',[CommentController::class,'deletecomment'])->name('delete.comment')->middleware('can:delete,comment');

Route::post('/saved-post',[PostController::class,'save']);

Route::get('/getsavedposts',[PostController::class,'getsavedposts'])->middleware('auth');
