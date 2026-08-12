<!DOCTYPE html>
<html>

<head>
  <x-head />
</head>

<body class="min-h-screen bg-slate-50">
  <div class="flex min-h-screen flex-col">
    <div class="flex-1 flex items-center justify-center px-4">

      @yield('content')
    </div>

    <footer class="py-6 text-center text-xs text-slate-500">
      © {{ date('Y') }} MyBlog4U
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('scripts')
</body>

</html>