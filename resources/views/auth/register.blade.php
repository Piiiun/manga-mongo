<x-layout title="Register" title="Login" :noFooter="true" :noPadding="true">
    <div class="min-h-screen flex items-center justify-center bg-slate-200 dark:bg-gray-900 px-0 md:px-4 md:py-12 py-2">
        <div class="bg-slate-100 dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md mt-8 scale-80 md:scale-100">
            <h2 class="text-3xl font-bold text-black dark:text-white mb-6 text-center">Daftar</h2>
            
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
                    <label class="block text-gray-600 dark:text-gray-300 mb-2 font-semibold">Username</label>
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
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-slate-200 dark:bg-gray-700 text-black dark:text-white shadow-lg border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">               
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-600 dark:text-gray-300 mb-2 font-semibold">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <input type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="Contoh@gmail.com"
                            class="pl-10 w-full px-4 py-3 rounded-lg bg-slate-200 dark:bg-gray-700 text-black dark:text-white shadow-lg border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-600 dark:text-gray-300 mb-2 font-semibold">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <input type="password" 
                            id="cpassword"
                            name="password" 
                            required
                            placeholder="••••••••"
                            class="pl-10 pr-12 w-full px-4 py-3 rounded-lg bg-slate-200 dark:bg-gray-700 text-black dark:text-white shadow-lg border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">

                            <button type="button" 
                            onclick="togglePassword('cpassword', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-500 transition-colors">
                            <!-- Eye Icon (show) -->
                            <svg class="eye-open" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <!-- Eye Off Icon (hide) -->
                            <svg class="eye-closed hidden" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                        
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-600 dark:text-gray-300 mb-2 font-semibold">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <input type="password" 
                            id="password"
                            name="password_confirmation" 
                            required
                            placeholder="••••••••"
                            class="pl-10 pr-12 w-full px-4 py-3 rounded-lg bg-slate-200 dark:bg-gray-700 text-black dark:text-white shadow-lg border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                            
                            <button type="button" 
                            onclick="togglePassword('password', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-500 transition-colors">
                            <!-- Eye Icon (show) -->
                            <svg class="eye-open" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <!-- Eye Off Icon (hide) -->
                            <svg class="eye-closed hidden" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                        
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-black shadow shadow-amber-300 font-bold py-3 px-4 rounded-lg transition-colors">
                    Daftar
                </button>
                
                <p class="text-gray-600 dark:text-gray-400 text-center mt-6">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-amber-500 dark:text-amber-400 hover:text-amber-400 hover:dark:text-amber-300 font-semibold">
                        Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-layout>