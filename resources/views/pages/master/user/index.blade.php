<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <div x-data="{ pageName: `User` }">
            <x-partials.breadcrumb />
        </div>
        <div class="my-4">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6"
            x-data="userManager()">

            <x-partials.table-header title="Data Master User"
                description="Gunakan filter dan pencarian untuk menelusuri data secara instan." :addRoute="route('user.create')"
                addLabel="Tambah User" />

            <div class="flex flex-col gap-4 mb-4 sm:flex-row sm:items-center sm:justify-between">
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
                <div class="sm:w-1/3">
                    <label for="search" class="sr-only">Cari</label>
                    <input type="text" id="search" x-model.debounce.300ms="search"
                        class="w-full h-11 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Cari nama atau email...">
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-100 border-y dark:border-gray-800">
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('name')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'name' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'name' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('email')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'email' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'email' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('role')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Role</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'role' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'role' && sortDirection === 'desc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer select-none" @click="sortBy('status')">
                                <div class="flex items-center gap-1.5">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg x-show="sortColumn === 'status' && sortDirection === 'asc'"
                                            class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                        </svg>
                                        <svg x-show="sortColumn === 'status' && sortDirection === 'desc'"
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
                        <template x-for="user in paginatedData" :key="user.id">
                            <tr :class="user.deleted_at ? 'bg-gray-50 dark:bg-gray-800/20' : ''">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 overflow-hidden rounded-full"><img
                                                :src="`https://placehold.co/40x40/6366f1/white?text=${user.name.charAt(0).toUpperCase()}`"
                                                alt="Avatar" /></div>
                                        <div>
                                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                                                x-text="user.name"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="user.email"></p>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1" x-html="displayRoles(user.roles)"></div>
                                </td>
                                <td class="px-4 py-3">
                                    <template x-if="user.pegawai">
                                        <span
                                            class="inline-block rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Pegawai</span>
                                    </template>
                                    <template x-if="!user.pegawai">
                                        <span
                                            class="inline-block rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Non-Pegawai</span>
                                    </template>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <template x-if="user.deleted_at">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button type="button" @click="openModal($event, 'warning')"
                                                    :data-title="'Pulihkan User'"
                                                    :data-message="`Pulihkan user '${user.name}'?`"
                                                    :data-action="`/user/${user.id}/restore`"
                                                    data-confirm="Ya, Pulihkan" data-method="PUT"
                                                    class="p-2 text-green-500 transition-colors duration-200 rounded-lg hover:bg-green-100 dark:hover:bg-gray-700"
                                                    title="Pulihkan"><svg class="w-5 h-5" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0011.664 0l3.181-3.183m-4.991-2.691V5.25a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v4.992" />
                                                    </svg></button>
                                                <button type="button" @click="openModal($event, 'danger')"
                                                    :data-title="'Hapus Permanen User'"
                                                    :data-message="`ANDA YAKIN? Data '${user.name}' akan dihapus permanen.`"
                                                    :data-action="`/user/${user.id}/force-delete`"
                                                    data-confirm="Ya, Hapus Permanen"
                                                    class="p-2 text-red-700 transition-colors duration-200 rounded-lg hover:bg-red-200 dark:hover:bg-gray-700"
                                                    title="Hapus Permanen"><svg class="w-5 h-5" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg></button>
                                            </div>
                                        </template>
                                        <template x-if="!user.deleted_at">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a :href="`/user/${user.id}/edit`"
                                                    class="p-2 text-blue-500 transition-colors duration-200 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700"
                                                    title="Edit"><svg class="w-5 h-5" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z">
                                                        </path>
                                                    </svg></a>
                                                <button type="button" @click="openModal($event, 'warning')"
                                                    :data-title="'Arsipkan User'"
                                                    :data-message="`Arsipkan user '${user.name}'?`"
                                                    :data-action="`/user/${user.id}`" data-confirm="Ya, Arsipkan"
                                                    class="p-2 text-red-500 transition-colors duration-200 rounded-lg hover:bg-red-100 dark:hover:bg-gray-700"
                                                    title="Arsipkan"><svg class="w-5 h-5" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                    </svg></button>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredData.length === 0">
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                data yang cocok.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4 text-sm">
                <div class="flex items-center gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-400 rounded disabled:opacity-50 dark:bg-gray-600 dark:text-gray-200">Sebelumnya</button>
                    <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Halaman ${currentPage} dari ${totalPages}`"></span>
                    <button @click="nextPage" :disabled="currentPage === totalPages || totalPages === 0"
                        class="px-3 py-1 bg-gray-400 rounded disabled:opacity-50 dark:bg-gray-600 dark:text-gray-200">Berikutnya</button>
                </div>
                <div>
                    <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90"
                        x-text="`Menampilkan ${paginatedData.length} dari ${filteredData.length} total data.`"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userManager() {
            return {
                allUsers: @json($users),
                tab: 'aktif',
                search: '',
                sortColumn: 'name',
                sortDirection: 'asc',
                currentPage: 1,
                itemsPerPage: 10,
                init() {
                    this.$watch('search', () => this.currentPage = 1);
                    this.$watch('tab', () => this.currentPage = 1);
                },
                get filteredData() {
                    let data = [...this.allUsers];
                    data = data.filter(user => {
                        const statusMatch = (this.tab === 'aktif' && !user.deleted_at) || (this.tab ===
                            'diarsipkan' && user.deleted_at);
                        const searchMatch = user.name.toLowerCase().includes(this.search.toLowerCase()) ||
                            user.email.toLowerCase().includes(this.search.toLowerCase());
                        return statusMatch && searchMatch;
                    });
                    data.sort((a, b) => {
                        let valA, valB;

                        // Logika khusus untuk sorting 'role' dan 'status'
                        if (this.sortColumn === 'role') {
                            valA = a.roles.length > 0 ? a.roles[0].name.toLowerCase() : '';
                            valB = b.roles.length > 0 ? b.roles[0].name.toLowerCase() : '';
                        } else if (this.sortColumn === 'status') {
                            valA = a.pegawai ? 1 : 0; // Pegawai = 1, Non-Pegawai = 0
                            valB = b.pegawai ? 1 : 0;
                        } else {
                            // Logika sorting default untuk kolom biasa
                            valA = a[this.sortColumn];
                            valB = b[this.sortColumn];

                            if (typeof valA === 'string') {
                                valA = valA.toLowerCase();
                                valB = valB.toLowerCase();
                            }
                        }
                        if (valA < valB) return this.sortDirection === 'asc' ? -1 : 1;
                        if (valA > valB) return this.sortDirection === 'asc' ? 1 : -1;
                        return 0;
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
                sortBy(column) {
                    if (this.sortColumn === column) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortColumn = column;
                        this.sortDirection = 'asc';
                    }
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                // Helper function untuk menampilkan role
                displayRoles(roles) {
                    if (!roles || roles.length === 0) return '';
                    return roles.map(role =>
                        `<span class="inline-block rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">${role.name}</span>`
                    ).join(' ');
                }
            }
        }
    </script>
</x-app-layout>
