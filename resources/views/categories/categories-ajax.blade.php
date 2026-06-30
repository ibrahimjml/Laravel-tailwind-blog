  @foreach ($posts as $post)
      
  <x-postcard :post="$post"  :currentCategory="$currentCategory"/>
  
  @endforeach
