<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
  ProfileSettingsController,
  ProfileController,
  QrcodeController,
};
use App\Http\Controllers\Admin\{
    AdminController,
    CategoriesController,
    NotificationsController,
    TagsController,
    PermissionsController,
    PostReportController,
    RolesController,
    SettingController
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

// auth routes
require __DIR__."/auth.php";

// Blog Page
Route::get('/blog',[PostController::class,'blogpost'])->name('blog')->middleware('auth');

// Post Page
Route::get('/post/{post:slug}',[PublicController::class,'viewpost'])->name('single.post')->middleware('auth');

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
->middleware('can:view,user')
->group(function(){
// User Profile 
 Route::get('/@{user:username}','Home')->name('profile');
 Route::get('/@{user:username}/activity','activity')->name('profile.activity');
 Route::get('/@{user:username}/about','aboutme')->name('profile.aboutme');

});
// profile settings
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

Route::get('/qr-code', QrcodeController::class)->name('qr-code.image');
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
Route::post('/report-post/{post}',[ReportPostController::class,'report_post'])->name('post.report');
// Save Post
Route::post('/saved-post',[PostController::class,'save']);
// Saved Posts Page
Route::get('/getsavedposts',[PostController::class,'getsavedposts'])->name('bookmarks');
// notifications
Route::get('/notifications/{id}/read', [NotificationController::class, 'markasread'])->name('notifications.read');
Route::get('/notifications/read/all', [NotificationController::class, 'markasreadall'])->name('notifications.readall');
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

      Route::controller(PostReportController::class)->group(function(){
        Route::get('/post-reports', 'post_reports')->name('admin.postreports');
        Route::delete('/report/delete/{report}', 'report_delete')->name('delete.report');
        Route::patch('/reports/{report}/status','toggle_status')->name('toggle.status');
      });

      // create user
      Route::post('/create/user','createuser')->name('create.user');
      Route::put('/edit/{user}','updateuser')->name('update.user');
      // create feature post
      Route::get('/featured', 'featuredpage')->name('featuredpage');
      Route::post('/featured', 'create_feature')->name('admin.featured');
      //toggle featured posts
      Route::put('/toggle/feature/{post}','toggle_feature')->name('toggle.feature');
      // update user role
      Route::put('/role-update/{user}', 'role')->name('role.update');
      //toggle blocked user status
      Route::put('/toggle/block/{user}', 'toggle_block')->name('toggle.block');
    });
    // manage Tags
    Route::controller(TagsController::class)->group(function(){
    Route::get('/hashtags', 'hashtagpage')->name('hashtagpage');
    Route::post('/create/tag', 'create_tag')->name('create.hashtag');
    Route::put('/edit/tag/{hashtag}', 'edit_tag')->name('edit.hashtag');
    Route::delete('/delete/{hashtag}', 'delete_tag')->name('delete.hashtag');
    // toggle feature tag
    Route::put('feature/tag/{hashtag}','toggle_feature_tag')->name('feature.tag');
    });
    // manage Categories 
    Route::controller(CategoriesController::class)->group(function(){
    Route::get('Categories','categorypage')->name('categorypage');
    Route::post('/create/category', 'create_category')->name('create.category');
    Route::put('/edit/category/{category}', 'edit_category')->name('edit.category');
    Route::delete('/delete/category/{category}', 'delete_category')->name('delete.category');
    // toggle feature category
    Route::put('feature/category/{category}','toggle_feature_category')->name('feature.category');
  });
    Route::resource('roles',RolesController::class);
    Route::resource('permissions',PermissionsController::class);
    Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])->name('delete.user');
    Route::get('/notifications', [NotificationsController::class,'notifications'])->name('admin.notify');
  
  Route::controller(SettingController::class)->group(function(){
  Route::get('/settings', 'settings')->name('admin.settings');
  Route::put('/settings/{user}', 'update_settings')->name('admin.update');
  Route::put('/settings-pass/{user}', 'update_pass')->name('admin.pass');
  Route::put('/settings-aboutme/{user}', 'update_aboutme')->name('admin.aboutme');
  });
});
