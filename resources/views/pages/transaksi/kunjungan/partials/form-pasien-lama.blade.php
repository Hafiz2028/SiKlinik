<div class="rounded-lg border border-gray-200 p-5 dark:border-gray-800">
    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Cari Pasien Terdaftar</h4>
    <input type="hidden" name="pasien_id" :value="selectedPasienId">

    <!-- Search Box -->
    <div class="relative">
        <label for="search_pasien" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Cari No. RM /
            Nama Pasien<span class="text-red-500">*</span></label>
        <input type="text" id="search_pasien" x-model.debounce.300ms="search" @focus="search.length"
            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('pasien_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
            placeholder="Ketik untuk mencari...">
        <!-- Search Results -->
        <div x-show="search.length > 0 && filteredPasiens.length > 0" @click.away="search = ''"
            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 max-h-60 overflow-y-auto">
            <ul>
                <template x-for="pasien in filteredPasiens" :key="pasien.id">
                    <li @click="selectPasien(pasien.id)"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                        <p class="font-semibold text-gray-800 dark:text-white/90" x-text="pasien.nama_pasien"></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="pasien.no_rekam_medis"></p>
                    </li>
                </template>
            </ul>
        </div>

    </div>

    <!-- Selected Patient Info -->
    <div x-show="selectedPasien" style="display: none;"
        class="p-4 mt-4 border border-blue-200 rounded-lg bg-blue-50 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="font-semibold text-lg text-gray-900 dark:text-white" x-text="selectedPasien?.nama_pasien"></h5>
        <div class="grid grid-cols-2 gap-2 mt-2 text-sm text-gray-700 dark:text-gray-400">
            <p><strong>No. RM:</strong> <span x-text="selectedPasien?.no_rekam_medis"></span></p>
            <p><strong>Umur:</strong> <span x-text="calculateAge(selectedPasien?.tanggal_lahir)"></span></p>
        </div>
    </div>

    @error('pasien_id')
        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
    @enderror
</div>
