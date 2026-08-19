<?php

use App\Http\Controllers\Admin\SlidesController;
use Illuminate\Support\Facades\Route;

//slides
Route::resource('slides', SlidesController::class)->except(['create', 'edit']);