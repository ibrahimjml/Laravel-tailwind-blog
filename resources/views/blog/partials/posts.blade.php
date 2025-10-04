@foreach ($posts as $post)    
<x-postcard :post="$post" :authFollowings="$authFollowings"/>
@endforeach
