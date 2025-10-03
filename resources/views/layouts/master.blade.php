<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        @hasSection('hide_sidebar')
            {{-- Sidebar hidden on this page --}}
        @else
            @include('layouts.sidebar')
        @endif

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('layouts.scripts')
</body>
</html>
