<?php

use App\Http\Controllers\Admin\PostsController;
use Illuminate\Support\Facades\Route;

// posts
Route::controller(PostsController::class)
  ->prefix('posts')
  ->name('posts.')
  ->group(function () {
    Route::get('/', 'posts')->name('page');
    Route::get('/featured', 'featuredPage')->name('featured.page');
    Route::post('/featured', 'createFeature')->name('featured.create');
    Route::put('/{post}/feature', 'toggleFeature')->name('featured.toggle');
    Route::put('/{post}/status', 'editStatus')->name('status');
  });