<x-layout>
  @if(session()->has('success'))
  <div id="parag" class="fixed  bg-green-500 p-[10px] text-center top-[100px] left-[150px] sm:left-[40%] transform translate-y-[30px] sm:transform sm:translate-y-0 z-20">
  <p  class="text-center font-bold text-2xl text-white">{{session('success')}}</p>
  </div>
  @endif
  
{{-- hero --}}
<div class="relative top-0 hero-bg-image flex flex-col items-center justify-center">
  @if(!auth()->user())
  <h1 class="text-center text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center"> sign in to start posting</h1>
  <a class="bg-gray-100 text-gray-700 py-2 px-5 font-bold uppercase rounded-lg mt-3" href="/login">sign in</a>
  @else
  <h1  class="text-center text-gray-100 text-4xl uppercase font-bold pb-10 sm:text-center">welcome to blog post</h1>
  <a class="bg-gray-100 text-gray-700 py-4 px-5 font-bold uppercase rounded-lg" href="/blog">See Blog</a>
  @endif
</div>

{{-- description --}}
<div class="container sm:grid  grid-cols-2 gap-20 mx-auto py-[30px]">
  <div class="mx-2 md:mx-4 ">
    <img class="rounded-none md:rounded-lg mx-auto sm:ml-10" src="{{url('29-4000x2670.jpg')}}" wid alt="">
  </div>
  <div class="flex flex-col items-left justify-center m-10 sm:m-0">
    <h2 class="font-bold text-gray-700 text-4xl uppercase">The Majestic Beauty of the Rocky Mountains</h2>
    <p class="font-bold text-gray-400 text-xl pt-3">Immerse yourself in the stunning landscapes and natural wonders of the Rocky Mountains. Learn about the best trails, scenic spots, and tips for a memorable adventure.</p>
    <p class="py-4 text-gray-500 text-sm leading-5">The Rocky Mountains, stretching from Canada to New Mexico, are a symbol of natural grandeur. These towering peaks offer breathtaking views, diverse wildlife, and a variety of outdoor activities for adventurers of all levels. Whether you're a seasoned hiker or just looking for a peaceful retreat in nature, the Rockies have something to offer everyone. Let's explore some of the most beautiful spots and hidden gems within this iconic mountain range.</p>
  </div>
</div>
<hr>
{{-- description --}}
<div class="container sm:grid  grid-cols-2 gap-20 mx-auto py-[30px]">
  <div class="flex flex-col items-right justify-center sm:ml-10 sm:m-0">
    <h2 class="font-bold text-gray-700 text-4xl uppercase ml-7">The Healing Power of Nature: How Time Outdoors Benefits Your Health</h2>
    <p class="font-bold text-gray-400 text-xl pt-3 ml-7"> Explore the numerous health benefits of spending time in nature and how it can improve your physical and mental well-being.</p>
    <p class="py-4 text-gray-500 text-sm leading-5 ml-7">Forests are among the most complex and vital ecosystems on our planet. Home to an incredible diversity of plants, animals, and microorganisms, forests play a crucial role in maintaining the balance of our environment. They act as the lungs of the Earth, sequestering carbon dioxide and producing oxygen. In this post, we'll explore the wonders of forest ecosystems, uncovering the intricate relationships that sustain them and highlighting their importance in combating climate change.</p>
    
  </div>
  <div class="mx-2 md:mx-4">
    <img class="rounded-none md:rounded-lg" src="{{url('17-2500x1667.jpg')}}" wid alt="">
  </div>
</div>

</x-layout>
