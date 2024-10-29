<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\View\View;


class Hashtagcontroller extends Controller
{
    public function viewhashtag($name):View
    {
      $hashtag = Hashtag::where('name', $name)->firstOrFail();

    $posts = $hashtag->posts()->orderBy('created_at','desc')->simplepaginate(5);
      return view('hashtags.show', [
          'posts' => $posts,
          'hashtag' => $hashtag,
          
      ]);
    }
}
