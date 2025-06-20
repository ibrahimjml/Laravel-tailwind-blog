<?php

namespace App\DTOs;

use Illuminate\Http\Request ;

class PostFilterDTO
{
        public function __construct(
        public readonly string $search,
        public readonly string $sort,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'search' => 'required|string|max:255',
        ]);

        return new self(
            search: $validated['search'],
            sort: $request->get('sort', 'latest'),
        );
    }
}
