@props([
    'danger' => null,
])

<button
    {{ $attributes
    ->merge(['type' => 'button'])
    ->class(
        [
            'rounded-md inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200  border-transparent  text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300' => !$danger,
            'rounded-md bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-25' => $danger
        ])}}>
    {{ $slot }}
</button>
