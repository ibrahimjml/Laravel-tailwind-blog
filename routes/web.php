<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    PinController,
    ProfileSettingsController,
  ProfileController,
  QrcodeController,
};
use App\Http\Controllers\{
    CategoryController,
    CommentController,
    Hashtagcontroller,
    HomeController,
    NotificationController,
    PostController,
    ReportPostController,
    PublicController,
    ReportCommentController,
    ReportProfileController,
    TinyMCEController,
};


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
// Blog
Route::get('/blog',[PostController::class,'blogpost'])->name('blog')->middleware('auth');
// Post
Route::get('/post/{post:slug}',[PostController::class,'viewPost'])->name('single.post')->middleware('auth');

//recent posts page by hashtag 
Route::get('/hashtag/{hashtag:name}',[Hashtagcontroller::class,'viewhashtag'])->name('viewhashtag');
//recent posts page by category
Route::get('/category/{category:name}',[CategoryController::class,'viewcategory'])->name('viewcategory');

// Create Post
Route::get('/createpage',[PostController::class,'createpage'])->name('createpage')->middleware('auth');
Route::post('/create',[PostController::class,'create'])->name('create')->middleware('auth');
Route::get('/post/edit/{slug}',[PostController::class,'editpost'])->name('edit.post');
Route::delete('/post/{slug}',[PostController::class,'delete'])->name('delete.post');
Route::put('/post/update/{slug}',[PostController::class,'update'])->name('update.post');

// Add and delete images inside TinyMCE editor
Route::post('/upload-image', [TinyMCEController::class, 'uploadImage'])->name('tinymce.upload');
Route::post('/image-delete', [TinyMCEController::class, 'deleteImage'])->name('tinymce.delete');

// profile
Route::controller(ProfileController::class)
    ->prefix('/@{user:username}')
    ->middleware('can:view,user')
    ->group(function(){

 Route::get('/','Home')->name('profile');
 Route::get('activity','activity')->name('profile.activity');
 Route::get('/about','aboutme')->name('profile.aboutme');
 
});
// settings
Route::prefix('profile')
->controller(ProfileSettingsController::class)
->middleware('password.confirm')
->group(function(){

  Route::get('/settings/info','profile_info')->name('profile.info');
  Route::put('/settings/info','update_info')->name('update.info');
  Route::get('/settings/account','profile_account')->name('profile.account');
  Route::put('/settings/account','update_account')->name('update.account');
  Route::delete('/account-delete','deleteaccount')->name('account.delete');
  Route::delete('/settings/delete/avatar','delete_avatar')->name('avatar.destroy');
  Route::delete('/settings/delete/cover','delete_cover')->name('cover.destroy');
  Route::delete('/delete/custom-link/{id}',  'destroy_link')->name('destroy.customlink');
});
// qrcode generator
Route::get('/qr-code', QrcodeController::class)->name('qr-code.image');
// toggle pin/unpin
Route::post('/toggle/{post}/pin',[PinController::class,'togglePin'])->name('toggle.pin');
// Like
Route::post('/post/{post}/like',[PublicController::class,'like']);
// Follow
Route::post('/user/{user}/togglefollow',[PublicController::class,'toggleFollow'])->name('toggle.follow');
// Search
Route::get('/search',[PostController::class,'search'])->name('blog.search');
// Comments
Route::get('/posts/{post}/comments', [CommentController::class, 'loadMore'])->name('posts.comments.load');
Route::post('/comment/{post}',[CommentController::class,'createComment']);
Route::post('/reply/{comment}',[CommentController::class,'reply'])->name('comment.reply');
Route::put('/comment/edit/{comment}',[CommentController::class,'editComment'])->name('edit.comment');
Route::delete('/comment/{comment}',[CommentController::class,'deleteComment'])->name('delete.comment');
// reports
Route::prefix('/reports')->group(function(){
  Route::post('/post/{post}',[ReportPostController::class,'report_post'])->name('post.report');
  Route::post('/profile/{user:username}',[ReportProfileController::class,'report_profile'])->name('profile.report');
  Route::post('/comment/{comment}',[ReportCommentController::class,'report_comment'])->name('comment.report');
});
// Save Post
Route::post('/saved-post',[PublicController::class,'save']);
// Saved Posts Page
Route::get('/getsavedposts',[PublicController::class,'getsavedposts'])->name('bookmarks');
// notifications
Route::get('/notifications/{id}/read', [NotificationController::class, 'markasread'])->name('notifications.read');
Route::get('/notifications/read/all', [NotificationController::class, 'markallasread'])->name('notifications.readall');
Route::delete('/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
Route::delete('/notifications/deleteAll', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');

