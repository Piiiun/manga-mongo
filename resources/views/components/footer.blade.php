<footer class="relative mt-20 pb-12 md:pb-0 bg-linear-to-b from-gray-900 to-black">
    {{-- Decorative Top Border --}}
    <div class="h-1 w-full bg-linear-to-r from-amber-500 via-red-500 to-amber-500"></div>
    
    {{-- Main Footer Content --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            
            {{-- Logo & Description --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-linear-to-br from-amber-500 to-red-500 shadow-lg">
                        <img src="{{ asset('manga-mobile.png') }}" alt="Manga" class="h-8 w-auto">
                    </div>
                    <h3 class="text-2xl font-black text-white">Manga-Mongo</h3>
                </div>
                <p class="text-sm leading-relaxed text-gray-400">
                    Platform terbaik untuk membaca manga online gratis dengan update terbaru setiap hari. Nikmati ribuan judul manga favorit Anda!
                </p>
                
                {{-- Social Media --}}
                <div class="flex gap-3">
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:bg-linear-to-br hover:from-amber-500 hover:to-red-500 hover:text-white hover:shadow-lg">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:bg-linear-to-br hover:from-amber-500 hover:to-red-500 hover:text-white hover:shadow-lg">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm3.066 9.645c.01.132.015.265.015.398 0 4.068-3.095 8.757-8.757 8.757A8.712 8.712 0 011 17.335a6.169 6.169 0 004.546-1.272 3.082 3.082 0 01-2.876-2.137 3.087 3.087 0 001.39-.053 3.081 3.081 0 01-2.47-3.019v-.04c.417.232.894.372 1.402.388A3.082 3.082 0 012.042 7.17a8.748 8.748 0 006.347 3.217 3.082 3.082 0 015.248-2.809 6.172 6.172 0 001.956-.748 3.094 3.094 0 01-1.354 1.703 6.155 6.155 0 001.77-.486 6.263 6.263 0 01-1.538 1.598z"/>
                        </svg>
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:bg-linear-to-br hover:from-amber-500 hover:to-red-500 hover:text-white hover:shadow-lg">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:bg-linear-to-br hover:from-amber-500 hover:to-red-500 hover:text-white hover:shadow-lg">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="mb-4 text-lg font-bold text-white">Navigasi</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('home') }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.list') }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Daftar Manga
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Genre
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bookmark.index') }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Bookmark
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Riwayat
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Genres Popular --}}
            <div>
                <h4 class="mb-4 text-lg font-bold text-white">Genre Populer</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('manga.list', ['genre' => 'action']) }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Action
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.list', ['genre' => 'romance']) }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Romance
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.list', ['genre' => 'comedy']) }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Comedy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.list', ['genre' => 'fantasy']) }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Fantasy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.list', ['genre' => 'isekai']) }}" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Isekai
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal & Support --}}
            <div>
                <h4 class="mb-4 text-lg font-bold text-white">Bantuan</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Kontak
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 text-sm text-gray-400 transition-colors hover:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            Terms of Service
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Divider --}}
        <div class="my-8 h-px bg-linear-to-r from-transparent via-gray-700 to-transparent"></div>

        {{-- Newsletter Section --}}
        <div class="mb-8 rounded-2xl bg-linear-to-r from-amber-500/10 to-red-500/10 p-6 ring-1 ring-amber-500/20">
            <div class="flex flex-col items-center gap-4 md:flex-row md:justify-between">
                <div class="text-center md:text-left">
                    <h4 class="mb-1 text-lg font-bold text-white">📬 Dapatkan Update Terbaru</h4>
                    <p class="text-sm text-gray-400">Subscribe untuk mendapatkan notifikasi manga terbaru</p>
                </div>
                <form class="flex flex-col items-center md:flex-row w-full max-w-md gap-2">
                    <input type="email" 
                           placeholder="Masukkan email Anda" 
                           class="flex-1 rounded-lg bg-gray-800 px-4 py-2.5 text-sm text-white placeholder-gray-500 ring-1 ring-gray-700 transition-all focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <button type="submit" 
                            class="rounded-lg bg-linear-to-r from-amber-500 to-red-500 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition-all hover:from-amber-600 hover:to-red-600 hover:shadow-amber-500/50">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
            <p class="text-center text-sm text-gray-400">
                © {{ date('Y') }} <span class="font-semibold text-amber-400">Manga-Mongo</span>. All rights reserved.
            </p>
            
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span>Made with</span>
                <span class="animate-pulse text-red-500">❤️</span>
                <span>for Manga Lovers</span>
            </div>
        </div>
    </div>

    {{-- Scroll to Top Button --}}
    @if(!request()->routeIs('manga.read'))
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="fixed bottom-18 md:bottom-8 right-5 md:right-8 flex h-12 w-12 items-center justify-center rounded-full bg-linear-to-br from-amber-500 to-red-500 text-white shadow-2xl transition-all hover:scale-110 hover:shadow-amber-500/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    @endif
</footer>