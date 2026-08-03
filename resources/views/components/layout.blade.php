<!DOCTYPE html>
<html lang="en">

<head>
  <x-head />
</head>

<body @auth data-user-id="{{ auth()->id() }}" @endauth class="min-h-screen m-0 ">
  <x-header-blog /> <!-- navbar --> 

  <main @class([
    'pt-20 lg:pt-28' => Route::is(['blog', 'news', 'viewhashtag', 'viewcategory']),
  ])>
    {{$slot}}
  </main>

  <x-search-list /> <!-- search-list -->

  <x-footer />
  {!! $footer_scripts ?? '' !!}  <!-- custom admin footer scripts -->
  <x-scripts />
</body>
</html>