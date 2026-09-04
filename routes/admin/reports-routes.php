<?php

use App\Http\Controllers\Admin\CommentReportController;
use App\Http\Controllers\Admin\PostReportController;
use App\Http\Controllers\Admin\ProfileReportController;
use Illuminate\Support\Facades\Route;

// reports
Route::prefix('reports')->name('reports.')->group(function () {
  Route::controller(PostReportController::class)
    ->prefix('posts')
    ->name('posts.')
    ->group(function () {
      Route::get('/', 'reports')->name('index')->middleware('permission:postreport.view');
      Route::delete('/{report}/delete', 'delete')->name('delete')->middleware('permission:postreport.delete');
      Route::patch('/{report}/status', 'status')->name('status')->middleware('permission:postreport.status');
    });
  Route::controller(ProfileReportController::class)
    ->prefix('profiles')
    ->name('profiles.')
    ->group(function () {
      Route::get('/', 'reports')->name('index')->middleware('permission:profilereport.view');
      Route::delete('/{report}/delete', 'delete')->name('delete')->middleware('permission:profilereport.delete');
      Route::patch('/{report}/status', 'status')->name('status')->middleware('permission:profilereport.status');
    });
  Route::controller(CommentReportController::class)
    ->prefix('comments')
    ->name('comments.')
    ->group(function () {
      Route::get('/', 'reports')->name('index')->middleware('permission:commentreport.view');
      Route::delete('/{report}/delete', 'delete')->name('delete')->middleware('permission:commentreport.delete');
      Route::patch('/{report}/status', 'status')->name('status')->middleware('permission:commentreport.update');
    });
});