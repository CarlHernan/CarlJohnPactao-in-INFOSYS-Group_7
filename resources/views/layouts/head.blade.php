<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', config('app.name', 'Laravel'))</title>

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">

<!-- Nice Admin CSS -->
@if(request()->routeIs('dashboard'))
<link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/jvectormap/jquery-jvectormap.css') }}" rel="stylesheet">
@endif
<link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Tailwind / Breeze -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
