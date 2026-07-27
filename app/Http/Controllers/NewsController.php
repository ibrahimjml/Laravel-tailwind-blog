<?php

namespace App\Http\Controllers;

use App\Models\Scraping\ScrapedPost;
use App\Repositories\Interfaces\NewsInterface;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, NewsInterface $repo)
    {
        $sourceName = $request->query('source');
        $categoryName = $request->query('category');
        $sources = $repo->getLatestSources();

        $news = ScrapedPost::query()
            ->with('source')
            ->latest()
            ->when($sourceName, function ($query, $sourceName) {
                return $query->whereHas('source', function ($sub) use ($sourceName) {
                    $sub->where('name', $sourceName);
                });
            })
            ->when($categoryName, function ($query, $categoryName) {
                return $query->where('category', $categoryName);
            })
            ->paginate(9)
            ->withQueryString();

      

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('latest-news.partials.news-ajax', compact('news'))->render(),
            ]);
        }
        
        return view('latest-news.index', compact('sources', 'news', 'sourceName'));
    }

}
