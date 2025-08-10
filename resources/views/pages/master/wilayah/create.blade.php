<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Tambah Wilayah` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <form action="{{ route('wilayah.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <h3
                        class="text-base font-medium text-gray-800 dark:text-white/90 border-b border-gray-200 dark:border-gray-800 pb-3">
                        Form Tambah Wilayah Baru
                    </h3>

                    <div>
                        <label for="nama_provinsi"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Provinsi<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="nama_provinsi" name="nama_provinsi" value="{{ old('nama_provinsi') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nama_provinsi') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: Jawa Barat" />
                        @error('nama_provinsi')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_kabupaten"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                            Kabupaten/Kota<span class="text-error-500">*</span></label>
                        <input type="text" id="nama_kabupaten" name="nama_kabupaten"
                            value="{{ old('nama_kabupaten') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nama_kabupaten') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: Kota Bandung" />
                        @error('nama_kabupaten')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('wilayah.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-theme-xs hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Simpan Wilayah
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
