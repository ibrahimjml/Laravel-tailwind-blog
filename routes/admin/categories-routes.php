<?php 

use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route; 

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