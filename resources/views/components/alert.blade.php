@props(['type' => 'info', 'message'])

@php
    $colors = [
        'success' => [
            'border' => 'border-success-500 dark:border-success-500/30',
            'bg' => 'bg-success-50 dark:bg-success-500/15',
            'text' => 'text-success-500',
            'icon_path' =>
                'M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z',
            'title' => 'Berhasil',
        ],
        'error' => [
            'border' => 'border-error-500 dark:border-error-500/30',
            'bg' => 'bg-error-50 dark:bg-error-500/15',
            'text' => 'text-error-500',
            'icon_path' =>
                'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z',
            'title' => 'Terjadi Kesalahan',
        ],
        'warning' => [
            'border' => 'border-warning-500 dark:border-warning-500/30',
            'bg' => 'bg-warning-50 dark:bg-warning-500/15',
            'text' => 'text-warning-500',
            'icon_path' => 'M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z',
            'title' => 'Peringatan',
        ],
        'info' => [
            'border' => 'border-blue-500 dark:border-blue-500/30',
            'bg' => 'bg-blue-50 dark:bg-blue-500/15',
            'text' => 'text-blue-500',
            'icon_path' =>
                'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z',
            'title' => 'Informasi',
        ],
    ];
    $color = $colors[$type];
@endphp

@if ($message)
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
        class="rounded-xl border p-4 mb-4 {{ $color['border'] }} {{ $color['bg'] }}">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 {{ $color['text'] }}">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    @if ($type === 'success')
                        <path fill-rule="evenodd" clip-rule="evenodd" d="{{ $color['icon_path'] }}" fill="" />
                    @else
                        <path d="{{ $color['icon_path'] }}" fill="currentColor" />
                    @endif
                </svg>
            </div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                    {{ $color['title'] }}
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $message }}
                </p>
            </div>
            <button @click="show = false"
                class="ml-auto -mt-0.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>
@endif
