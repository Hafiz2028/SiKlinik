<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Tambah Obat` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <form action="{{ route('obat.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <h3
                        class="text-base font-medium text-gray-800 dark:text-white/90 border-b border-gray-200 dark:border-gray-800 pb-3">
                        Form Tambah Obat Baru
                    </h3>

                    {{-- Nama Obat --}}
                    <div>
                        <label for="nama_obat"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Obat<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nama_obat') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: Paracetamol 500mg" />
                        @error('nama_obat')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Satuan --}}
                    <div>
                        <label for="satuan"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Satuan<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="satuan" name="satuan" value="{{ old('satuan') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('satuan') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: Tablet, Botol, Strip" />
                        @error('satuan')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label for="stok"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Stok<span
                                class="text-error-500">*</span></label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('stok') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Masukkan jumlah stok awal" />
                        @error('stok')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="harga"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Harga<span
                                class="text-error-500">*</span></label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga') }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('harga') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Masukkan harga per satuan (contoh: 5000)" />
                        @error('harga')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('obat.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Batal
                    </a>
                    <button type="submit" name="action" value="save_and_new"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Simpan & Tambah Lagi
                    </button>
                    <button type="submit" name="action" value="save"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-theme-xs hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Simpan Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
