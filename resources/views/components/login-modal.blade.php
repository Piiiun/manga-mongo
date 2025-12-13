@props([
    'id' => 'login-modal',
    'title' => 'Login untuk Memakai Fitur Ini',
    'description' => 'Login untuk mengakses fitur ini.',
    'icon' => null,
    'loginRoute' => 'login',
    'closeFunction' => null
])

{{-- Login Required Modal --}}
<div id="{{ $id }}"
    onclick="{{ $closeFunction ? $closeFunction . '()' : 'window.closeLoginModal(\'' . $id . '\')' }}"
    class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 max-w-md w-full">
            <div class="text-center">
                {{-- Icon --}}
                <div class="mx-auto w-16 h-16 bg-amber-500/20 rounded-full flex items-center justify-center mb-4">
                    @if($icon)
                        {!! $icon !!}
                    @else
                        {{-- Default Icon: Lock/Login --}}
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    @endif
                </div>
                
                {{-- Title --}}
                <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                
                {{-- Description --}}
                <p class="text-gray-400 text-sm mb-6">
                    {{ $description }}
                </p>
                
                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route($loginRoute) }}" 
                       class="flex-1 bg-amber-500 hover:bg-amber-600 text-black font-bold px-6 py-3 rounded-lg transition-colors text-center">
                        Login Sekarang
                    </a>
                    <button onclick="{{ $closeFunction ? $closeFunction . '()' : 'window.closeLoginModal(\'' . $id . '\')' }}" 
                            class="flex-1 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

