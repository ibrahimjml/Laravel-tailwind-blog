<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    NotificationsController,
    TagsController,
    PermissionsController,
    RolesController,
    SettingController
};
use App\Http\Controllers\{
    CommentController,
    EditProfileController,
    Hashtagcontroller,
    HomeController,
    NotificationController,
    PostController,
    PostReportController,
    ProfileController,
    PublicController,
    TinyMCEController,
    UserSettingController
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

// auth routes
require __DIR__."/auth.php";

// Blog Page
Route::get('/blog',[PostController::class,'blogpost'])->name('blog')->middleware('auth');

// Post Page
Route::get('/post/{slug}',[PublicController::class,'viewpost'])->name('single.post')->middleware('auth');

//hashtag page
Route::get('/hashtag/{hashtag:name}',[Hashtagcontroller::class,'viewhashtag'])->name('viewhashtag');

// Create Post
Route::get('/createpage',[PostController::class,'createpage'])->name('createpage')->middleware('auth');
Route::post('/create',[PostController::class,'create'])->name('create')->middleware('auth');
Route::get('/post/edit/{slug}',[PostController::class,'editpost'])->name('edit.post');
Route::delete('/post/{slug}',[PostController::class,'delete'])->name('delete.post');
Route::put('/post/update/{slug}',[PostController::class,'update'])->name('update.post');

// Add and delete images inside TinyMCE editor
Route::post('/upload-image', [TinyMCEController::class, 'uploadImage'])->name('tinymce.upload');
Route::post('/image-delete', [TinyMCEController::class, 'deleteImage'])->name('tinymce.delete');

// Edit user settings
Route::controller(ProfileController::class)
->middleware('can:view,user')
->group(function(){
// User Profile 
 Route::get('/@{user:username}','Home')->name('profile');
 Route::get('/@{user:username}/activity','activity')->name('profile.activity');
 Route::get('/@{user:username}/about','aboutme')->name('profile.aboutme');

});
Route::controller(UserSettingController::class)->group(function(){
// Edit Profile Page
Route::get('/edit-profile/{user:username}','editprofilepage')
->middleware('password.confirm')
->name('editprofile');
// Add bio 
Route::put('/addbio/{user}','useraddbio')->name('add.bio');
// Add aboutme 
Route::put('/addaboutme/{user}','useraboutme')->name('add.about');
// Add socail links
Route::put('/add/socail-links/{user}','social_links')->name('add.sociallinks');
// custom social links
Route::put('/add/custom-links/{user}','custom_links')->name('add.customlinks');
Route::delete('/delete/custom-link/{link}',  'destroy_link')->name('destroy.customlink');

// Edit user settings
Route::put('/edit-email/{user}','editemail')->name('edit.email');
Route::put('/change-name/{user}','editname')->name('edit.name');
Route::put('/change-phone/{user}','editphone')->name('edit.phone');;
Route::put('/change-pass/{user}','editpassword')->name('edit.pass');;
Route::delete('/account-delete/{user}','deleteaccount')->name('account.delete');
});

Route::controller(EditProfileController::class)->group(function(){
   // Edit Profile Image
Route::get('/edit-avatar/{user}','editavatarpage')->name('edit.avatarpage');
Route::put('/edit-avatar/{user}/edit','editavatar')->name('edit.avatar');
Route::delete('/delete-avatar/{user}','destroyavatar')->name('delete.avatar');
// Edit cover photo 
Route::get('/edit-cover/{user}','editcoverpage')->name('edit.coverpage');
Route::put('/edit-cover/{user}/edit','editcover')->name('edit.cover');
Route::delete('/delete-cover/{user}','destroycover')->name('delete.cover');
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
// post report
Route::post('/report-post/{post}',[PostReportController::class,'report_post'])->name('post.report');
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
    ->middleware('can:makeAdminActions')
    ->group(function () {
    Route::controller(AdminController::class)->group(function(){
      Route::get('/panel', 'admin')->name("admin-page");
      Route::get('/users', 'users')->name('admin.users');
      Route::get('/posts', 'posts')->name('admin.posts');
      Route::get('/post-reports', 'post_reports')->name('admin.postreports');
      Route::delete('/report/delete/{report}', 'report_delete')->name('delete.report');

      // create user
      Route::post('/create/user','createuser')->name('create.user');
      Route::put('/edit/{user}','updateuser')->name('update.user');
      // create feature post
      Route::get('/featured', 'featuredpage')->name('featuredpage');
      Route::post('/featured', 'features')->name('admin.featured');
      //toggle featured posts
      Route::put('/toggle/feature/{post}','toggle_feature')->name('toggle.feature');
      // update user role
      Route::put('/role-update/{user}', 'role')->name('role.update');
      //toggle blocked user status
      Route::put('/toggle/block/{user}', 'toggle_block')->name('toggle.block');
    });
    Route::controller(TagsController::class)->group(function(){
    Route::get('/hashtags', 'hashtagpage')->name('hashtagpage');
    Route::post('/create/tag', 'create_tag')->name('create.hashtag');
    Route::put('/edit/{hashtag}', 'edit_tag')->name('edit.hashtag');
    Route::delete('/delete/{hashtag}', 'delete_tag')->name('delete.hashtag');
    });
    Route::resource('roles',RolesController::class);
    Route::resource('permissions',PermissionsController::class);
  Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])->name('delete.user');
  Route::get('/notifications', [NotificationsController::class,'notifications'])->name('admin.notify');
  
  Route::controller(SettingController::class)->group(function(){
  Route::get('/settings', 'settings')->name('admin.settings');
  Route::post('/settings/{user}', 'update_settings')->name('admin.update');
  Route::post('/settings-pass/{user}', 'update_pass')->name('admin.pass');
  Route::put('/settings-aboutme/{user}', 'update_aboutme')->name('admin.aboutme');
  });
});
