@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#a9e90f] focus:ring-[#a9e90f] rounded-md shadow-sm']) }}>
