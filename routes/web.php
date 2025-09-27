<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    PinController,
    ProfileSettingsController,
  ProfileController,
  QrcodeController,
};
use App\Http\Controllers\Admin\{
    AdminController,
    CategoriesController,
    CommentReportController,
    NotificationsController,
    TagsController,
    PermissionsController,
    PostReportController,
    ProfileReportController,
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
->prefix('/@{user:username}')
->middleware('can:view,user')
->group(function(){
// User Profile 
 Route::get('/','Home')->name('profile');
 Route::get('activity','activity')->name('profile.activity');
 Route::get('/about','aboutme')->name('profile.aboutme');
 
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
// qrcode generator
Route::get('/qr-code', QrcodeController::class)->name('qr-code.image');
// toggle pin/unpin
Route::post('/toggle/{post}/pin',[PinController::class,'togglePin'])->name('toggle.pin');
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
// reports
Route::prefix('/reports')->group(function(){
  Route::post('/post/{post}',[ReportPostController::class,'report_post'])->name('post.report');
  Route::post('/profile/{user:username}',[ReportProfileController::class,'report_profile'])->name('profile.report');
  Route::post('/comment/{comment}',[ReportCommentController::class,'report_comment'])->name('comment.report');
});
// Save Post
Route::post('/saved-post',[PostController::class,'save']);
// Saved Posts Page
Route::get('/getsavedposts',[PostController::class,'getsavedposts'])->name('bookmarks');
// notifications
Route::get('/notifications/{id}/read', [NotificationController::class, 'markasread'])->name('notifications.read');
Route::get('/notifications/read/all', [NotificationController::class, 'markallasread'])->name('notifications.readall');
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
      // create feature post
      Route::get('/featured', 'featuredpage')->name('featuredpage');
      Route::post('/featured', 'create_feature')->name('admin.featured');
      //toggle featured posts
      Route::put('/toggle/feature/{post}','toggle_feature')->name('toggle.feature');
      // edit status post
      Route::put('/edit/post/{post}','edit_status')->name('edit.status');
      // create user
      Route::post('/create/user','createuser')->name('create.user');
      Route::put('/edit/{user}','updateuser')->name('update.user');
      // update user role
      Route::put('/role-update/{user}', 'role')->name('role.update');
      //toggle blocked user status
      Route::put('/toggle/block/{user}', 'toggle_block')->name('toggle.block');
    });
      // post reports
      Route::controller(PostReportController::class)
            ->prefix('postreports')->group(function(){
        Route::get('/', 'post_reports')->name('admin.postreports');
        Route::delete('/delete/{report}', 'report_delete')->name('delete.report');
        Route::patch('/toggle/{report}/status','toggle_status')->name('toggle.status');
      });
      // profile reports
         Route::controller(ProfileReportController::class)
              ->prefix('profilereports')->group(function(){
        Route::get('/', 'profile_reports')->name('admin.profilereports');
        Route::delete('/delete/{report}', 'profile_report_delete')->name('delete.profile.report');
        Route::patch('/toggle/{report}/status','toggle_status')->name('toggle.profile.status');
      });
      // comment reports
         Route::controller(CommentReportController::class)
             ->prefix('commentreports')->group(function(){
        Route::get('/', 'comment_reports')->name('admin.commentreports');
        Route::delete('/delete/{report}', 'comment_report_delete')->name('delete.comment.report');
        Route::patch('/toggle/{report}/status','toggle_status')->name('toggle.comment.status');
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
  Route::controller(NotificationsController::class)->group(function(){
    Route::get('/notifications', 'notifications')->name('admin.notify');
    Route::get('/notifications/{id}/read',  'markasread')->name('admin.notifications.read');
  });
    Route::resource('roles',RolesController::class);
    Route::resource('permissions',PermissionsController::class);
    Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])->name('delete.user');
  
  Route::controller(SettingController::class)->group(function(){
  Route::get('/settings', 'settings')->name('admin.settings');
  Route::put('/settings/{user}', 'update_settings')->name('admin.update');
  Route::put('/settings-pass/{user}', 'update_pass')->name('admin.pass');
  Route::put('/settings-aboutme/{user}', 'update_aboutme')->name('admin.aboutme');
    });
});
