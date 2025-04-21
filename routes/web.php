<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Hashtagcontroller;
use App\Http\Controllers\HomeController;
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
Route::get('/',HomeController::class);

// auth routes
require __DIR__."/auth.php";

// Blog Page
Route::get('/blog',[PostController::class,'blog'])->name('blog')->middleware('auth');

// Post Page
Route::get('/post/{slug}',[PublicController::class,'viewpost'])->name('single.post')->middleware('auth');

//hashtag page
Route::get('/hashtag/{hashtag:name}',[Hashtagcontroller::class,'viewhashtag'])->name('viewhashtag');

// Create Post
Route::get('/create',[PostController::class,'createpage'])->name('create')->middleware('auth');
Route::post('/create',[PostController::class,'create'])->name('create')->middleware('auth');

// Add images inside TinyMCE editor
Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('tinymce.upload');

// User Profile
Route::get('/@{user:username}',[PublicController::class,'viewprofile'])->name('profile');

// Edit Profile Image
Route::get('/edit-avatar/{user}',[PublicController::class,'editpage']);
Route::put('/edit-avatar/{user}/edit',[PublicController::class,'edit']);
Route::delete('/delete-avatar/{user}',[PublicController::class,'destroyavatar'])->name('delete.avatar');

// Edit Profile Page
Route::get('/edit-profile/{user:username}',[PublicController::class,'editprofilepage'])
->middleware('password.confirm')
->name('editprofile');
// Add bio 
Route::put('/addbio/{user}',[PublicController::class,'useraddbio']);

// Edit User email,name,phone,pass
Route::put('/edit-email/{user}',[PublicController::class,'editemail']);
Route::put('/change-name/{user}',[PublicController::class,'editname']);
Route::put('/change-phone/{user}',[PublicController::class,'editphone']);
Route::put('/change-pass/{user}',[PublicController::class,'editpassword']);
//user account delete
Route::delete('/account-delete/{user}',[PublicController::class,'deleteaccount'])->name('account.delete');
// Delete Post
Route::delete('/post/{slug}',[PostController::class,'delete'])->name('delete.post');

// Edit Post
Route::get('/post/edit/{slug}',[PostController::class,'editpost'])->name('edit.post');
Route::put('/post/update/{slug}',[PostController::class,'update'])->name('update.post');

// Like
Route::post('/post/{post}/like',[PostController::class,'like']);

// Search
Route::get('/search',[PublicController::class,'search'])->name('blog.search');

// Comments
Route::post('/comment/{post}',[CommentController::class,'comment']);
Route::post('/reply/{comment}',[CommentController::class,'reply']);
Route::put('/comment/edit/{comment}',[CommentController::class,'editcomment'])->name('edit.comment');
Route::delete('/comment/{comment}',[CommentController::class,'deletecomment'])->name('delete.comment');

// Save Post
Route::post('/saved-post',[PostController::class,'save']);

// Saved Posts Page
Route::get('/getsavedposts',[PostController::class,'getsavedposts']);

// admin panel
Route::controller(AdminController::class)
->middleware('can:makeAdminActions,user')
->group(function(){

  Route::get('/admin-panel','admin')->name("admin-page");
  Route::get('admin/users','users')->name('admin.users');
  Route::get('admin/posts','posts')->name('admin.posts');
  Route::get('admin/featured','featuredpage')->name('featuredpage');
  Route::post('admin/featured','features')->name('admin.featured');
  Route::put('admin/role-update/{user}','role')->name('role.update');
  Route::delete('admin/delete/{user}','destroy')->name('delete.user');
  Route::post('admin/block/{user}','block')->name('block.user');
  Route::post('admin/unblock/{user}', 'unblock')->name('unblock.user');
});