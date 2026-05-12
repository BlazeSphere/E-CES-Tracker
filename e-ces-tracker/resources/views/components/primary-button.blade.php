<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-10 py-2 bg-white border border-transparent rounded-[50px] font-semibold text-[24px] text-black hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[#1b8c00] focus:ring-offset-2 transition ease-in-out duration-150 shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] font-afacad']) }}>
    {{ $slot }}
</button>
