@props([
    'title' => 'MangaMongo - Baca Manga Online',
    'description' => null,
    'bodyClass' => '',
    'noFooter' => false,
    'noNav' => false,
    'noPadding' => false,
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description ?? 'Baca manga dan komik favoritmu secara online di MangaMongo.' }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#020617">

    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description ?? 'Baca manga dan komik favoritmu secara online di MangaMongo.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="MangaMongo">

    <script>
        window.authUser = @json(Auth::user());
    </script>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="bg-[#0B1020] text-white {{ $bodyClass }}">
    @unless($noNav)
    <x-nav-top />
    <x-nav-bottom />
    @endunless

    <main class="{{ $noPadding ? '' : 'pt-17' }} min-h-screen">
        {{ $slot }}
    </main>

    @unless($noFooter)
        <x-footer />
    @endunless

    @stack('scripts')
</body>
</html>
