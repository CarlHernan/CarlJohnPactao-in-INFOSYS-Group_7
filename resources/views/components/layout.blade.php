<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickEat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-navbar />
    <div class="container mx-auto mt-4">
        {{ $slot }}
    </div>
    <x-footer />
</body>
</html>
