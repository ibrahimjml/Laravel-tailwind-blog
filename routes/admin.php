<?php

use Illuminate\Support\Facades\Route;
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

Route::prefix('admin')
    ->middleware('can:makeAdminActions')
    ->name('admin.')
    ->group(function () {
  
      Route::get('/panel', [AdminController::class,'admin'])->name("panel");
      // posts
      Route::controller(AdminController::class)
             ->prefix('posts')
             ->name('posts.')
             ->group(function () {
      Route::get('/', 'posts')->name('page');
      Route::get('/featured', 'featuredpage')->name('featured.page');
      Route::post('/featured', 'create_feature')->name('featured.create');
      Route::put('/{post}/feature','toggle_feature')->name('featured.toggle');
      Route::put('/{post}/status','edit_status')->name('status');
  });
      // users
      Route::controller(AdminController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
      Route::get('/', 'users')->name('page');
      Route::post('/create','createuser')->name('create');
      Route::put('/{user}/edit','updateuser')->name('update');
      Route::put('/{user}/role', 'role')->name('role');
      Route::put('/{user}/toggle', 'toggle_block')->name('block');
      Route::delete('/{user}/delete', [AdminController::class, 'destroy'])->name('delete');
      });
      // reports
      Route::prefix('reports')->group(function () {
      Route::controller(PostReportController::class)
             ->prefix('posts')
            ->name('reports.posts.')
            ->group(function(){
        Route::get('/', 'post_reports')->name('index');
        Route::delete('/{report}', 'report_delete')->name('delete');
        Route::patch('/{report}/status','toggle_status')->name('status');
      });
         Route::controller(ProfileReportController::class)
              ->prefix('profiles')
              ->name('reports.profiles.')
              ->group(function(){
        Route::get('/', 'profile_reports')->name('index');
        Route::delete('/{report}', 'profile_report_delete')->name('delete');
        Route::patch('/{report}/status','toggle_status')->name('status');
      });
         Route::controller(CommentReportController::class)
              ->prefix('comments')
              ->name('reports.comments.')
             ->group(function(){
        Route::get('/', 'comment_reports')->name('index');
        Route::delete('/{report}', 'comment_report_delete')->name('delete');
        Route::patch('/{report}/status','toggle_status')->name('status');
      });
    });
    // manage Tags
    Route::controller(TagsController::class)
          ->prefix('tags')
          ->name('tags.')
          ->group(function(){
    Route::get('/', 'hashtagpage')->name('index');
    Route::post('/tag', 'create_tag')->name('create');
    Route::put('/edit/{hashtag}', 'edit_tag')->name('update');
    Route::delete('/{hashtag}', 'delete_tag')->name('delete');
    Route::put('/{hashtag}/feature','toggle_feature_tag')->name('feature');
    });
    // Categories 
    Route::controller(CategoriesController::class)
            ->prefix('categories')
            ->name('categories.')
            ->group(function(){
    Route::get('/','categorypage')->name('index');
    Route::post('/category', 'create_category')->name('create');
    Route::put('/edit/{category}', 'edit_category')->name('update');
    Route::delete('/delete/{category}', 'delete_category')->name('delete');
    Route::put('/{category}/feature','toggle_feature_category')->name('feature');
  });
  // notifications
  Route::controller(NotificationsController::class)
            ->prefix('notifications')
            ->name('notifications.')
            ->group(function(){
    Route::get('/', 'notifications')->name('index');
    Route::get('/notifications/{id}/read',  'markasread')->name('read');
  });
  // roles and permissions
    Route::resource('roles',RolesController::class);
    Route::resource('permissions',PermissionsController::class);
    
  // settings
  Route::controller(SettingController::class)
            ->prefix('settings')
            ->name('settings.')
            ->group(function(){
  Route::get('/', 'settings')->name('index');
  Route::put('/{user}/edit', 'update_settings')->name('update');
  Route::put('/{user}/password', 'update_pass')->name('password');
  Route::put('/{user}/aboutme', 'update_aboutme')->name('aboutme');
    });
});
