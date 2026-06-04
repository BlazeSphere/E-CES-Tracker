@props(['active' => false, 'icon' => ''])

<a {{ $attributes->merge(['class' => 'flex items-center gap-4 px-6 py-3 rounded-full transition-all duration-300 ' . ($active ? 'bg-[#d9f99d] text-[#15803d] font-bold shadow-sm' : 'text-[#44341d] hover:bg-gray-50 font-semibold')]) }}>
    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
        @if($icon == 'dashboard')
            <img src="{{ asset('images/icons/dashboard.png') }}" class="w-full h-full object-contain {{ $active ? '' : 'grayscale opacity-70' }}" alt="">
        @elseif($icon == 'users')
            <img src="{{ asset('images/icons/users.png') }}" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @elseif($icon == 'audit')
            <img src="{{ asset('images/icons/audit.png') }}" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @elseif($icon == 'reports')
            <img src="{{ asset('images/icons/reports.png') }}" class="w-full h-full object-contain grayscale opacity-70" alt="">
        @endif
    </div>
    <span class="font-inter text-[16px] whitespace-nowrap overflow-hidden transition-all duration-300 origin-left" 
          :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 invisible'">
        {{ $slot }}
    </span>
</a>
