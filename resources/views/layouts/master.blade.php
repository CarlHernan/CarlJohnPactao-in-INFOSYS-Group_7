<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head') {{-- move meta/css links here --}}
</head>
<body>
    <div id="main-wrapper">
        @include('layouts.header')
        
        <div id="page-wrapper flex-1 flex flex-col">
          @include('layouts.sidebar')
          <div>
          @yield('content')
          </div>
        </div>

        @include('layouts.footer')
    </div>

    @include('layouts.scripts')
</body>
</html>
