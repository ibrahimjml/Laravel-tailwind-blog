<?php

use App\Http\Controllers\Admin\PostModeration\PostModerationController;

// post moderation
Route::controller(PostModerationController::class)
  ->prefix('post-moderation')
  ->name('posts.moderation.')
  ->group(function () {
    Route::get('/', 'moderationPage')->name('index');
    Route::put('/update-rules', 'updateRules')->name('update.rules');
  });