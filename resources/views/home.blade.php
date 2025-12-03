<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home Page</title>
</head>
<body class=" bg-bgbody">
    <nav class=" bg-manga px-6 py-3 top-0 z-50 font-manga fixed w-full">
        <div class=" flex items-center md:justify-between max-w-7xl mx-auto justify-center">
            <div>
                <a href="">
                    <img src="manga.png" alt="Manga" class=" h-10 w-auto hidden md:block">
                    <img src="manga-mobile.png" alt="Manga" class=" h-10 w-auto md:hidden mr-4">
                </a>
            </div>
            <div class="relative">
                <form action="">
                    <input type="text" placeholder="Search" class=" min-w-0 flex-auto rounded-md bg-white/5 px-3.5 py-1 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-second sm:text-sm/6">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-second">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="gap-5 justify-end text-white mr-4 hidden md:flex">
                <a href="" class="hover:text-second">Home</a>
                <a href="" class="hover:text-second">Populer</a>
                <a href="" class="hover:text-second">List Manga</a>
                <a href="" class="hover:text-second">Akun</a>
            </div>
        </div>
    </nav>

    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-[#1A1A1A] text-white border-t border-white/10 md:hidden">
    <div class="grid grid-cols-4 text-center py-2">

        <a href="#" class="flex flex-col items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 11.5L12 3l9 8.5M5 10v10a1 1 0 001 1h4V14h4v7h4a1 1 0 001-1V10" />
            </svg>
            <span class="text-xs">Beranda</span>
        </a>

        <a href="#" class="flex flex-col items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v12m6-6H6" />
            </svg>
            <span class="text-xs">New Updates</span>
        </a>

        <a href="#" class="flex flex-col items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <span class="text-xs">Daftar Isi</span>
        </a>

        <a href="#" class="flex flex-col items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 19.5a7.5 7.5 0 0115 0" />
            </svg>
            <span class="text-xs">Akun</span>
        </a>

    </div>
    </nav>
</body>
</html>