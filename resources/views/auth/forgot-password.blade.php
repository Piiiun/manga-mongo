<x-layout title="Lupa Password" title="Login" :noNav="true" :noFooter="true" :noPadding="true">
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h2 class="text-3xl font-bold text-white mb-6 text-center">Lupa Password</h2>
            
            <p class="text-gray-400 mb-6 text-center">
                Masukkan email Anda dan kami akan mengirimkan link reset password.
            </p>

            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-4">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-gray-300 mb-2 font-semibold">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50">
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-bold py-3 px-4 rounded-lg transition-colors">
                    Kirim Link Reset
                </button>
                
                <p class="text-gray-400 text-center mt-6">
                    <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300">
                        Kembali ke Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-layout>