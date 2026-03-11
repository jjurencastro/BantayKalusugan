@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-red-600 text-left text-base font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-slate-700 focus:outline-none focus:text-red-700 dark:focus:text-red-300 focus:bg-red-100 dark:focus:bg-slate-600 focus:border-red-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 dark:hover:border-slate-600 focus:outline-none focus:text-red-600 dark:focus:text-red-400 focus:bg-gray-50 dark:focus:bg-slate-700 focus:border-red-300 dark:focus:border-slate-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
