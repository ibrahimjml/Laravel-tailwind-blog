@foreach ($posts as $post)
    
<x-postcard :post="$post" :currentHashtag="$currentHashtag"/>

@endforeach