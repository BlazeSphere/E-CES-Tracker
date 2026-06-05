@props(['label', 'value', 'trend' => null, 'icon' => null])

<div class="bg-white border border-[#0c4010] rounded-lg p-6 flex flex-col justify-between shadow-sm relative overflow-hidden">
    <div class="flex justify-between items-start">
        <div class="space-y-1">
             <p class="text-[13px] font-semibold text-black font-inter">{{ $label }}</p>
             <h3 class="text-4xl font-bold text-black font-inter">{{ $value }}</h3>
        </div>
        <div class="w-12 h-12 flex items-center justify-center">
            @if($icon == 'projects')
                <img src="{{ asset('images/icons/stat-projects.png') }}" class="w-10 h-10" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
            @elseif($icon == 'surveys')
                <img src="{{ asset('images/icons/stat-surveys.png') }}" class="w-10 h-10" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
            @elseif($icon == 'volunteers')
                <img src="{{ asset('images/icons/stat-volunteers.png') }}" class="w-10 h-10" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
            @elseif($icon == 'communities')
                <img src="{{ asset('images/icons/stat-communities.png') }}" class="w-10 h-10" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
            @endif
        </div>
    </div>
    
    @if($trend)
    <div class="mt-4 flex items-center gap-2">
        <div class="bg-[#d9f99d] px-2 py-0.5 rounded-full flex items-center gap-1">
            <img src="{{ asset('images/icons/trend-up.png') }}" class="w-2.5 h-2.5" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
            <span class="text-[10px] font-bold text-black">+{{ $trend }}%</span>
        </div>
        <span class="text-[10px] text-gray-500 font-inter">vs last month</span>
    </div>
    @endif
</div>
