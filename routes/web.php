<?php

use App\Http\Controllers\AdminController;
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

// HOME
Route::get('/',[PublicController::class,'index']);

// Register
Route::get('/register',[AuthController::class,'registerpage'])->name('register')->middleware('guest');
Route::post('/register',[AuthController::class,'register'])->name('register.post')->middleware('guest');

//Login
Route::get('/login',[AuthController::class,'loginpage'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'login'])->name('login.post')->middleware('guest');

//Forget password
Route::get('/forgotpassword',[AuthController::class,'forgot'])->name('forgot.password');
Route::post('/forgotpassword',[AuthController::class,'forgotpass'])->name('forgot.password.post');

//Reset password
Route::get('/reset/{token}',[AuthController::class,'reset'])->name('reset.password');
Route::post('/reset/{token}',[AuthController::class,'reset_pass'])->name('reset.password.post');

// Logout
Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');

// Blog Page
Route::get('/blog',[PostController::class,'blog'])->name('blog')->middleware('auth');

// Post Page
Route::get('/post/{slug}',[PublicController::class,'viewpost'])->name('blog')->middleware('auth');

// Create Post
Route::get('/create',[PostController::class,'createpage'])->name('create')->middleware('auth');
Route::post('/create',[PostController::class,'create'])->name('create')->middleware('auth');

// User Profile
Route::get('/user/{user}',[PublicController::class,'viewpostByuser'])->name('profile');;

// Edit Profile Image
Route::get('/edit-avatar/{user}',[PublicController::class,'editpage'])->middleware('can:view,user');
Route::put('/edit-avatar/{user}/edit',[PublicController::class,'edit'])->middleware('can:update,user');
Route::delete('/delete-avatar/{user}',[PublicController::class,'destroyavatar'])->name('delete.avatar')->middleware('can:delete,user');

// Edit Profile Page
Route::get('/edit-profile/{user}',[PublicController::class,'editprofilepage'])->middleware('can:view,user');

// Edit User email,name,phone,pass
Route::put('/edit-email/{user}',[PublicController::class,'editemail'])->middleware('can:update,user');
Route::put('/change-name/{user}',[PublicController::class,'editname'])->middleware('can:update,user');
Route::put('/change-phone/{user}',[PublicController::class,'editphone'])->middleware('can:update,user');
Route::put('/change-pass/{user}',[PublicController::class,'editpassword'])->middleware('can:update,user');

// Delete Post
Route::delete('/post/{slug}',[PostController::class,'delete'])->name('delete.post');

// Edit Post
Route::get('/post/edit/{slug}',[PostController::class,'editpost'])->name('edit.post');
Route::put('/post/update/{slug}',[PostController::class,'update'])->name('update.post');

// Like
Route::post('/post/{post}/like',[PostController::class,'like'])->middleware('auth');

// Search
Route::get('/search/',[PublicController::class,'search'])->name('blog.search');

// Comment
Route::post('/comment/{post}',[CommentController::class,'comment'])->middleware('auth');

// Delete Comment
Route::delete('/comment/{comment}',[CommentController::class,'deletecomment'])->name('delete.comment')->middleware('can:delete,comment');

// Save Post
Route::post('/saved-post',[PostController::class,'save']);

// Saved Posts Page
Route::get('/getsavedposts',[PostController::class,'getsavedposts'])->middleware('auth');

// admin panel
Route::controller(AdminController::class)->group(function(){

  Route::get('/admin-panel','admin')->name("admin-page")->middleware("can:makeAdminActions");
  Route::delete('admin/delete/{user}','destroy')->middleware("can:deleteuser,user");
  Route::post('admin/block/{user}','block')->middleware('can:block,user');
  Route::post('admin/unblock/{user}', 'unblock')->middleware('can:block,user');
});