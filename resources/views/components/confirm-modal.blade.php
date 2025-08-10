@props([
    'title' => 'Konfirmasi Tindakan',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'actionUrl' => '#',
    'type' => 'warning',
])

@php
    $colors = [
        'warning' => [
            'icon_bg' => 'bg-warning-100 dark:bg-warning-500/15',
            'icon_text' => 'text-warning-500',
            'button_bg' =>
                'bg-warning-600 hover:bg-warning-700 focus:ring-warning-300 dark:bg-warning-500 dark:hover:bg-warning-600 dark:focus:ring-warning-800',
            'icon_path' =>
                'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0zM12 9v4M12 17h.01',
        ],
        'danger' => [
            'icon_bg' => 'bg-red-100 dark:bg-red-500/15',
            'icon_text' => 'text-red-600',
            'button_bg' =>
                'bg-red-600 hover:bg-red-700 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800',
            'icon_path' =>
                'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z',
        ],
    ];
    $color = $colors[$type];
@endphp
<template x-teleport="body">
    <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900 bg-opacity-50" style="display: none;">

        <!-- Modal Panel -->
        <div @click.outside="modalOpen = false" x-show="modalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-md p-6 mx-4 bg-white rounded-2xl shadow-xl dark:bg-gray-800">

            <div class="sm:flex sm:items-start">
                <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full {{ $color['icon_bg'] }} sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 {{ $color['icon_text'] }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $color['icon_path'] }}">
                        </path>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" x-text="modalTitle"></h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="modalMessage"></p>
                    </div>
                </div>
            </div>

            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <form :action="modalAction" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    {{-- Method spoofing untuk restore (jika diperlukan nanti) --}}
                    <template x-if="modalMethod === 'PUT'">
                        @method('PUT')
                    </template>

                    <button type="submit"
                        :class="{
                            'bg-warning-600 hover:bg-warning-700 focus:ring-warning-300 dark:bg-warning-500 dark:hover:bg-warning-600 dark:focus:ring-warning-800': modalType === 'warning',
                            'bg-red-600 hover:bg-red-700 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800': modalType === 'danger'
                        }"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        <span x-text="modalConfirmText"></span>
                    </button>
                </form>
                <button @click="modalOpen = false" type="button"
                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </div>
    </div>
</template>
