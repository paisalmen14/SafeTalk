@props(['active'])

@php
// Logika untuk class CSS pada link navigasi
$baseClasses = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';

$activeClasses = 'border-pink-500 text-gray-900 focus:border-pink-700'; // Style untuk link AKTIF

$inactiveClasses = 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300'; // Style untuk link TIDAK AKTIF

$classes = $active ? ($baseClasses . ' ' . $activeClasses) : ($baseClasses . ' ' . $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>