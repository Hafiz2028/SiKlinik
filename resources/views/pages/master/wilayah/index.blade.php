<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Wilayah Interaktif` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6"
            x-data="wilayahManager()">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Data Master Wilayah
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gunakan filter dan pencarian untuk menelusuri data
                    secara instan.
                </p>
            </div>

            <!-- Navigasi Tab -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="mr-2">
                        <a href="#" @click.prevent="changeTab('provinsi')"
                            :class="{ 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': tab === 'provinsi' }"
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Provinsi</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" @click.prevent="changeTab('kabupaten')"
                            :class="{ 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': tab === 'kabupaten' }"
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Kabupaten/Kota</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" @click.prevent="changeTab('kecamatan')"
                            :class="{ 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': tab === 'kecamatan' }"
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Kecamatan</a>
                    </li>
                </ul>
            </div>

            <!-- Filter & Pencarian Interaktif -->
            <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Pencarian Umum -->
                <div>
                    <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari Nama
                        Wilayah</label>
                    <input type="text" id="search" x-model.debounce.300ms="filters.search"
                        class="w-full h-11 mt-1.5 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Ketik untuk mencari...">
                </div>
                <!-- Filter Provinsi -->
                <div x-show="tab === 'kabupaten' || tab === 'kecamatan'">
                    <label for="provinsi_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter
                        Provinsi</label>
                    <select id="provinsi_id" x-model="filters.provinsiId" @change="fetchKabupatens"
                        class="w-full h-11 mt-1.5 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Provinsi</option>
                        @foreach ($listProvinsi as $provinsi)
                            <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Kabupaten -->
                <div x-show="tab === 'kecamatan'">
                    <label for="kabupaten_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter
                        Kabupaten</label>
                    <select id="kabupaten_id" x-model="filters.kabupatenId"
                        :disabled="!filters.provinsiId || availableKabupatens.length === 0"
                        class="w-full h-11 mt-1.5 rounded-lg border-gray-300 disabled:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:disabled:bg-gray-900 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Kabupaten</option>
                        <template x-for="kab in availableKabupatens" :key="kab.id">
                            <option :value="kab.id" x-text="kab.nama"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Konten Tab (Tabel) -->
            <div class="w-full overflow-x-auto">
                <!-- Tabel Provinsi -->
                <div x-show="tab === 'provinsi'">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-gray-100 border-y dark:border-gray-800">
                            <tr>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">ID</th>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Nama Provinsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <template x-for="provinsi in paginatedData" :key="provinsi.id">
                                <tr>
                                    <td class="p-4 text-gray-500 dark:text-gray-400" x-text="provinsi.id"></td>
                                    <td class="p-4 font-medium text-gray-800 dark:text-white/90" x-text="provinsi.nama">
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredProvinsis.length === 0">
                                <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                    data yang cocok.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Kabupaten/Kota -->
                <div x-show="tab === 'kabupaten'">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-gray-100 border-y dark:border-gray-800">
                            <tr>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Kabupaten/Kota</th>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Provinsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <template x-for="kabupaten in paginatedData" :key="kabupaten.id">
                                <tr>
                                    <td class="p-4 font-medium text-gray-800 dark:text-white/90"
                                        x-text="kabupaten.nama"></td>
                                    <td class="p-4 text-gray-500 dark:text-gray-400" x-text="kabupaten.provinsi.nama">
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredKabupatens.length === 0">
                                <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                    data yang cocok.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Kecamatan -->
                <div x-show="tab === 'kecamatan'">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-gray-100 border-y dark:border-gray-800">
                            <tr>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Kecamatan</th>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Kabupaten/Kota</th>
                                <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Provinsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <template x-for="kecamatan in paginatedData" :key="kecamatan.id">
                                <tr>
                                    <td class="p-4 font-medium text-gray-800 dark:text-white/90"
                                        x-text="kecamatan.nama"></td>
                                    <td class="p-4 text-gray-500 dark:text-gray-400" x-text="kecamatan.kabupaten.nama">
                                    </td>
                                    <td class="p-4 text-gray-500 dark:text-gray-400"
                                        x-text="kecamatan.kabupaten.provinsi.nama"></td>
                                </tr>
                            </template>
                            <tr x-show="filteredKecamatans.length === 0">
                                <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                    data yang cocok.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Client-side -->
            <div class="flex items-center justify-between mt-4 text-sm">
                <div class="flex items-center gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50 dark:bg-gray-700">Sebelumnya</button>
                    <span x-text="`Halaman ${currentPage} dari ${totalPages}`"></span>
                    <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50 dark:bg-gray-700">Berikutnya</button>
                </div>
                <div>
                    <span x-text="`Menampilkan ${paginatedData.length} dari ${totalItems} total data.`"></span>
                </div>
            </div>

        </div>
    </div>

    <script>
        function wilayahManager() {
            return {
                // State
                tab: 'provinsi',
                filters: {
                    search: '',
                    provinsiId: '',
                    kabupatenId: '',
                },

                // Data Mentah (dari Laravel)
                allProvinsis: @json($provinsis),
                allKabupatens: @json($kabupatens),
                allKecamatans: @json($kecamatans),

                // Data Hasil Filter
                filteredProvinsis: [],
                filteredKabupatens: [],
                filteredKecamatans: [],

                // Untuk dropdown dinamis
                availableKabupatens: [],

                // Pagination state
                currentPage: 1,
                itemsPerPage: 10,

                // Lifecycle hook
                init() {
                    // Inisialisasi data yang ditampilkan saat pertama kali load
                    this.filteredProvinsis = this.allProvinsis;
                    this.filteredKabupatens = this.allKabupatens;
                    this.filteredKecamatans = this.allKecamatans;

                    // Watch for changes in filters and apply them
                    this.$watch('filters', () => {
                        this.currentPage = 1; // Reset to first page on new filter
                        this.applyFilters();
                    });
                },

                // Computed Properties (Getters)
                get totalItems() {
                    if (this.tab === 'provinsi') return this.filteredProvinsis.length;
                    if (this.tab === 'kabupaten') return this.filteredKabupatens.length;
                    if (this.tab === 'kecamatan') return this.filteredKecamatans.length;
                    return 0;
                },

                get totalPages() {
                    return Math.ceil(this.totalItems / this.itemsPerPage);
                },

                get paginatedData() {
                    let data;
                    if (this.tab === 'provinsi') data = this.filteredProvinsis;
                    if (this.tab === 'kabupaten') data = this.filteredKabupatens;
                    if (this.tab === 'kecamatan') data = this.filteredKecamatans;

                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;

                    return data.slice(start, end);
                },

                // Methods
                changeTab(newTab) {
                    this.tab = newTab;
                    this.currentPage = 1; // Reset pagination
                    // Filter ulang saat ganti tab karena filter prov/kab bisa jadi relevan
                    this.applyFilters();
                },

                applyFilters() {
                    const search = this.filters.search.toLowerCase();

                    // Filter Provinsi
                    this.filteredProvinsis = this.allProvinsis.filter(p => {
                        return p.nama.toLowerCase().includes(search);
                    });

                    // Filter Kabupaten
                    this.filteredKabupatens = this.allKabupatens.filter(k => {
                        const searchMatch = k.nama.toLowerCase().includes(search) || k.provinsi.nama.toLowerCase()
                            .includes(search);
                        const provinsiMatch = !this.filters.provinsiId || k.provinsi_id == this.filters.provinsiId;
                        return searchMatch && provinsiMatch;
                    });

                    // Filter Kecamatan
                    this.filteredKecamatans = this.allKecamatans.filter(kec => {
                        const searchMatch = kec.nama.toLowerCase().includes(search) ||
                            kec.kabupaten.nama.toLowerCase().includes(search) ||
                            kec.kabupaten.provinsi.nama.toLowerCase().includes(search);
                        const provinsiMatch = !this.filters.provinsiId || kec.kabupaten.provinsi_id == this.filters
                            .provinsiId;
                        const kabupatenMatch = !this.filters.kabupatenId || kec.kabupaten_id == this.filters
                            .kabupatenId;
                        return searchMatch && provinsiMatch && kabupatenMatch;
                    });
                },

                fetchKabupatens() {
                    this.filters.kabupatenId = ''; // Reset pilihan kabupaten
                    if (!this.filters.provinsiId) {
                        this.availableKabupatens = [];
                        return;
                    }
                    // Ambil dari data yang sudah ada, bukan via API
                    this.availableKabupatens = this.allKabupatens.filter(k => k.provinsi_id == this.filters.provinsiId);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                }
            }
        }
    </script>
</x-app-layout>
