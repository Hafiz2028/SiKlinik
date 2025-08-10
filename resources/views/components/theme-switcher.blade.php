<div x-data="themeSwitcher" x-init="init()" class="flex items-center">
    <button @click="setTheme(theme === 'light' ? 'dark' : (theme === 'dark' ? 'system' : 'light'))"
        class="flex items-center justify-center w-10 h-10 rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none">

        {{-- Ikon Matahari (Light Mode) --}}
        <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-6 h-6">
            <path
                d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.106a.75.75 0 010 1.06l-1.591 1.59a.75.75 0 11-1.06-1.061l1.591-1.59a.75.75 0 011.06 0zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5h2.25a.75.75 0 01.75.75zM17.894 17.894a.75.75 0 01-1.06 0l-1.59-1.591a.75.75 0 111.06-1.06l1.59 1.59a.75.75 0 010 1.061zM12 18a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM5.106 17.894a.75.75 0 010-1.06l1.59-1.591a.75.75 0 011.061 1.06l-1.59 1.59a.75.75 0 01-1.06 0zM4.5 12a.75.75 0 01.75-.75h2.25a.75.75 0 010 1.5H5.25A.75.75 0 014.5 12zM6.106 6.106a.75.75 0 011.06 0l1.591 1.59a.75.75 0 01-1.06 1.061L6.106 7.167a.75.75 0 010-1.06z" />
        </svg>

        {{-- Ikon Bulan (Dark Mode) --}}
        <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-6 h-6">
            <path fill-rule="evenodd"
                d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 004.472-.69a.75.75 0 01.82.162a10.5 10.5 0 01-1.586 1.586a.75.75 0 01-1.044-.025a9 9 0 01-12.45-12.45a.75.75 0 01-.025-1.044A10.5 10.5 0 019.528 1.718z"
                clip-rule="evenodd" />
        </svg>

        {{-- Ikon Monitor (System Mode) --}}
        <svg x-show="theme === 'system'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-6 h-6">
            <path
                d="M10.5 1.75a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zM13.5 1.75a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zM10.858 6.135a.75.75 0 00-1.216.81L11.08 9.5h-1.33a.75.75 0 000 1.5h1.33l-1.438 2.565a.75.75 0 001.216.81l2.25-4a.75.75 0 000-.81l-2.25-4zM21 12.75a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5z" />
            <path fill-rule="evenodd" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-1.5a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"
                clip-rule="evenodd" />
        </svg>

    </button>
</div>
