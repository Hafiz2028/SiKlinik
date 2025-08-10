<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Edit Tindakan` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <form action="{{ route('tindakan.update', $tindakan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <h3
                        class="pb-3 text-base font-medium text-gray-800 border-b border-gray-200 dark:text-white/90 dark:border-gray-800">
                        Form Edit Tindakan
                    </h3>
                    <div>
                        <label for="nama_tindakan"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                            Tindakan<span class="text-error-500">*</span></label>
                        <input type="text" id="nama_tindakan" name="nama_tindakan"
                            value="{{ old('nama_tindakan', $tindakan->nama_tindakan) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:bg-gray-900 dark:text-white/90 @if($errors->has('nama_tindakan')) border-error-300 @else border-gray-300 dark:border-gray-700 @endif"
                            placeholder="Contoh: Pemeriksaan Badan" />
                        @error('nama_tindakan')
                            <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Harga --}}
                    <div>
                        <label for="harga"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Harga<span
                                class="text-error-500">*</span></label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $tindakan->harga) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:bg-gray-900 dark:text-white/90 @if($errors->has('harga')) border-error-300 @else border-gray-300 dark:border-gray-700 @endif"
                            placeholder="contoh: 50000" />
                        @error('harga')
                            <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi"
                            value="{{ old('deskripsi', $tindakan->deskripsi) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:bg-gray-900 dark:text-white/90 @if($errors->has('deskripsi')) border-error-300 @else border-gray-300 dark:border-gray-700 @endif"
                            placeholder="Contoh: Pemeriksaan pasien" />
                        @error('deskripsi')
                            <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('tindakan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-theme-xs hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
