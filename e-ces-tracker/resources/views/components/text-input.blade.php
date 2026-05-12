@props(['disabled' => false, 'icon' => null])

<div class="relative w-full">
    @if($icon)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            {{ $icon }}
        </div>
    @endif
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white/10 border-none text-white text-[17px] rounded-[50px] focus:ring-[#1b8c00] focus:border-[#1b8c00] block w-full px-6 py-3 font-afacad placeholder-white/50']) !!}>
</div>
