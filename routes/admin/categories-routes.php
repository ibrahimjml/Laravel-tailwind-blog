<?php

use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;

// Categories 
Route::prefix('categories')
  ->controller(CategoriesController::class)
  ->name('categories.')->group(function () {

    Route::get('/', 'categories')->name('index')->middleware('permission:category.view');
    Route::post('/category', 'create')->name('create')->middleware('permission:category.create');
    Route::put('/edit/{category}', 'edit')->name('update')->middleware('permission:category.update');
    Route::delete('/delete/{category}', 'delete')->name('delete')->middleware('permission:category.delete');
    Route::put('/{category}/feature', 'toggle')->name('feature')->middleware('permission:category.feature');
  });