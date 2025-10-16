<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    x-init="setTimeout(() => show = false, {{ $timeout ?? 3000 }})"
    class="fixed top-20 right-6 z-50 px-4 py-3 rounded shadow-lg flex items-center space-x-2 text-sm font-medium
        {{ $type === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : '' }}
        {{ $type === 'error' ? 'bg-red-100 text-red-800 border border-red-300' : '' }}
        {{ $type === 'warning' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : '' }}
        {{ $type === 'info' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}"
>
    @if ($icon ?? false)
        <span class="w-5 h-5">
            @if ($type === 'success')
                <x-heroicon-o-check-circle class="text-green-500" />
            @elseif ($type === 'error')
                <x-heroicon-o-x-circle class="text-red-500" />
            @elseif ($type === 'warning')
                <x-heroicon-o-exclamation-triangle class="text-yellow-500" />
            @elseif ($type === 'info')
                <x-heroicon-o-information-circle class="text-blue-500" />
            @else
                <x-heroicon-o-bell class="text-gray-500" />
            @endif
        </span>
    @endif

    <span class="flex-1">{{ $message }}</span>

    <button @click="show = false" class="ml-auto text-lg leading-none hover:text-gray-800 dark:hover:text-white">&times;</button>
</div>
