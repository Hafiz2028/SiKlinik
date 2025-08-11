@props(['icon', 'title', 'value', 'bg' => 'from-gray-100 to-gray-200', 'textColor' => 'text-gray-800'])

<div class="rounded-2xl p-5 md:p-6 bg-gradient-to-r {{ $bg }} shadow-md">
    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/20">
        @switch($icon)
            @case('pasien')
                <svg class="{{ $textColor }}" width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M19 4H5C3.9 4 3 4.9 3 6V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            @break

            @case('total-pasien')
                <svg class="{{ $textColor }}" width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M17 21V19C17 16.8 15.2 15 13 15H5C2.8 15 1 16.8 1 19V21" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 11C11.2 11 13 9.2 13 7C13 4.8 11.2 3 9 3C6.8 3 5 4.8 5 7C5 9.2 6.8 11 9 11Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M23 21V19C23 16.87 21.33 15.12 19.21 15" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17 3C18.77 3.48 20.01 5.06 20 7C19.99 8.94 18.75 10.52 16.98 11" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            @break

            @case('pendapatan')
                <svg class="{{ $textColor }}" width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 18V16M12 12V10M12 6V5M18 12H16M14 12H10M8 12H6M21 12C21 16.97 16.97 21 12 21C7.03 21 3 16.97 3 12C3 7.03 7.03 3 12 3C16.97 3 21 7.03 21 12Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            @break

            @case('obat')
                <svg class="{{ $textColor }}" width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M8.5 4H15.5C16.33 4 17 4.67 17 5.5V8.5C17 9.33 16.33 10 15.5 10H8.5C7.67 10 7 9.33 7 8.5V5.5C7 4.67 7.67 4 8.5 4Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 10V18.5C7 19.33 7.67 20 8.5 20H15.5C16.33 20 17 19.33 17 18.5V10" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 13V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10 15H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            @break
        @endswitch
    </div>

    <div class="mt-5">
        <span class="text-sm {{ $textColor }}/80">{{ $title }}</span>
        <h4 class="mt-2 text-2xl font-bold {{ $textColor }}">{{ $value }}</h4>
    </div>
</div>
