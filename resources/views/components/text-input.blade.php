@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 rounded-md shadow-sm']) }}>
