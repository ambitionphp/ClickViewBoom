@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full px-3 py-2 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors']) !!}>
