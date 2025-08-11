<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Pendaftaran Kunjungan` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->
        <div class="my-4">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
        </div>

        <!-- ====== Table Section Start -->
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6"
            x-data="kunjunganManager()">
            @if (auth()->user()->hasRole('petugas-pendaftaran') || auth()->user()->hasRole('admin'))
                <x-partials.table-header title="Data Kunjungan Pasien"
                    description="Daftar pasien yang melakukan kunjungan. Gunakan filter dan pencarian." :addRoute="route('kunjungan.create')"
                    addLabel="Daftarkan Kunjungan Baru" />
            @endif
            <!-- Filter & Pencarian Interaktif -->

            <div class="flex flex-col gap-4 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <!-- Navigasi Tab Status -->

                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        @if (auth()->user()->hasRole('admin'))
                            <li class="mr-2" @click.prevent="tab = 'Semua'"><a href="#"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="tabClass('Semua')">Semua</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole('petugas-pendaftaran') ||
                                auth()->user()->hasRole('admin') ||
                                auth()->user()->hasRole('dokter'))
                            <li class="mr-2" @click.prevent="tab = 'Menunggu'">
                                <a href="#" class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="tabClass('Menunggu')">Menunggu</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('dokter'))
                            <li class="mr-2" @click.prevent="tab = 'Diperiksa'"><a href="#"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="tabClass('Diperiksa')">Diperiksa</a></li>
                        @endif
                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('kasir'))
                            <li class="mr-2" @click.prevent="tab = 'Menunggu Pembayaran'"><a href="#"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="tabClass('Menunggu Pembayaran')">Bayar</a></li>
                        @endif
                        @if (auth()->user()->hasRole('admin') ||
                                auth()->user()->hasRole('kasir') ||
                                auth()->user()->hasRole('petugas-pendaftaran'))
                            <li class="mr-2" @click.prevent="tab = 'Selesai'"><a href="#"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="tabClass('Selesai')">Selesai</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Pencarian -->
                <div class="sm:w-1/3">
                    <label for="search" class="sr-only">Cari</label>
                    <input type="text" id="search" x-model.debounce.300ms="search"
                        class="w-full h-11 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Cari nama pasien atau No. RM...">
                </div>
            </div>


            <div class="w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-100 border-y dark:border-gray-800">
                            <th class="px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kode Kunjungan</p>
                            </th>
                            <th class="px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Pasien</p>
                            </th>
                            <th class="px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal</p>
                            </th>
                            <th class="px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jenis</p>
                            </th>
                            <th class="px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>
                            <th class="px-4 py-3 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <template x-for="kunjungan in paginatedData" :key="kunjungan.id">
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                                        x-text="kunjungan.kode_kunjungan"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                                        x-text="kunjungan.pasien.nama_pasien"></p>
                                    <p class="text-xs text-gray-500" x-text="kunjungan.pasien.no_rekam_medis"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"
                                        x-text="formatTanggal(kunjungan.tanggal_kunjungan)"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"
                                        x-text="kunjungan.jenis_kunjungan.nama"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full"
                                        :class="statusClass(kunjungan.status_kunjungan)"
                                        x-text="kunjungan.status_kunjungan"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Aksi Dinamis -->
                                        <template
                                            x-if="kunjungan.status_kunjungan === 'Menunggu' || kunjungan.status_kunjungan === 'Diperiksa'">
                                            <a :href="`/transaksi/pemeriksaan/${kunjungan.id}`"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Periksa
                                            </a>
                                        </template>
                                        <template x-if="kunjungan.status_kunjungan === 'Menunggu Pembayaran'">
                                            <a :href="`/transaksi/pembayaran/${kunjungan.id}`"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Bayar
                                            </a>
                                        </template>
                                        <template x-if="kunjungan.status_kunjungan === 'Selesai'">
                                            <a :href="`/transaksi/kunjungan/${kunjungan.id}`"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-sm font-medium text-white bg-gray-500 rounded-md shadow-sm hover:bg-gray-600">
                                                <!-- Ikon huruf i (informasi) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-4a1 1 0 100 2 1 1 0 000-2zm1 4H9v5h2v-5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Detail
                                            </a>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredData.length === 0">
                            <td colspan="6" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                data
                                kunjungan yang cocok.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Client-side -->
            <div class="flex items-center justify-between mt-4 text-sm">
                <div class="flex items-center gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50 dark:bg-gray-700">Sebelumnya</button>
                    <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Halaman ${currentPage} dari ${totalPages}`"></span>
                    <button @click="nextPage" :disabled="currentPage === totalPages || totalPages === 0"
                        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50 dark:bg-gray-700">Berikutnya</button>
                </div>
                <div><span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Menampilkan ${paginatedData.length} dari ${filteredData.length} total data.`"></span>
                </div>
            </div>
        </div>
        <!-- ====== Table Section End -->
    </div>

    @push('scripts')
        <script>
            function kunjunganManager() {
                return {
                    allKunjungans: @json($kunjungans),
                    tab: 'Semua',
                    search: '',
                    currentPage: 1,
                    itemsPerPage: 10,

                    init() {
                        this.$watch('search', () => this.currentPage = 1);
                        this.$watch('tab', () => this.currentPage = 1);
                    },

                    get filteredData() {
                        let data = [...this.allKunjungans];
                        data = data.filter(k => {
                            const statusMatch = this.tab === 'Semua' || k.status_kunjungan === this.tab;
                            const searchMatch = k.pasien.nama_pasien.toLowerCase().includes(this.search
                                .toLowerCase()) || k.pasien.no_rekam_medis.toLowerCase().includes(this.search
                                .toLowerCase());
                            return statusMatch && searchMatch;
                        });
                        return data;
                    },

                    get totalPages() {
                        if (this.filteredData.length === 0) return 1;
                        return Math.ceil(this.filteredData.length / this.itemsPerPage);
                    },

                    get paginatedData() {
                        const start = (this.currentPage - 1) * this.itemsPerPage;
                        const end = start + this.itemsPerPage;
                        return this.filteredData.slice(start, end);
                    },

                    nextPage() {
                        if (this.currentPage < this.totalPages) this.currentPage++;
                    },
                    prevPage() {
                        if (this.currentPage > 1) this.currentPage--;
                    },

                    formatTanggal(tanggal) {
                        return new Date(tanggal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                    },

                    tabClass(tabName) {
                        return {
                            'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': this.tab === tabName,
                            'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': this
                                .tab !== tabName
                        };
                    },

                    statusClass(status) {
                        switch (status) {
                            case 'Menunggu':
                                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                            case 'Diperiksa':
                                return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                            case 'Menunggu Pembayaran':
                                return 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                            case 'Selesai':
                                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            case 'Batal':
                                return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            default:
                                return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        }
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
