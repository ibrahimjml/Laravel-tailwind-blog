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
        $perpage = $request->get('perpage', 12);
        $page = $request->get('news_page', 1);
        $sourceName = $request->query('source');

        $sources = $repo->getLatestSources();
        $news = $repo->getPaginatedNews($sourceName,$perpage,$page);


        if ($request->ajax() || $request->expectsJson()) {
               $html = view('latest-news.partials.news-ajax', compact('news'))->render();
            return infinite_scroll_response($html,$news);
        }
        
        return view('latest-news.index', compact('sources', 'news', 'sourceName'));
    }

}
