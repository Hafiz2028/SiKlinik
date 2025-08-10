<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <div x-data="{ pageName: `Edit Pegawai` }">
            <x-partials.breadcrumb />
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3
                        class="text-base font-medium text-gray-800 dark:text-white/90 border-b border-gray-200 dark:border-gray-800 pb-3">
                        Informasi Profil Pegawai
                    </h3>

                    {{-- 1. Tampilkan Akun User (Tidak Bisa Diedit) --}}
                    <div>
                        <label for="user_info" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Akun User Tertaut
                        </label>
                        <input type="text" id="user_info"
                            value="{{ $pegawai->user->name }} ({{ $pegawai->user->email }})"
                            class="h-11 w-full rounded-lg border bg-gray-100 dark:bg-gray-800 px-4 py-2.5 text-sm cursor-not-allowed border-gray-300 dark:border-gray-700"
                            readonly disabled />
                        <small class="text-xs text-gray-500 mt-1">Akun user tidak dapat diubah setelah pegawai
                            dibuat.</small>
                    </div>

                    {{-- Tampilkan Nama Lengkap sebagai info (tidak bisa diedit) --}}
                    <div>
                        <label for="nama_lengkap"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                            Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $pegawai->nama_lengkap }}"
                            class="h-11 w-full rounded-lg border bg-gray-100 dark:bg-gray-800 px-4 py-2.5 text-sm cursor-not-allowed border-gray-300 dark:border-gray-700"
                            readonly disabled />
                    </div>

                    {{-- 2. Form sisanya tetap bisa diedit --}}
                    <div>
                        <label for="nik"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NIK<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik', $pegawai->nik) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nik') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Masukkan 16 digit NIK pegawai" />
                        @error('nik')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="alamat"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Alamat<span
                                class="text-error-500">*</span></label>
                        <textarea id="alamat" name="alamat" rows="3"
                            class="w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('alamat') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Masukkan alamat lengkap pegawai">{{ old('alamat', $pegawai->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_telepon"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Telepon<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon', $pegawai->no_telepon) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('no_telepon') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: 081234567890" />
                        @error('no_telepon')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jabatan"
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jabatan<span
                                class="text-error-500">*</span></label>
                        <input type="text" id="jabatan" name="jabatan"
                            value="{{ old('jabatan', $pegawai->jabatan) }}"
                            class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('jabatan') border-error-300 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Contoh: Staf Pendaftaran, Dokter Umum" />
                        @error('jabatan')
                            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('pegawai.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
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
