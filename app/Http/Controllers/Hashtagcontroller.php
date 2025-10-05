<?php

namespace App\Http\Controllers;

use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Hashtag;
use App\Repositories\Interfaces\TagInterface;
use Illuminate\View\View;


class Hashtagcontroller extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

    public function viewhashtag(Hashtag $hashtag,TagInterface $repo):View
    {
      if ($hashtag->status !== \App\Enums\TagStatus::ACTIVE) {
          abort(404); 
        }
    $posts = $repo->getPostsByTag($hashtag);

      return view('hashtags.show', [
        'posts' => $posts,
        'currentHashtag' => $hashtag,
      ]);
    }
}
