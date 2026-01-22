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
    PostsController,
    ProfileReportController,
    RolesController,
    SettingController,
    SlidesController,
    UsersController
};

Route::prefix('admin')
    ->middleware('can:makeAdminActions')
    ->name('admin.')
    ->group(function () {
  
      Route::get('/panel', [AdminController::class,'admin'])->name("panel");
      // posts
      Route::controller(PostsController::class)
             ->prefix('posts')
             ->name('posts.')
             ->group(function () {
      Route::get('/', 'posts')->name('page');
      Route::get('/featured', 'featuredPage')->name('featured.page');
      Route::post('/featured', 'createFeature')->name('featured.create');
      Route::put('/{post}/feature','toggleFeature')->name('featured.toggle');
      Route::put('/{post}/status','editStatus')->name('status');
  });
      // users
      Route::controller(UsersController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
      Route::get('/', 'users')->name('page');
      Route::post('/create','createUser')->name('create');
      Route::put('/{user}/edit','updateUser')->name('update');
      Route::put('/{user}/role', 'role')->name('role');
      Route::put('/{user}/toggle', 'toggle')->name('block');
      Route::delete('/{user}/delete', 'destroy')->name('delete');
      });
      // reports
      Route::prefix('reports')->group(function () {
      Route::controller(PostReportController::class)
             ->prefix('posts')
            ->name('reports.posts.')
            ->group(function(){
        Route::get('/', 'reports')->name('index');
        Route::delete('/{report}/delete', 'delete')->name('delete');
        Route::patch('/{report}/status','status')->name('status');
      });
         Route::controller(ProfileReportController::class)
              ->prefix('profiles')
              ->name('reports.profiles.')
              ->group(function(){
        Route::get('/', 'reports')->name('index');
        Route::delete('/{report}/delete', 'delete')->name('delete');
        Route::patch('/{report}/status','status')->name('status');
      });
         Route::controller(CommentReportController::class)
              ->prefix('comments')
              ->name('reports.comments.')
             ->group(function(){
        Route::get('/', 'reports')->name('index');
        Route::delete('/{report}/delete', 'delete')->name('delete');
        Route::patch('/{report}/status','status')->name('status');
      });
    });
    // manage Tags
    Route::controller(TagsController::class)
          ->prefix('tags')
          ->name('tags.')
          ->group(function(){
    Route::get('/', 'hashtags')->name('index');
    Route::post('/tag', 'create')->name('create');
    Route::put('/edit/{hashtag}', 'edit')->name('update');
    Route::delete('/{hashtag}', 'delete')->name('delete');
    Route::put('/{hashtag}/feature','toggle')->name('feature');
    });
    // Categories 
    Route::controller(CategoriesController::class)
            ->prefix('categories')
            ->name('categories.')
            ->group(function(){
    Route::get('/','categories')->name('index');
    Route::post('/category', 'create')->name('create');
    Route::put('/edit/{category}', 'edit')->name('update');
    Route::delete('/delete/{category}', 'delete')->name('delete');
    Route::put('/{category}/feature','toggle')->name('feature');
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
    //slides
    Route::resource('slides',SlidesController::class)->except(['create','edit']);
  // settings
  Route::controller(SettingController::class)
            ->prefix('settings')
            ->name('settings.')
            ->group(function(){
  Route::get('/', 'settings')->name('index');
  Route::get('/smtpmails','smtp')->name('smtp');
  Route::get('/notification-controls','notification_view')->name('notification.view');
  Route::get('db-backup','backup_view')->name('backup.view');
  Route::get('backup-download/{file}','backup_download')->name('backup.download');
  Route::delete('/backup-delete/{file}','backup_destroy')->name('backup.destroy');
  Route::patch('/notification-controls','toggle_notification')->name('notification.toggle');
  Route::post('/smtpmails','smtp_config')->name('smtp.config');
  Route::post('/testmail','testmail')->name('smtp.test');
  Route::put('/{user}/edit', 'updateSettings')->name('update');
  Route::put('/{user}/password', 'updatePassword')->name('password');
  Route::put('/{user}/aboutme', 'updateAboutme')->name('aboutme');
    });
});
