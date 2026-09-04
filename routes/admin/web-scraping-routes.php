<?php

use App\Http\Controllers\Admin\Scraping\ScrapingController;
use App\Http\Controllers\Admin\Scraping\ScrapingSourceController;
use App\Http\Controllers\Admin\Scraping\ScrapSettingController;
use Illuminate\Support\Facades\Route;

// web scraping
Route::prefix('scraping')->name('scraping.')->group(function () {

  Route::controller(ScrapingController::class)->group(function () {

    Route::get('/', 'index')->name('index')->middleware('permission:scrap.view');
    Route::delete('/delete-scraped', 'destroyScrapedData')->name('delete.data')->middleware('permission:scrap.post.delete');
    Route::delete('/delete-logs', 'destroyScrapedLogs')->name('delete.logs')->middleware('permission:scrap.log.delete');
  });

  Route::controller(ScrapingSourceController::class)->name('sources.')->group(function () {

    Route::post('/create', 'store')->name('store')->middleware('permission:scrap.source.create');
    Route::post('/crawl/{source}', 'run')->name('run')->middleware('permission:scrap.source.crawl');

    Route::group(['permission' => 'scrap.source.update'], function (): void {
      Route::put('/{source}/update', 'update')->name('update');
      Route::patch('/{source}/status', 'toggleStatus')->name('toggle.status');
    });

    Route::delete('/{source}/delete', 'destroy')->name('destroy')->middleware('permission:scrap.source.delete');
  });

  Route::controller(ScrapSettingController::class)->name('setting.')->group(function () {

    Route::get('/setting', 'index')->name('index')->middleware('permission:cron.view');
    Route::put('/Scrap-update', 'scrapUpdate')->name('update')->middleware('permission:cron.update');
    Route::post('/force-run-crawl', 'forceRunAll')->name('force.run')->middleware('permission:cron.crawl.all');
    Route::patch('/regenerate-cron-token', 'regenerateToken')->name('regenerate.token')->middleware('permission:cron.token.update');

  });
});