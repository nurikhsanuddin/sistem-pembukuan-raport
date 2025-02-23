@props(['active'])

@php
$classes = ($active ?? false)
            ? 'relative flex items-center w-full p-2 text-gray-900 transition-colors duration-200 rounded-lg bg-gray-100 group'
            : 'relative flex items-center w-full p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:text-gray-900 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    @if($active ?? false)
        <span class="absolute right-0 w-1 h-8 bg-indigo-500 rounded-l-lg"></span>
    @endif
</a>
