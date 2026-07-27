<div class="grid lg:grid-cols-2 grid-cols-1 gap-3">
    @forelse ($scrapedPosts as $post)
        <div class="border p-4 rounded-xl bg-card shadow-sm flex gap-4 hover:shadow-md transition-shadow">
            <img
                class="w-24 h-24 object-cover rounded-md border shrink-0"
                src="{{ $post->image_url }}"
                alt="Preview">

            <div class="flex-1 min-w-0 flex flex-col">
                <h4 class="font-bold text-sm truncate">
                    {{ $post->title }}
                </h4>

                <p class="text-xs mt-1 line-clamp-2">
                    {{ $post->description }}
                </p>

                <div class="flex justify-between mt-auto pt-3 border-t">
                    <a href="{{ $post->link }}"
                        target="_blank"
                        class="text-xs text-blue-500 hover:underline">
                        {{ $post->source->name }}
                    </a>

                    <span class="text-[10px] bg-primary/10 text-primary px-2 py-1 rounded-full">
                        {{ $post->category }}
                    </span>
                </div>
            </div>
        </div>
    @empty
        <p>No Scraped Posts Yet.</p>
    @endforelse
</div>

<hr class="m-4">

<div id="scraped-pagination" class="flex justify-center p-3">
    {!! $scrapedPosts->links() !!}
</div>