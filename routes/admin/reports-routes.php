<?php

use App\Http\Controllers\Admin\CommentReportController;
use App\Http\Controllers\Admin\PostReportController;
use App\Http\Controllers\Admin\ProfileReportController;
use Illuminate\Support\Facades\Route;

// reports
Route::prefix('reports')->group(function () {
  Route::controller(PostReportController::class)
    ->prefix('posts')
    ->name('reports.posts.')
    ->group(function () {
      Route::get('/', 'reports')->name('index');
      Route::delete('/{report}/delete', 'delete')->name('delete');
      Route::patch('/{report}/status', 'status')->name('status');
    });
  Route::controller(ProfileReportController::class)
    ->prefix('profiles')
    ->name('reports.profiles.')
    ->group(function () {
      Route::get('/', 'reports')->name('index');
      Route::delete('/{report}/delete', 'delete')->name('delete');
      Route::patch('/{report}/status', 'status')->name('status');
    });
  Route::controller(CommentReportController::class)
    ->prefix('comments')
    ->name('reports.comments.')
    ->group(function () {
      Route::get('/', 'reports')->name('index');
      Route::delete('/{report}/delete', 'delete')->name('delete');
      Route::patch('/{report}/status', 'status')->name('status');
    });
});