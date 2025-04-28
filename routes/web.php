<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Hashtagcontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
Route::get('/',HomeController::class)->name('home');

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

// Edit user settings
Route::controller(ProfileController::class)->group(function(){
  // User Profile
Route::get('/@{user:username}','viewprofile')->name('profile');

// Edit Profile Image
Route::get('/edit-avatar/{user}','editpage');
Route::put('/edit-avatar/{user}/edit','edit');
Route::delete('/delete-avatar/{user}','destroyavatar')->name('delete.avatar');

// Edit Profile Page
Route::get('/edit-profile/{user:username}','editprofilepage')
->middleware('password.confirm')
->name('editprofile');
// Add bio 
Route::put('/addbio/{user}','useraddbio');
  // Edit user settings
  Route::put('/edit-email/{user}','editemail');
  Route::put('/change-name/{user}','editname');
  Route::put('/change-phone/{user}','editphone');
  Route::put('/change-pass/{user}','editpassword');
  Route::delete('/account-delete/{user}','deleteaccount')->name('account.delete');
  Route::delete('/post/{slug}','delete')->name('delete.post');
  Route::get('/post/edit/{slug}','editpost')->name('edit.post');
  Route::put('/post/update/{slug}','update')->name('update.post');
  

});

// Like
Route::post('/post/{post}/like',[PostController::class,'like']);

// Follow
Route::post('/user/{user}/togglefollow',[PublicController::class,'togglefollow'])->name('toggle.follow');

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
Route::get('/getsavedposts',[PostController::class,'getsavedposts'])->name('bookmarks');

// notifications
Route::get('/notifications/{id}/read', [NotificationController::class, 'markasread'])->name('notifications.read');
Route::delete('/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
Route::delete('/notifications/deleteAll', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');


// admin panel
Route::prefix('admin')
    ->controller(AdminController::class)
    ->middleware('can:makeAdminActions,user')
    ->group(function () {

    Route::get('/panel', 'admin')->name("admin-page");
    Route::get('/users', 'users')->name('admin.users');
    Route::get('/posts', 'posts')->name('admin.posts');

    Route::get('/hashtags', 'hashtagpage')->name('hashtagpage');
    Route::post('/create/tag', 'create_tag')->name('create.hashtag');
    Route::put('/edit/{hashtag}', 'edit_tag')->name('edit.hashtag');
    Route::delete('/delete/{hashtag}', 'delete_tag')->name('delete.hashtag');

    Route::get('/featured', 'featuredpage')->name('featuredpage');
    Route::post('/featured', 'features')->name('admin.featured');

    Route::put('/role-update/{user}', 'role')->name('role.update');
    Route::delete('/delete/{user}', 'destroy')->name('delete.user');

    Route::post('/block/{user}', 'block')->name('block.user');
    Route::post('/unblock/{user}', 'unblock')->name('unblock.user');
});
