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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'MangaMongo - Baca Manga Online' }}</title>
</head>
<body class=" bg-linear-to-b from-gray-900 to-black">
    <x-nav-top />
    <x-nav-bottom />
    <main class="pt-17">
        {{ $slot }}
        
    <script src="{{ asset('js/bookmark.js') }}"></script>
    {{-- <script src="{{ asset('js/bookmark-ui.js') }}"></script> --}}
    </main>
    <x-footer />
</body>
</html>