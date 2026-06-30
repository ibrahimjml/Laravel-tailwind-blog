@props([
    'buttonId',
    'container',
    'route',
    'pageName',
    'currentPage',
    'hasMore',
    'buttonText' => 'Load More',
])

@if($hasMore)
    <div id="{{ $buttonId }}-container" class="text-center my-4">
        <button
            id="{{ $buttonId }}"
            data-next-page="{{ $currentPage + 1 }}"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
            {{ $buttonText }}
        </button>
    </div>
@endif

<div id="{{ $buttonId }}-spinner" class="hidden text-center mt-4">
    <div class="inline-flex items-center">
        <i class="fas fa-spinner fa-spin text-blue-500 mr-2"></i>
        <span>Loading...</span>
    </div>
</div>

<p id="reach-end" class="hidden container w-fit mx-auto">
    You've reached the end! 👋
</p>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const button = document.getElementById(@js($buttonId));
    if (!button) return;

    const container = document.getElementById(@js($container));
    const wrapper = document.getElementById(@js($buttonId . '-container'));
    const spinner = document.getElementById(@js($buttonId . '-spinner'));
    const reachEnd = document.getElementById('reach-end');
    const route = @js($route);
    const pageName = @js($pageName);

    button.addEventListener('click', async () => {

        spinner.classList.remove('hidden');
        wrapper.classList.add('hidden');

        try {

            const params = new URLSearchParams(window.location.search);
            params.set(pageName, button.dataset.nextPage);

            const response = await fetch(`${route}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            container.insertAdjacentHTML('beforeend', data.html);

            if (data.hasMore) {
                button.dataset.nextPage = data.nextPage;
                wrapper.classList.remove('hidden');
                reachEnd.classList.add('hidden');
            } else {
                wrapper.classList.add('hidden');
                reachEnd.classList.remove('hidden');
            }

        } catch (error) {
            console.error(error);
            wrapper.classList.remove('hidden');
        } finally {
            spinner.classList.add('hidden');
        }

    });

});
</script>
@endpush