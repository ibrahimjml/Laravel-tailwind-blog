@extends('admin.partials.layout')
@section('title', 'Settings | Dashboard')
@section('content')
  <!-- Header -->
@include('admin.partials.header', ['linktext' => 'Admin Settings', 'route' => 'admin.settings.index', 'value' => request('search')])

  <div class=" px-4 md:px-10 mx-auto lg:w-[80%] lg:ml-64 -m-24">
    <div class="flex flex-wrap">
    <div class="w-full lg:w-8/12 px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
      <div class="rounded-t bg-white mb-0 px-6 py-6">
        <div class="text-center flex justify-between">
        <h6 class="text-blueGray-700 text-xl font-bold">
          My account
        </h6>

        </div>
      </div>
      <div class="flex-auto px-4 lg:px-10 py-10 pt-0 ">

        <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
        User Information
        </h6>
        <form id="phone-form" action="{{route('admin.settings.update', $user->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex flex-wrap">
          <div class="w-full lg:w-6/12 px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="username">
            Username
            </label>
            <input type="text" name="username"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
            value="{{$user->username}}" />
            @error('username')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <div class="w-full lg:w-6/12 px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="email">
            Email address
            </label>
            <input type="email" name="email"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
            value="{{$user->email}}" />
            @error('email')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <div class="w-full lg:w-6/12 px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="name">
            Name
            </label>
            <input type="text" name="name"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
            value="{{$user->name}}" />
            @error('name')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <div class="w-full lg:w-6/12 px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="phone">
            Phone
            </label>
            <input id="phone" type="tel" name="phone"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 {{ $errors->has('phone') ? 'border-red-500' : '' }}"
            name="phone" value="{{$user->phone}}" required autocomplete="tel">
            @error('phone')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
        </div>
        <button
          class="bg-gray-500 ml-5 text-white active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
          type="submit">
          Update
        </button>
        </form>
        <hr class="mt-6 border-b-1 border-blueGray-300" />

        <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
        Change Password
        </h6>
        <form action="{{route('admin.settings.password', $user->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex flex-wrap">
          <div class="w-full  px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
            Current password
            </label>
            <input type="password" name="current_password"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 @error('current_password') border-red-500 @enderror" />
            @error('current_password')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <div class="w-full  px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
            New password
            </label>
            <input type="password" name="password"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 @error('password') border-red-500 @enderror" />
            @error('password')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <div class="w-full  px-4">
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
            Repeat Password
            </label>
            <input type="password" name="password_confirmation"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 @error('password_confirmation') border-red-500 @enderror" />
            @error('password_confirmation')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
          </div>
          </div>
          <button
          class="bg-gray-500 ml-5 text-white active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
          type="submit">
          Update
          </button>
        </div>
        </form>
        <hr class="mt-6 border-b-1 border-blueGray-300" />

        <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
        About Me
        </h6>
        <div class="flex flex-wrap">
        <div class="w-full lg:w-12/12 px-4">
          <form action="{{route('admin.settings.aboutme', $user->id)}}" method="post">
          @csrf
          @method('PUT')
          <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
            About me
            </label>
            <textarea type="text" name="about"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
            rows="4">
    {{ old('about', $user->aboutme) }}
      </textarea>
            @error('about')
        <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
        </p>
        @enderror
            <button
            class="bg-gray-500 mt-2 text-white active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
            type="submit">
            Update
            </button>
          </div>
          </form>
        </div>
        </div>

      </div>
      </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg mt-16">
      <div class="px-6">
        <div class="flex flex-wrap justify-center">
        <div class="w-full px-4 flex justify-center">
          <div class="relative">
          <img alt="..." src="{{auth()->user()->avatar_url}}"
            class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px" />
          </div>
        </div>
        <div class="w-full px-4 text-center mt-20">
          <div class="flex justify-center py-4 lg:pt-4 pt-8">
        {{-- posts-likes-follows-count --}}
            @include('profile.partials.posts-likes-follows-count',['postcount'=>$postcount,'likescount'=>$likescount,'user'=>$user])
          </div>
        </div>
        </div>
        <div class="text-center ">
        <h3 class="text-xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
          {{$user->name}}
        </h3>
        
    @isset($user->bio)
      <i class="fas fa-info mr-2 text-lg text-blueGray-400"></i>{{$user->bio}}
    @endisset
  
        </div>
        <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
        <div class="flex flex-wrap justify-center">
          <div class="w-full lg:w-9/12 px-4">
          <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
            {{$user->aboutme}}
          </p>
          
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>

  </div>

  </div>
@endsection
@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const phoneInputField = document.querySelector("#phone");

    // Initialize intl-tel-input
    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });


    fetch('https://get.geojs.io/v1/ip/geo.json')
      .then(response => response.json())
      .then(data => {
      const country = data.country_code;  // Country code like "US", "IN", etc.
      phoneInput.setCountry(country);  // Set the country
      })
      .catch(error => console.error('Error fetching location:', error));
    const form = document.querySelector('#phone-form');
    form.addEventListener('submit', function (eo) {
      eo.preventDefault();


      const countryCode = phoneInput.getSelectedCountryData().dialCode;
      const phoneNumber = phoneInput.getNumber();


      const countryCodeInput = document.createElement('input');
      countryCodeInput.type = 'hidden';
      countryCodeInput.name = 'country_code';
      countryCodeInput.value = countryCode;
      form.appendChild(countryCodeInput);

      phoneInputField.value = phoneNumber;

      form.submit();
    });
    });   
  </script>
@endpush