<?php

use App\Http\Controllers\Admin\Scraping\ScrapingController;
use App\Http\Controllers\Admin\Scraping\ScrapingSourceController;
use App\Http\Controllers\Admin\Scraping\ScrapSettingController;
use Illuminate\Support\Facades\Route;

// web scraping
Route::prefix('scraping')->name('scraping.')->group(function () {
  Route::controller(ScrapingController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::delete('/delete-scraped', 'destroyScrapedData')->name('delete.data');
    Route::delete('/delete-logs', 'destroyScrapedLogs')->name('delete.logs');
  });
  Route::controller(ScrapingSourceController::class)->name('sources.')->group(function () {
    Route::post('/create', 'store')->name('store');
    Route::post('/crawl/{source}', 'run')->name('run');
    Route::put('/{source}/update', 'update')->name('update');
    Route::patch('/{source}/status', 'toggleStatus')->name('toggle.status');
    Route::delete('/{source}/delete', 'destroy')->name('destroy');
  });
  Route::controller(ScrapSettingController::class)->name('setting.')->group(function () {
    Route::get('/setting', 'index')->name('index');
    Route::put('/Scrap-update', 'scrapUpdate')->name('update');
    Route::post('/force-run-crawl', 'forceRunAll')->name('force.run');
    Route::patch('/regenerate-cron-token', 'regenerateToken')->name('regenerate.token');

  });
});