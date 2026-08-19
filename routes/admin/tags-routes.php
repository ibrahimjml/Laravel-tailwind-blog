<?php 

use App\Http\Controllers\Admin\TagsController;
use Illuminate\Support\Facades\Route;

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