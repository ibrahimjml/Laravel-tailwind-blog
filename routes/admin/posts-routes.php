<?php

use App\Http\Controllers\Admin\PostsController;
use Illuminate\Support\Facades\Route;

// posts
Route::controller(PostsController::class)->prefix('posts')->name('posts.')->group(function () {

  Route::group(['permission' => 'post.view'], function (): void {
    Route::get('/', 'posts')->name('page');
    Route::get('/featured', 'featuredPage')->name('featured.page');
  });

    Route::post('/featured', 'createFeature')->name('featured.create');
    Route::put('/{post}/feature', 'toggleFeature')->name('featured.toggle')->middleware('permission:post.feature');
    Route::put('/{post}/status', 'editStatus')->name('status')->middleware('permission:post.update');
  });