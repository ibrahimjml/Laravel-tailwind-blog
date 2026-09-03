<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function (): void {
  Route::get('/panel', [
    'as' => 'panel',
    'uses' => 'AdminController@admin',
    'permission' => 'Access'
  ]);
});