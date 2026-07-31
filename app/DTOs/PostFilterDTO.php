<?php

namespace App\DTOs;

use App\Enums\SearchType;
use Illuminate\Http\Request;

class PostFilterDTO
{
        public function __construct(
        public readonly string $search,
        public readonly SearchType $type,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'search' => 'required|string|max:255',
        ]);

        return new self(
            search: $validated['search'],
            type: SearchType::tryFrom($request->input('type', 'all')) ?? SearchType::ALL
        );
    }
}
