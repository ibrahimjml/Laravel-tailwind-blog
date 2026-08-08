<?php

namespace App\Services\Sitemap;

use App\Models\Category;
use App\Models\CustomPage;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Response;

class SitemapManager
{
    private static array $keys = ['sitemap', 'pages', 'posts', 'post-hashtags', 'post-categories', 'users'];

    private const ALLOWED_EXTENSIONS = ['xml', 'rss', 'txt'];
    private string $defaultDate = '2028-08-04 00:00';
    public function __construct(private Sitemap $siteMap, private readonly ConfigRepository $config)
    {
    }

    public function init(string $name = 'index'): self
    {
        $this->siteMap->resetItems();
        $this->siteMap->resetSitemaps();
        $this->siteMap->setCache(
            $this->config->get('sitemap.cache.key', 'sitemap.').$name,
            (int) $this->config->get('sitemap.cache.ttl', 3600),
            (bool) $this->config->get('sitemap.cache.enabled', false),
        );

        return $this;
    }

    public function groups(): array
    {
        return array_values(array_diff(static::$keys, ['sitemap']));
    }

    public static function getKeys(): array
    {
        return static::$keys;
    }

    public static function allowedExtensions(): array
    {
        return self::ALLOWED_EXTENSIONS;
    }

    public static function registerKey(string $key): void
    {
        if (! in_array($key, static::$keys, true)) {
            static::$keys[] = $key;
        }
    }

    /**
     * group modules in sitemapindex.
     */
    public function build(string $group): self
    {
        return match ($group) {
            'sitemap' => $this->buildAll(),
            'pages' => $this->buildPages(),
            'posts' => $this->buildPosts(),
            'post-hashtags' => $this->buildHashtags(),
            'post-categories' => $this->buildCategories(),
            'users' => $this->buildUsers(),
            default => $this,
        };
    }

    public function addSitemap(string $loc, ?string $lastModified = null): self
    {
        if (! $this->isCached()) {
            $this->siteMap->addSitemap($loc, $lastModified ?: $this->defaultDate);
        }

        return $this;
    }

    public function add(string $url,
         ?string $date = null,
         ?string $priority = null,
         ?string $changeFrequency = null, 
         array $images = [], 
         ?string $title = null,
         ?string $short_excerpt = null,
         ?string $description = null,
         ?string $author = null): self
    {
        if (! $this->isCached()) {
              $this->siteMap->add(
              $url,
              $date, 
              $priority,
              $changeFrequency,
              $images, 
              $title,
              $short_excerpt,
              $description,
              $author);
        }

        return $this;
    }

    public function isCached(): bool 
    { 
      return $this->siteMap->isCached();
     }

    public function getSiteMap(): Sitemap 
    {
       return $this->siteMap; 
    }

    public function render(string $format = 'xml'): Response 
    { 
      return $this->siteMap->render($format); 
    }

    private function buildAll(): self
    {
        foreach ($this->groups() as $group) {
            $this->build($group);
        }

        return $this;
    }

    private function buildPages(): self
    {
        $this->add(route('home'), null, '0.8', 'daily', [], config('app.name'));
        $this->add(route('blog'), null, '0.8', 'daily', [], 'Blog');

        CustomPage::query()
        ->where('is_active', 1)
        ->orderByDesc('updated_at')
        ->each(function (CustomPage $page): void {
            $this->add(
            route('custom.page', $page),
            $page->updated_at?->toAtomString(),
            '0.8',
            'daily',
            [],
            $page->title);
        });

        return $this;
    }

    private function buildPosts(): self
    {
        Post::query()
        ->with('user:id,name')
        ->published()
        ->orderByDesc('updated_at')
        ->each(function (Post $post): void {
            $images  = [
               'url' => $post->image_url,
               'title' => $post->title
               ];
            $this->add(
               route('single.post', $post),
               $post->updated_at?->toAtomString(),
               '0.9',
               'daily',
                $images,
                $post->title,
                $post->short_excerpt,
                $post->description,
                $post->user?->name
                );
        });

        return $this;
    }
   private function buildUsers():self
   {
      User::query()
      ->activated()
      ->publicProfile()
      ->hasPublishedPosts()
      ->where('is_blocked', false)
      ->orderByDesc('updated_at')
      ->each(function (User $user): void {
          $this->add(
               route('profile.home', $user->username),
               $user->updated_at?->toAtomString(),
              '0.8', 
              'daily',
               [], 
               $user->name, 
               $user->bio
               );
      });
      return $this;
       
   }
    private function buildHashtags(): self
    {
        Hashtag::query()
        ->active()
         ->withWhereHas('posts', function ($query) {
             $query->select('posts.id', 'posts.title','posts.slug', 'posts.image_path')
                   ->latest('posts.created_at');
          })
        ->orderByDesc('updated_at')
        ->each(function (Hashtag $hashtag): void {
             $images = [];
            if ($post = $hashtag->posts->first()) {
                $images = [
                    'url' => $post->image_url,
                    'title' => $post->title,
                ];
            }
            $this->add(
               route('viewhashtag', $hashtag),
               $hashtag->updated_at?->toAtomString(),
               '0.8', 
               'daily',
                $images,
                $hashtag->name
                );
        });

        return $this;
    }

    private function buildCategories(): self
    {
       Category::query()
         ->withWhereHas('posts', function ($query) {
             $query->select('posts.id', 'posts.title','posts.slug', 'posts.image_path')
                   ->latest('posts.created_at');
          })
        ->orderByDesc('updated_at')
        ->each(function (Category $category): void {

            $images = [];

            if ($post = $category->posts->first()) {
                $images = [
                    'url' => $post->image_url,
                    'title' => $post->title,
                ];
            }
            $this->add(
               route('viewcategory', $category),
               $category->updated_at?->toAtomString(),
               '0.8', 
               'daily',
                $images,
                $category->name
                  );
        });

        return $this;
    }
}
