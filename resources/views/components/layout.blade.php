<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PingganPH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}"/>
</head>
<body>
<x-navbar/>
<div>
    {{ $slot }}
</div>
</body>
</html>
