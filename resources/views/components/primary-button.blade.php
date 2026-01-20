<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#a9e90f] border border-transparent rounded-md font-semibold text-xs text-[#010102] uppercase tracking-widest hover:bg-[#92cc0d] focus:bg-[#92cc0d] active:bg-[#a9e90f] focus:outline-none focus:ring-2 focus:ring-[#a9e90f] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
