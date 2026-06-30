<?php

namespace App\Http\Controllers\Admin\Scraping;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\SourceScrapingRequest;
use App\Jobs\ScrapeSourceJob;
use App\Models\Scraping\ScrapingSource;
use Illuminate\Http\Request;

class ScrapingSourceController extends Controller
{
    public function __construct()
    {
      $this->middleware('permission:scrap.source.create')->only('store');
      $this->middleware('permission:scrap.source.update')->only('update');
      $this->middleware('permission:scrap.source.delete')->only('destroy');
      $this->middleware('permission:scrap.source.crawl')->only('run');
    }
    public function store(SourceScrapingRequest $request)
    {
       if($request->expectsJson()){

         $validated = $request->validated();
         ScrapingSource::create($validated);
         return response()->json([
            'message' => 'Source Created Successfuly',
         ],201);
       }

    }
    public function update(SourceScrapingRequest $request, ScrapingSource $source)
    {
       if($request->expectsJson()){
         $validated = $request->validated();
         $source->update($validated);
         return response()->json([
            'message' => 'Source Updated Successfuly',
         ],200);
       }

    }
      public function destroy(Request $request, ScrapingSource $source)
      {
          if ($request->expectsJson()) {
             $source->delete();
             return response()->json([
                'message' => 'Source Deleted Successfully',
             ],200);
          }

      }
      public function run(ScrapingSource $source){
        ScrapeSourceJob::dispatch($source);
         toastr()->info("Crawl for {$source->name} started in background",['timeOut'=>2000]);
         return back();
      }
}
