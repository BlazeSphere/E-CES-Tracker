@props(['active' => false, 'icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 px-6 py-3 rounded-full transition-all duration-300 ' . ($active ? 'bg-[#d9f99d] text-[#15803d] font-bold shadow-sm' : 'text-[#44341d] hover:bg-gray-50 font-semibold')]) }}>
    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
        @if($icon == 'dashboard')
            <img src="https://www.figma.com/api/mcp/asset/45d7fa6a-7826-4e3f-9580-6e3be09889e8" class="w-full h-full object-contain {{ $active ? '' : 'grayscale opacity-70' }}" alt="">
        @elseif($icon == 'users')
            <img src="https://www.figma.com/api/mcp/asset/3c1a277c-6e52-4f12-aa2e-cee8f5b8e8f3" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @elseif($icon == 'audit')
            <img src="https://www.figma.com/api/mcp/asset/545aa4a0-5504-4a95-8835-c625e6cfb11a" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @elseif($icon == 'reports')
            <img src="https://www.figma.com/api/mcp/asset/012cbfe7-6a22-48ad-80c1-5193761dd7e8" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @endif
    </div>
    <span class="font-inter text-[16px] whitespace-nowrap overflow-hidden transition-all duration-300 origin-left" 
          :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 invisible'">
        {{ $slot }}
    </span>
</a>
