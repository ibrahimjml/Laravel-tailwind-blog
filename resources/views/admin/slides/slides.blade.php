@extends('admin.partials.layout')
@section('title','Slides Page | Dashboard')
@section('content')

<div class="md:ml-64 ">
@include('admin.partials.header', [
      'linktext'      => 'Slides Page',
      'route'        => 'admin.slides.index', 
      'value'         => request('search'),
      'searchColor'     => 'bg-blueGray-200',
      'borderColor'     => 'border-blueGray-200',
      'backgroundColor' => 'bg-gray-400'
   ])

<div class="flex justify-end transform -translate-y-40">
  @can('slide.create')
  <button id="openSlideModel" class="text-center ml-0 mr-2 sm:ml-auto w-36 bg-gray-600 text-white py-2 px-5 rounded-lg font-bold capitalize mb-6">
    create slide
  </button>
  @endcan
</div>

<div class="bg-white shadow rounded-xl overflow-hidden w-7xl mx-4 transform -translate-y-40">
    <x-tables.table id="tableslides" :headers="['#','Image','Title','Description','Link','Status','Published By','Published At','Disabled By','Disabled At','Actions']" title="Slides Table">
       @forelse($slides as $slide)
         <tr>
          <td class="p-2">{{ ($slides->currentPage() - 1) * $slides->perPage() + $loop->iteration }}</td>
          
          <!-- Image Column -->
          <td class="p-2">
            <img class="object-cover w-16 h-16 rounded" 
                 src="{{$slide->image}}" 
                 alt="{{$slide->title}}">
          </td>
          
          <!-- Title Column -->
          <td class="p-2 max-w-[200px]">
            <span class="font-semibold text-gray-800">{{ $slide->title ?? 'No Title' }}</span>
          </td>
          
          <!-- Description Column -->
          <td class="p-2 max-w-[300px]">
            <span class="text-sm text-gray-600">{{ Str::limit($slide->description, 50) ?? 'No Description' }}</span>
          </td>
          
          <!-- Link Column -->
          <td class="p-2">
            @if($slide->link)
              <a href="{{ $slide->link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm truncate block max-w-[150px]">
                {{ Str::limit($slide->link, 30) }}
              </a>
            @else
              <span class="text-gray-400 text-sm">No Link</span>
            @endif
          </td>
          
          <!-- Status Column -->
          <td class="p-2">
            <i @class([
            "fas fa-circle  mr-2 text-xs",
            'text-green-400' => $slide->status === \App\Enums\SlidesStatus::PUBLISHED,
            'text-red-600' => $slide->status === \App\Enums\SlidesStatus::DISABLED,
          ])></i> {{$slide->status->value}}
          </td>
          
          <!-- Published By Column -->
          <td class="p-2">
            <span class="text-sm text-gray-700">{{ $slide->publishedBy->name ?? '--' }}</span>
          </td>
          
          <!-- Published At Column -->
          <td class="p-2">
            <span class="text-sm text-gray-600">
              {{ $slide->published_at ? $slide->published_at->format('M j, y H: i') : '--' }}
            </span>
          </td>

          <!-- Disabled By Column -->
          <td class="p-2">
            <span class="text-sm text-gray-700">{{ $slide->disabledBy->name ?? '--' }}</span>
          </td>

          <!-- Disabled At Column -->
          <td class="p-2">
            <span class="text-sm text-gray-600">
              {{ $slide->disabled_at ? $slide->disabled_at->format('M j, y H :i') : '--' }}
            </span>
          </td>
          
          <!-- Actions Column -->
          <td class="text-white p-2">
            <div class="flex gap-2 justify-start">
              @can('slide.delete')
              <form class="slidedelete" action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="text-red-500 rounded-lg p-2 cursor-pointer hover:text-red-300" 
                        onclick="return confirm('Are you sure you want to delete this slide?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
                @can('slide.update')
              <button 
                  class="slideEdit text-gray-500 rounded-lg p-2 cursor-pointer hover:text-gray-300"
                  data-slide="{{ json_encode([
                           'id' => $slide->id,
                           'image' => $slide->image,
                           'title' => $slide->title,
                           'description' => $slide->description,
                           'link' => $slide->link,
                           'status' => $slide->status,
                       ]) }}">
                  <i class="fas fa-edit"></i>
                </button>
            @endcan
              </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="p-4 text-center">
            <h4 class="text-center font-bold text-gray-500">Sorry, no slides yet</h4>
          </td>
        </tr>
       @endforelse
       <div class="relative md:ml-64">
         {!! $slides->links() !!}
       </div>
    </x-tables.table>
</div>
</div>
<!-- Create/Edit models -->
@include('admin.slides.partials.create-slide')
@include('admin.slides.partials.edit-slide')

@endsection
@push('scripts')
<script>
      const showmenu = document.getElementById('openSlideModel');
      const closemenu = document.getElementById('closeModel');
      const menu = document.getElementById("Model");

  if (showmenu && closemenu && menu) {
    showmenu.addEventListener('click', () => {
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
      }
    });

    closemenu.addEventListener('click', () => {
      if (menu.classList.contains('fixed')) {
        menu.classList.add('hidden');
      }
    });
  }
  
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.slideEdit');
    const route = "{{ route('admin.slides.update', ':id') }}";
    const editModal = document.getElementById('editModel');
    const closeEditBtn = document.getElementById('closeEditModel');
    const editForm = document.getElementById('editslide');

    if (!editForm) return;

    const title = editForm.querySelector('[name="title"]');
    const description = editForm.querySelector('[name="description"]');
    const link = editForm.querySelector('[name="link"]');
    const status = editForm.querySelector('[name="status"]');
    const fileInput = editForm.querySelector('[name="image"]');

    // Open modal
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // showing spinner
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            const slide = JSON.parse(button.dataset.slide);
            editForm.action = route.replace(':id', slide.id);


            title.value = slide.title ?? '';
            description.value = slide.description ?? '';
            link.value = slide.link ?? '';
            status.value = slide.status ?? '';

            showCurrentImageInfo(slide.image);
    
            editModal.classList.remove('hidden');

            // removing spinner
             setTimeout(() => {
            button.innerHTML = '<i class="fas fa-edit"></i>';
            button.disabled = false;
         }, 300)
      });
    });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();

        let formData = new FormData(editForm);
        formData.append('_method', 'PUT');

        fetch(editForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.updated) {
                toastr.success(data.message);
                editModal.classList.add('hidden');
                location.reload();
            } else {
                if (data.errors) {
                    Object.values(data.errors).forEach(errArr => {
                        errArr.forEach(err => toastr.error(err));
                    });
                }
            }
        })
        .catch(() => toastr.error('Something is wrong  error'));
    });

    closeEditBtn.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });

    function showCurrentImageInfo(imagePath) {
        const existing = editForm.querySelector('.current-image-info');
        if (existing) existing.remove();

        if (imagePath) {
            const div = document.createElement('div');
            div.className = 'current-image-info mt-2 p-2 bg-gray-600 rounded';
            div.innerHTML = `
                <p class="text-white text-sm mb-1">Current image:</p>
                <div class="flex items-center gap-2">
                    <img src="${imagePath}" class="w-16 h-16 object-cover rounded">
                    <span class="text-white text-xs">${imagePath}</span>
                </div>
            `;
            fileInput.parentNode.insertBefore(div, fileInput.nextSibling);
        }
    }
});
</script>

@endpush