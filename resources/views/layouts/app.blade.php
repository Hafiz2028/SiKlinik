<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <title>Sistem Informasi Klinik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{
    page: 'dashboard',
    'loaded': true,
    'darkMode': false,
    'stickyMenu': false,
    'sidebarToggle': false,
    'scrollTop': false,
    modalOpen: false,
    modalTitle: '',
    modalMessage: '',
    modalAction: '',
    modalConfirmText: '',
    modalMethod: 'DELETE',
    modalType: 'warning',
    openModal(event, type = 'warning') {
        this.modalOpen = true;
        this.modalType = type;
        this.modalTitle = event.currentTarget.dataset.title;
        this.modalMessage = event.currentTarget.dataset.message;
        this.modalAction = event.currentTarget.dataset.action;
        this.modalConfirmText = event.currentTarget.dataset.confirm;
        this.modalMethod = event.currentTarget.dataset.method || 'DELETE';
    }
}" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">

    {{-- 2. HAPUS DIV PEMBUNGKUS X-DATA YANG LAMA --}}

    <!-- ===== Preloader Start ===== -->
    <x-partials.preloader />
    <!-- ===== Preloader End ===== -->

    <div class="flex h-screen overflow-hidden">
        <x-partials.sidebar />

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <x-partials.overlay />
            <x-partials.header />

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- 3. MODAL SEKARANG BERADA DI LEVEL ROOT BODY --}}
    <x-confirm-modal />
     @stack('scripts')
</body>

</html>
