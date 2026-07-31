<?php

namespace App\Services;

use App\DTOs\PostFilterDTO;
use App\Enums\SearchType;
use App\Http\Responses\SearchResponse;
use App\Repositories\Eloquent\{CategoryRepository, NewsRepository, PostRepository, TagRepository, UserRepository};
use Illuminate\Http\Request;

class SearchService
{
   public function __construct(
        protected PostRepository $postRepo,
        protected UserRepository $userRepo,
        protected TagRepository $hashtagRepo,
        protected CategoryRepository $categoryRepo,
        protected NewsRepository $newsRepo,
    ) {}
  public function getSearch(Request $request)
  {
    $dto = PostFilterDTO::fromRequest($request);
    $dto = $this->normalizeSearch($dto);

    $limit = $dto->type === SearchType::ALL ? 5 : 10;
    $results = $this->handleSearch($dto, $limit);

    if (request()->ajax()) {
      $html = view('partials.search-result-ajax', [
        'results' => $results,
        'searchquery' => $dto->search,
        'type' => $dto->type,
      ])->render();

      return SearchResponse::make($results, $html, $dto->type);
    }

    abort(404);
  }

  public function handleSearch($dto, int $limit)
  {
     return match($dto->type){
       SearchType::POSTS => $this->postRepo->getBySearch($dto, $limit),
       SearchType::TAGS => $this->hashtagRepo->getBySearch($dto, $limit),
       SearchType::CATEGORIES => $this->categoryRepo->getBySearch($dto, $limit),
       SearchType::USERS => $this->userRepo->getBySearch($dto, $limit),
       SearchType::NEWS => $this->newsRepo->getBySearch($dto, $limit),
       SearchType::ALL => [
          'posts' => $this->postRepo->getBySearch($dto, $limit),
          'users' => $this->userRepo->getBySearch($dto, $limit),
          'tags' => $this->hashtagRepo->getBySearch($dto, $limit),
          'categories' => $this->categoryRepo->getBySearch($dto, $limit),
          'news' => $this->newsRepo->getBySearch($dto, $limit),
        ],
     };

  }
  protected function normalizeSearch(PostFilterDTO $dto): PostFilterDTO
{
     $search = trim($dto->search ?? '');
    $type = $dto->type;

    if (str_starts_with($search, '#')) {
        $type = SearchType::TAGS;
        $search = ltrim($search, '#');
    }

    if (str_starts_with($search, '@')) {
        $type = SearchType::USERS;
        $search = ltrim($search, '@');
    }

    return new PostFilterDTO(
        search: $search,
        type: $type,
    );
}
}
