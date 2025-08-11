<div class="rounded-lg border border-gray-200 p-5 dark:border-gray-800">
    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-6">
        Formulir Pasien Baru
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri -->
        <div class="space-y-6">
            <div>
                <label for="nama_pasien" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                    Pasien<span class="text-red-500">*</span></label>
                <input type="text" id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nama_pasien') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                    placeholder="Masukkan nama lengkap pasien" />
                @error('nama_pasien')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="nik" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NIK<span
                        class="text-red-500">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nik') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                    placeholder="Masukkan 16 digit NIK" />
                @error('nik')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tempat_lahir"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tempat Lahir<span
                        class="text-red-500">*</span></label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('tempat_lahir') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                    placeholder="Masukkan kota tempat lahir" />
                @error('tempat_lahir')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tanggal_lahir"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Lahir<span
                        class="text-red-500">*</span></label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('tanggal_lahir') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror" />
                @error('tanggal_lahir')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="jenis_kelamin"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis Kelamin<span
                        class="text-red-500">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('jenis_kelamin') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <!-- Kolom Kanan -->
        <div class="space-y-6">
            <div>
                <label for="provinsi_id"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Provinsi<span
                        class="text-red-500">*</span></label>
                <select id="provinsi_id" name="provinsi_id"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('provinsi_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                    <option value="">Pilih Provinsi</option>
                    @foreach ($provinsis as $provinsi)
                        <option value="{{ $provinsi->id }}"
                            {{ old('provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                            {{ $provinsi->nama }}</option>
                    @endforeach
                </select>
                @error('provinsi_id')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kabupaten_id"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kabupaten/Kota<span
                        class="text-red-500">*</span></label>
                <select id="kabupaten_id" name="kabupaten_id" disabled
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 disabled:bg-gray-200 dark:disabled:bg-gray-800 @error('kabupaten_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
                @error('kabupaten_id')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kecamatan_id"
                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kecamatan<span
                        class="text-red-500">*</span></label>
                <select id="kecamatan_id" name="kecamatan_id" disabled
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 disabled:bg-gray-200 dark:disabled:bg-gray-800 @error('kecamatan_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                    <option value="">Pilih Kecamatan</option>
                </select>
                @error('kecamatan_id')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="alamat" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Alamat
                    Lengkap<span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('alamat') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="no_telepon" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No.
                    Telepon</label>
                <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                    class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('no_telepon') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                    placeholder="Contoh: 081234567890" />
                @error('no_telepon')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
