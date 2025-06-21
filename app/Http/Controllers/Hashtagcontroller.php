<?php

namespace App\Http\Controllers;

use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Hashtag;
use Illuminate\View\View;


class Hashtagcontroller extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

    public function viewhashtag(Hashtag $hashtag):View
    {

    $posts = $hashtag->posts()
             ->with(['user:id,username,avatar','hashtags:id,name'])
             ->withCount(['comments','likes'])
             ->orderBy('created_at','desc')
             ->simplepaginate(5);

      return view('hashtags.show', [
        'posts' => $posts,
        'hashtag' => $hashtag,
      ]);
    }
}
