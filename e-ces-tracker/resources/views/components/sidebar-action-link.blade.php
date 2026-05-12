@props(['icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 text-white hover:text-white/80 transition-colors py-2 px-6 rounded-full hover:bg-white/10']) }}>
    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
        @if($icon == 'settings')
            <img src="https://www.figma.com/api/mcp/asset/690a0a9f-4d9e-45d7-ac6a-e1205763b6c8" class="w-full h-full object-contain invert brightness-0" alt="">
        @elseif($icon == 'support')
            <img src="https://www.figma.com/api/mcp/asset/e0f01f7a-9154-4817-ad99-099ed8f00013" class="w-full h-full object-contain invert brightness-0" alt="">
        @elseif($icon == 'logout')
            <img src="https://www.figma.com/api/mcp/asset/7bc1da41-9403-491d-b4ff-cc32baafd35b" class="w-full h-full object-contain invert brightness-0" alt="">
        @endif
    </div>
    <span class="font-inter text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300 origin-left"
          :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 invisible'">
        {{ $slot }}
    </span>
</a>
