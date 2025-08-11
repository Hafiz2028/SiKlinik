{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false') }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', JSON.stringify(val)))"
    :class="{ 'dark bg-gray-900': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="relative p-6 bg-white dark:bg-gray-900 sm:p-0">
        <div class="flex flex-col justify-center w-full min-h-screen lg:flex-row">

            <!-- Slot untuk form -->
            <div class="flex flex-col flex-1 w-full lg:w-1/2">
                <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto sm:py-10">
                    {{ $slot }}
                </div>
            </div>


        </div>
    </div>
</body>

</html>
