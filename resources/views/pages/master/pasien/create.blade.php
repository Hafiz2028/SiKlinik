<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Tambah Pasien` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">

            <!-- Menampilkan pesan error atau sukses global -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf

                <h3
                    class="text-base font-medium text-gray-800 dark:text-white/90 border-b border-gray-200 dark:border-gray-800 pb-3 mb-6">
                    Form Tambah Pasien Baru
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        {{-- No Rekam Medis --}}
                        <div>
                            <label for="no_rekam_medis"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No. Rekam
                                Medis</label>
                            <input type="text" id="no_rekam_medis" name="no_rekam_medis" value="{{ $noRekamMedis }}"
                                readonly
                                class="h-11 w-full rounded-lg border bg-gray-200 dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 border-gray-300 dark:border-gray-700" />
                        </div>

                        {{-- Nama Pasien --}}
                        <div>
                            <label for="nama_pasien"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                Pasien<span class="text-red-500">*</span></label>
                            <input type="text" id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}"
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nama_pasien') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                placeholder="Masukkan nama lengkap pasien" />
                            @error('nama_pasien')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label for="nik"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NIK<span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('nik') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                placeholder="Masukkan 16 digit NIK" />
                            @error('nik')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <label for="tempat_lahir"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tempat
                                Lahir<span class="text-red-500">*</span></label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir') }}"
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('tempat_lahir') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                placeholder="Masukkan kota tempat lahir" />
                            @error('tempat_lahir')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label for="tanggal_lahir"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal
                                Lahir<span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('tanggal_lahir') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror" />
                            @error('tanggal_lahir')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis
                                Kelamin<span class="text-red-500">*</span></label>
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
                        {{-- Provinsi --}}
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
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kabupaten/Kota --}}
                        <div>
                            <label for="kabupaten_id"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kabupaten/Kota<span
                                    class="text-red-500">*</span></label>
                            <select id="kabupaten_id" name="kabupaten_id" disabled
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 disabled:bg-gray-200 dark:disabled:bg-gray-800 @error('kabupaten_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            @error('kabupaten_id')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="kecamatan_id"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kecamatan<span
                                    class="text-red-500">*</span></label>
                            <select id="kecamatan_id" name="kecamatan_id" disabled
                                class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 disabled:bg-gray-200 dark:disabled:bg-gray-800 @error('kecamatan_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            @error('kecamatan_id')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Alamat
                                Lengkap<span class="text-red-500">*</span></label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:outline-none dark:bg-gray-900 dark:text-white/90 @error('alamat') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label for="no_telepon"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No.
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

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('pasien.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Batal
                    </a>
                    <button type="submit" name="action" value="save_and_new"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Simpan & Tambah Baru
                    </button>
                    <button type="submit" name="action" value="save"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Simpan Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // --- DEBUGGING POINT 1 ---
                console.log('Script loaded and DOM is ready.');

                const provinsiSelect = document.getElementById('provinsi_id');
                const kabupatenSelect = document.getElementById('kabupaten_id');
                const kecamatanSelect = document.getElementById('kecamatan_id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // --- DEBUGGING POINT 2 ---
                // Periksa apakah elemen ditemukan
                if (!provinsiSelect) {
                    console.error('Error: Element with ID "provinsi_id" not found!');
                    return; // Hentikan eksekusi jika elemen tidak ada
                }
                console.log('Element "provinsi_id" found:', provinsiSelect);


                async function fetchData(url, bodyData, targetSelect, placeholder) {
                    targetSelect.innerHTML = `<option value="">Memuat...</option>`;
                    targetSelect.disabled = true;

                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(bodyData)
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        targetSelect.innerHTML = `<option value="">${placeholder}</option>`;
                        data.forEach(item => {
                            targetSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                        });
                        targetSelect.disabled = false;

                    } catch (error) {
                        console.error('Fetch error:', error);
                        targetSelect.innerHTML = `<option value="">Gagal memuat data</option>`;
                    }
                }

                provinsiSelect.addEventListener('change', function() {
                    // --- DEBUGGING POINT 3 ---
                    console.log('Provinsi dropdown changed!');

                    const provinsiId = this.value;

                    // --- DEBUGGING POINT 4 ---
                    console.log('Selected Provinsi ID:', provinsiId);

                    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    kecamatanSelect.disabled = true;

                    if (provinsiId) {
                        fetchData('{{ route('get.kabupaten') }}', {
                            provinsi_id: provinsiId
                        }, kabupatenSelect, 'Pilih Kabupaten/Kota');
                    } else {
                        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                        kabupatenSelect.disabled = true;
                    }
                });

                kabupatenSelect.addEventListener('change', function() {
                    const kabupatenId = this.value;
                    if (kabupatenId) {
                        fetchData('{{ route('get.kecamatan') }}', {
                            kabupaten_id: kabupatenId
                        }, kecamatanSelect, 'Pilih Kecamatan');
                    } else {
                        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        kecamatanSelect.disabled = true;
                    }
                });

                // Menjaga nilai lama (old value) jika terjadi error validasi
                const oldProvinsi = "{{ old('provinsi_id') }}";
                if (oldProvinsi) {
                    provinsiSelect.value = oldProvinsi;
                    // Secara manual memicu event 'change' agar kabupaten dimuat
                    provinsiSelect.dispatchEvent(new Event('change'));

                    // Script tambahan untuk menangani old value kabupaten & kecamatan
                    const oldKabupaten = "{{ old('kabupaten_id') }}";
                    const oldKecamatan = "{{ old('kecamatan_id') }}";

                    // Kita perlu menunggu kabupaten selesai dimuat sebelum memilihnya
                    setTimeout(() => {
                        if (oldKabupaten) {
                            kabupatenSelect.value = oldKabupaten;
                            kabupatenSelect.dispatchEvent(new Event('change'));

                            setTimeout(() => {
                                if (oldKecamatan) {
                                    kecamatanSelect.value = oldKecamatan;
                                }
                            }, 500); // Beri jeda lagi untuk kecamatan
                        }
                    }, 500); // Beri jeda 500ms
                }
            });
        </script>
    @endpush
</x-app-layout>
