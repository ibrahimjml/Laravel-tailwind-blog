{{-- toastr jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{asset('js/hiddenul.js')}}" defer></script>
<script src="{{asset('js/unsaveposts.js')}}" defer></script>
<script src="{{asset('js/fetchfollow.js')}}" defer></script>

@if(Route::is('single.post'))
<script src="{{asset('js/fetchlike.js')}}" defer></script>
<script src="{{asset('js/randomhearts.js')}}" defer></script>
<script src="{{asset('js/comments.js')}}" defer></script>
<script src="{{asset('js/fetchsavedpost.js')}}" defer></script>
@endif

@if(Route::is('admin-page','featuredpage','admin.posts','admin.users','hashtagpage'))
<script src="{{asset('js/sidebar.js')}}" defer></script>
@if(Route::is('hashtagpage'))
<script src="{{asset('js/fetchhashtags.js')}}" defer></script>
@endif
@endif
@if(Route::is(['edit.post','createpage','featuredpage']))
<script src="{{asset('js/hashtagsUI.js')}}" defer></script>
@endif

@stack('scripts')