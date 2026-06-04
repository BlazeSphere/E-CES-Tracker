@props(['icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 text-white hover:text-white/80 transition-colors py-2 px-6 rounded-full hover:bg-white/10']) }}>
    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
        @if($icon == 'settings')
            <img src="{{ asset('images/icons/settings.png') }}" class="w-full h-full object-contain invert brightness-0" alt="">
        @elseif($icon == 'support')
            <img src="{{ asset('images/icons/support.png') }}" class="w-full h-full object-contain invert brightness-0" alt="">
        @elseif($icon == 'logout')
            <img src="{{ asset('images/icons/logout.png') }}" class="w-full h-full object-contain invert brightness-0" alt="">
        @endif
    </div>
    <span class="font-inter text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300 origin-left"
          :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 invisible'">
        {{ $slot }}
    </span>
</a>
