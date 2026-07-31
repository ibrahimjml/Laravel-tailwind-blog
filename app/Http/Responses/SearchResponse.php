<?php

namespace App\Http\Responses;

use App\Enums\SearchType;
use App\Http\Resources\SearchCategoryResource;
use App\Http\Resources\SearchNewsResource;
use App\Http\Resources\SearchPostResource;
use App\Http\Resources\SearchTagResource;
use App\Http\Resources\SearchUserResource;
use Illuminate\Http\JsonResponse;

class SearchResponse
{
    public static function make(mixed $results, string $html, SearchType $type): JsonResponse {
        if ($type === SearchType::ALL) {
            return response()->json([
                'html' => $html,
                'results' => [
                      'posts' => SearchPostResource::collection($results['posts']),
                      'users' => SearchUserResource::collection($results['users']),
                      'tags' => SearchTagResource::collection($results['tags']),
                      'categories' => SearchCategoryResource::collection($results['categories']),
                      'news' => SearchNewsResource::collection($results['news'])
                ],
            ]);
        }

        return response()->json([
            'html' => $html,
        ]);
    }
}