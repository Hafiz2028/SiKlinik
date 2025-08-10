<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Obat` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->
        <div class="my-4">
            {{-- Alert ini akan tetap berfungsi setelah redirect dari aksi (store, update, delete) --}}
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
        </div>

        <!-- ====== Table Section Start -->
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6"
            x-data="obatManager()">
            <x-partials.table-header title="Data Master Obat"
                description="Gunakan filter dan pencarian untuk menelusuri data secara instan." :addRoute="route('obat.create')"
                addLabel="Tambah Obat" />

            <!-- Filter & Pencarian Interaktif -->
            <div class="flex flex-col gap-4 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <!-- Navigasi Tab -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'aktif'"
                                class="inline-block p-4 border-b-2 rounded-t-lg"
                                :class="{
                                    'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': tab === 'aktif',
                                    'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600': tab !== 'aktif'
                                }">
                                Aktif
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'diarsipkan'"
                                class="inline-block p-4 border-b-2 rounded-t-lg"
                                :class="{
                                    'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': tab === 'diarsipkan',
                                    'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600': tab !== 'diarsipkan'
                                }">
                                Diarsipkan
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Pencarian -->
                <div class="sm:w-1/3">
                    <label for="search" class="sr-only">Cari</label>
                    <input type="text" id="search" x-model.debounce.300ms="search"
                        class="w-full h-11 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Cari nama obat...">
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-100 border-y dark:border-gray-800">
                            {{-- Header Tabel yang bisa diklik untuk sorting --}}
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('nama_obat')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Obat</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'nama_obat' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'nama_obat' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('satuan')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Satuan</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'satuan' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'satuan' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('stok')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Stok</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'stok' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'stok' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('harga')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Harga</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'harga' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'harga' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <template x-for="obat in paginatedData" :key="obat.id">
                            <tr :class="obat.deleted_at ? 'bg-gray-50 dark:bg-gray-800/20' : ''">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                                        x-text="obat.nama_obat"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="obat.satuan">
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="obat.stok"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"
                                        x-text="formatRupiah(obat.harga)"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Aksi akan ditampilkan berdasarkan status `deleted_at` --}}
                                        <template x-if="obat.deleted_at">
                                            <div class="flex items-center justify-center space-x-2">
                                                {{-- Tombol Pulihkan --}}
                                                <button type="button" @click="openModal($event, 'warning')"
                                                    :data-title="'Pulihkan Obat'"
                                                    :data-message="`Apakah Anda yakin ingin memulihkan obat '${obat.nama_obat}'?`"
                                                    :data-action="`/obat/${obat.id}/restore`"
                                                    data-confirm="Ya, Pulihkan" data-method="PUT"
                                                    class="p-2 text-green-500 transition-colors duration-200 rounded-lg hover:bg-green-100 dark:hover:bg-gray-700"
                                                    title="Pulihkan">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0011.664 0l3.181-3.183m-4.991-2.691V5.25a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v4.992" />
                                                    </svg>
                                                </button>
                                                {{-- Tombol Hapus Permanen --}}
                                                <button type="button" @click="openModal($event, 'danger')"
                                                    :data-title="'Hapus Permanen Obat'"
                                                    :data-message="`ANDA YAKIN? Data obat '${obat.nama_obat}' akan dihapus permanen.`"
                                                    :data-action="`/obat/${obat.id}/force-delete`"
                                                    data-confirm="Ya, Hapus Permanen"
                                                    class="p-2 text-red-700 transition-colors duration-200 rounded-lg hover:bg-red-200 dark:hover:bg-gray-700"
                                                    title="Hapus Permanen">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="!obat.deleted_at">
                                            <div class="flex items-center justify-center space-x-2">
                                                {{-- Tombol Edit --}}
                                                <a :href="`/obat/${obat.id}/edit`"
                                                    class="p-2 text-blue-500 transition-colors duration-200 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                {{-- Tombol Arsipkan --}}
                                                <button type="button" @click="openModal($event, 'warning')"
                                                    :data-title="'Arsipkan Obat'"
                                                    :data-message="`Apakah Anda yakin ingin mengarsipkan obat '${obat.nama_obat}'?`"
                                                    :data-action="`/obat/${obat.id}`" data-confirm="Ya, Arsipkan"
                                                    class="p-2 text-red-500 transition-colors duration-200 rounded-lg hover:bg-red-100 dark:hover:bg-gray-700"
                                                    title="Arsipkan">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredData.length === 0">
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data yang cocok.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Client-side -->
            <div class="flex items-center justify-between mt-4 text-sm">
                <div class="flex items-center gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-400 rounded disabled:opacity-50 dark:bg-gray-300">Sebelumnya</button>
                    <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Halaman ${currentPage} dari ${totalPages}`"></span>
                    <button @click="nextPage" :disabled="currentPage === totalPages || totalPages === 0"
                        class="px-3 py-1 bg-gray-400 rounded disabled:opacity-50 dark:bg-gray-300">Berikutnya</button>
                </div>
                <div>
                    <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Menampilkan ${paginatedData.length} dari ${filteredData.length} total data.`"></span>
                </div>
            </div>
        </div>
        <!-- ====== Table Section End -->
    </div>

    <script>
        /**
         * Mengelola state dan interaksi untuk tabel data master obat.
         */
        function obatManager() {
            return {
                // --- STATE ---
                // Menyimpan semua data obat yang diambil dari server.
                allObats: @json($obats),

                // State untuk UI
                tab: 'aktif', // Tab yang aktif: 'aktif' atau 'diarsipkan'
                search: '', // Teks pencarian

                // State untuk sorting
                sortColumn: 'nama_obat', // Kolom default untuk diurutkan
                sortDirection: 'asc', // Arah default: 'asc' (naik) atau 'desc' (turun)

                // State untuk pagination
                currentPage: 1,
                itemsPerPage: 10,

                // --- LIFECYCLE HOOK ---
                init() {
                    // Secara otomatis mereset halaman ke 1 jika filter atau tab berubah.
                    this.$watch('search', () => this.currentPage = 1);
                    this.$watch('tab', () => this.currentPage = 1);
                },

                // --- COMPUTED PROPERTIES (GETTERS) ---
                /**
                 * Getter ini adalah inti dari logika. Ia akan secara otomatis
                 * memfilter dan mengurutkan data setiap kali state (search, tab, sort) berubah.
                 */
                get filteredData() {
                    // Buat salinan array agar tidak mengubah data asli (`allObats`)
                    let data = [...this.allObats];

                    // 1. Proses FILTERING berdasarkan tab dan pencarian
                    data = data.filter(obat => {
                        const statusMatch = (this.tab === 'aktif' && !obat.deleted_at) || (this.tab ===
                            'diarsipkan' && obat.deleted_at);
                        const searchMatch = obat.nama_obat.toLowerCase().includes(this.search.toLowerCase());

                        return statusMatch && searchMatch;
                    });

                    // 2. Proses SORTING pada data yang sudah difilter
                    data.sort((a, b) => {
                        let valA = a[this.sortColumn];
                        let valB = b[this.sortColumn];

                        // Konversi ke huruf kecil jika tipe datanya string untuk sorting yang case-insensitive
                        if (typeof valA === 'string') {
                            valA = valA.toLowerCase();
                            valB = valB.toLowerCase();
                        }

                        // Logika perbandingan
                        if (valA < valB) return this.sortDirection === 'asc' ? -1 : 1;
                        if (valA > valB) return this.sortDirection === 'asc' ? 1 : -1;
                        return 0;
                    });

                    return data;
                },

                /**
                 * Menghitung total halaman untuk pagination berdasarkan data yang sudah difilter.
                 */
                get totalPages() {
                    if (this.filteredData.length === 0) return 1; // Tampilkan 1 halaman meskipun kosong
                    return Math.ceil(this.filteredData.length / this.itemsPerPage);
                },

                /**
                 * Mengambil "potongan" data yang sesuai untuk halaman yang sedang aktif.
                 */
                get paginatedData() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredData.slice(start, end);
                },

                // --- METHODS ---
                /**
                 * Mengubah state sorting saat header kolom diklik.
                 */
                sortBy(column) {
                    // Jika kolom yang sama diklik, balik arah sorting
                    if (this.sortColumn === column) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        // Jika kolom baru diklik, set kolom dan arah default ke 'asc'
                        this.sortColumn = column;
                        this.sortDirection = 'asc';
                    }
                },

                /**
                 * Memformat angka menjadi format mata uang Rupiah.
                 */
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                },

                /**
                 * Navigasi ke halaman berikutnya.
                 */
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                /**
                 * Navigasi ke halaman sebelumnya.
                 */
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                }
            }
        }
    </script>
</x-app-layout>
