@props(['label', 'value', 'trend' => null, 'icon' => null])

<div class="bg-white border border-[#0c4010] rounded-lg p-6 flex flex-col justify-between shadow-sm relative overflow-hidden">
    <div class="flex justify-between items-start">
        <div class="space-y-1">
             <p class="text-[13px] font-semibold text-black font-inter">{{ $label }}</p>
             <h3 class="text-4xl font-bold text-black font-inter">{{ $value }}</h3>
        </div>
        <div class="w-12 h-12 flex items-center justify-center">
            @if($icon == 'projects')
                <img src="https://www.figma.com/api/mcp/asset/f0c1dc6c-0d15-4654-82a0-d559a07c9174" class="w-10 h-10" alt="">
            @elseif($icon == 'surveys')
                <img src="https://www.figma.com/api/mcp/asset/48a54659-b249-4934-9b32-d104aad4880f" class="w-10 h-10" alt="">
            @elseif($icon == 'volunteers')
                <img src="https://www.figma.com/api/mcp/asset/b48820cb-c81c-4cba-8867-1b06943ef857" class="w-10 h-10" alt="">
            @elseif($icon == 'communities')
                <img src="https://www.figma.com/api/mcp/asset/888ff7c6-80ac-4983-9a17-c6277ade5807" class="w-10 h-10" alt="">
            @endif
        </div>
    </div>
    
    @if($trend)
    <div class="mt-4 flex items-center gap-2">
        <div class="bg-[#d9f99d] px-2 py-0.5 rounded-full flex items-center gap-1">
            <img src="https://www.figma.com/api/mcp/asset/f87fb02f-d9ed-4251-aa45-f7f5ab82aae6" class="w-2.5 h-2.5" alt="">
            <span class="text-[10px] font-bold text-black">+{{ $trend }}%</span>
        </div>
        <span class="text-[10px] text-gray-500 font-inter">vs last month</span>
    </div>
    @endif
</div>
