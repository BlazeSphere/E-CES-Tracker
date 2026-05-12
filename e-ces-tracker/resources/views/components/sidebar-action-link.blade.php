@props(['icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 text-white hover:text-gray-200 transition-colors py-1']) }}>
    <div class="w-6 h-6 flex items-center justify-center">
        @if($icon == 'settings')
            <img src="https://www.figma.com/api/mcp/asset/690a0a9f-4d9e-45d7-ac6a-e1205763b6c8" alt="">
        @elseif($icon == 'support')
            <img src="https://www.figma.com/api/mcp/asset/e0f01f7a-9154-4817-ad99-099ed8f00013" alt="">
        @elseif($icon == 'logout')
            <img src="https://www.figma.com/api/mcp/asset/7bc1da41-9403-491d-b4ff-cc32baafd35b" alt="">
        @endif
    </div>
    <span class="font-inter text-sm font-semibold">{{ $slot }}</span>
</a>
