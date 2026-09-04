<?php

use App\Http\Controllers\Admin\TagsController;
use Illuminate\Support\Facades\Route;

// manage Tags
Route::controller(TagsController::class)->prefix('tags')->name('tags.')->group(function () {

  Route::get('/', 'hashtags')->name('index')->middleware('permission:tag.view');
  Route::post('/tag', 'create')->name('create')->middleware('permission:tag.create');
  Route::put('/edit/{hashtag}', 'edit')->name('update')->middleware('permission:tag.update');
  Route::delete('/{hashtag}', 'delete')->name('delete')->middleware('permission:tag.delete');
  Route::put('/{hashtag}/feature', 'toggle')->name('feature')->middleware('permission:tag.feature');
});