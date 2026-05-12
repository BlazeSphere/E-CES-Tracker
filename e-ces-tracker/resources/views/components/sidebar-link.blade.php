@props(['active' => false, 'icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 px-4 py-3 rounded-lg transition-colors ' . ($active ? 'bg-[#d4e690] text-[#1b8c00] font-semibold' : 'text-[#44341d] hover:bg-gray-100')]) }}>
    <div class="w-6 h-6 flex items-center justify-center">
        @if($icon == 'dashboard')
            <img src="https://www.figma.com/api/mcp/asset/45d7fa6a-7826-4e3f-9580-6e3be09889e8" alt="">
        @elseif($icon == 'users')
            <img src="https://www.figma.com/api/mcp/asset/3c1a277c-6e52-4f12-aa2e-cee8f5b8e8f3" alt="">
        @elseif($icon == 'audit')
            <img src="https://www.figma.com/api/mcp/asset/545aa4a0-5504-4a95-8835-c625e6cfb11a" alt="">
        @elseif($icon == 'reports')
            <img src="https://www.figma.com/api/mcp/asset/012cbfe7-6a22-48ad-80c1-5193761dd7e8" alt="">
        @endif
    </div>
    <span class="font-inter text-sm">{{ $slot }}</span>
</a>
