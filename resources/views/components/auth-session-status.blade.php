@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-slate-700 p-4 rounded-md border border-green-200 dark:border-slate-600']) }}>
        {{ $status }}
    </div>
@endif
