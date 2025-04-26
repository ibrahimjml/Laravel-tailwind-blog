<?php 
namespace App\Helpers;

use Illuminate\Support\Str;

class MetaHelpers{

  public static function generateMetaForPosts($post){

    $hashtags = $post->hashtags->pluck('name')->implode(', ');
    $metaKeywords = $hashtags ?? 'blog, post, article';
    
    $description = $post->description ?? 'No description available';
    $cleanDescription = str_replace(["\n", "\r", "\t"], '', $description);
    $metaDescription = Str::limit(strip_tags(trim($cleanDescription)), 150);

    $author = $post->user->username ?? config('app.name', 'Blog-Post');

    return [
      'meta_title' => $post->title . ' | Blog-Post',
      'meta_description' => $metaDescription,
      'meta_keywords' => $metaKeywords,
      'author' => $author,
    ];
  }
  public static function generateDefault($title = 'HOME | Blog-Post', $description = 'Welcome to Blog-Post', $hashtags = [])
  {
      return [
          'meta_title' => $title,
          'meta_description' => $description ?? 'No description available',
          'meta_keywords' => !empty($hashtags) ? implode(', ', $hashtags) : 'blog, post, article',
          'author' => auth()->check() ? auth()->user()->username : config('app.name', 'Blog-Post'),
      ];
  }
}