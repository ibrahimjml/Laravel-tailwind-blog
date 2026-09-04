<?php

namespace App\Http\Controllers\Admin\Scraping;

use App\Enums\ScrapingType;
use App\Http\Controllers\Controller;
use App\Models\Scraping\ScrapedPost;
use App\Models\Scraping\ScrapingLog;
use App\Models\Scraping\ScrapingSource;
use Illuminate\Http\Request;

class ScrapingController extends Controller
{
    public function index()
    {
        $sources = ScrapingSource::query()->withCount('scrapedData as posts_count')
            ->latest()
            ->paginate(7, ['*'], 'source_page');
        $scrapedPosts = ScrapedPost::query()->with('source')
            ->latest()
            ->paginate(20, ['*'], 'scrape_page');
        $logs = ScrapingLog::query()->with('source')
            ->latest()
            ->paginate(20, ['*'], 'logs_page');  
        $sourcePayload = collect($sources->items())->mapWithKeys(function (ScrapingSource $source) {
            return [$source->id => $this->sourcePayload($source)];
        });

         if (request()->ajax()) {

             if (request()->has('scrape_page')) {
                 return view('admin.scraping.partials.scraped-data-list', compact('scrapedPosts'));
             }
             if (request()->has('logs_page')) {
                 return view('admin.scraping.partials.logs-list', compact('logs'));
             }
         }

        return view('admin.scraping.index',
        [
          'sources' => $sources,
          'sourcePayload' => $sourcePayload,
          'scrapedPosts' => $scrapedPosts,
          'logs' => $logs
        ]);
    }

  public function destroyScrapedData(Request $request)
  {
     if($request->wantsJson()){
        ScrapedPost::truncate();
        return response()->json([
          'deleted' => true,
          'message' => 'All Scraped Data Deleted.'
        ], 200);
     }
  }
  public function destroyScrapedLogs(Request $request)
  {
     if($request->wantsJson()){
        ScrapingLog::truncate();
        return response()->json([
          'deleted' => true,
          'message' => 'All Logs Deleted.'
        ], 200);
     }
  }
    private function sourcePayload(ScrapingSource $source): array
  {
    return [
      'id' => $source->id,
      'name' => $source->name,
      'url' => $source->getRawOriginal('url'),
      'type' => $source->getRawOriginal('type'),
      'favicon_url' => $source->favicon_url,
      'max_links' => $source->max_links,
      'max_age' => $source->max_age_hours,
      'skip_no_image' => $source->skip_no_image,
      'skip_no_category' => $source->skip_no_category,
      'is_active' => $source->is_active,
    ];
  }
}
