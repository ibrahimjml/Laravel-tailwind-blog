<div class="md:w-[67%] w-full md:mx-auto mx-3  border-2 border-gray-300 rounded-lg p-4 my-4">
  <p class="text-xl font-bold my-3 border-b-2 border-b-black w-fit">Recent Activities</p>
  @if($activities->isEmpty())
  <p class="text-gray-500 text-center py-10 font-bold">No recent activity to show.</p>
@else
  @foreach ($activities as $date => $entries)
    <div class="mb-8">
      {{-- Date --}}
      <div class="flex gap-2 items-center mb-2">
        <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
        <h3 class="text-gray-600 font-semibold">{{ $date }}</h3>
      </div>

      @foreach ($entries as $entry)
        <div class="flex gap-4 relative">
          {{-- Dotted line and dot --}}
          <div class="flex flex-col items-center">
            <div class="w-2 h-2 bg-black rounded-full z-10"></div>
            {{--  show line --}}
            <div class="h-16 border-l-2 border-dotted border-black"></div>
          </div>

          {{-- content --}}
          <div class="pb-4 border-b-2 w-full space-y-1 mt-1 flex flex-col items-start">
          <div class="flex items-center gap-2">
              <span class="mr-1 ">
                @if($entry['type'] == 'Commented')
                <i class="far fa-comment-dots"></i>
                @elseif($entry['type'] == 'Replied')
                <i class="fas fa-reply"></i>
                @elseif($entry['type'] == 'Posted')
                <i class="fas fa-edit"></i>
                @endif
              </span>
             <span class="text-sm text-gray-500">
               {{ $entry['type'] }}
              </span>
            </div>
            <!-- /post/example#comment-717 put anchor  -->
              @php
               $anchor = '';
               if(in_array($entry['type'], ['Commented', 'Replied']) && isset($entry['comment_id'])) {
                 $anchor = '#comment-' . $entry['comment_id'];
               }
             @endphp
             <!-- redirect to exact comment    -->
            <a href="{{ url('/post/' . $entry['slug'] . $anchor) }}"
            @if(in_array($entry['type'], ['Commented', 'Replied']))
            onclick="event.preventDefault();
                     sessionStorage.setItem('showCommentModal', 'true');
                     window.location.href = this.href;"
            @endif
            class="text-left w-full"
             >
            <div class="text-gray-800 ">
              @if(in_array($entry['type'], ['Commented', 'Replied']))
              <b>{{ $entry['post_title']}}</b>
              @else
              <b>{{$entry['title']}}</b>
              @endif
            </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
  @endif
</div>
