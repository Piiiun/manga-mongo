<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home Page</title>
</head>
<body class=" bg-[#001f24]">
    <x-nav-top />
    <x-nav-bottom />
    <main class="pt-17">
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>