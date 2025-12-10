<x-layout title="Register" title="Login" :noNav="true" :noFooter="true" :noPadding="true">
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4 py-12">
        <div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h2 class="text-3xl font-bold text-white mb-6 text-center">Daftar</h2>
            
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2 font-semibold">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <input type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            placeholder="Nama"
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">               
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2 font-semibold">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <input type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="Contoh@gmail.com"
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2 font-semibold">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <input type="password" 
                            name="password" 
                            required
                            placeholder="••••••••"
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-300 mb-2 font-semibold">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <input type="password" 
                            name="password_confirmation" 
                            required
                            placeholder="••••••••"
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-bold py-3 px-4 rounded-lg transition-colors">
                    Daftar
                </button>
                
                <p class="text-gray-400 text-center mt-6">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-semibold">
                        Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-layout>