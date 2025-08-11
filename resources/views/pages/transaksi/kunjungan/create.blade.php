<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Daftarkan Kunjungan Baru` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6"
            x-data="formPendaftaran()">
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
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p>Terjadi kesalahan saat mengisi form:</p>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kunjungan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipe_pasien" x-model="tipePasien">

                <!-- Navigasi Tipe Pasien -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <a href="#" @click.prevent="tipePasien = 'lama'"
                                class="inline-block p-4 border-b-2 rounded-t-lg" :class="tabClass('lama')">Pasien
                                Lama
                                (Terdaftar)</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="tipePasien = 'baru'"
                                class="inline-block p-4 border-b-2 rounded-t-lg" :class="tabClass('baru')">Pasien
                                Baru</a>
                        </li>
                    </ul>
                </div>

                <!-- Bagian Detail Kunjungan -->
                <div class="rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Detail Kunjungan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tanggal Kunjungan<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan"
                                    value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" placeholder="Select date"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('tanggal_kunjungan') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                    onclick="this.showPicker()" />
                                <span
                                    class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                                            fill="" />
                                    </svg>
                                </span>
                                @error('tanggal_kunjungan')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="jenis_kunjungan_id"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Jenis Kunjungan<span class="text-red-500">*</span>
                            </label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                <select id="jenis_kunjungan_id" name="jenis_kunjungan_id"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('jenis_kunjungan_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true">
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                        Pilih Jenis Kunjungan
                                    </option>
                                    @foreach ($jenisKunjungans as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                            {{ old('jenis_kunjungan_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                @error('jenis_kunjungan_id')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="dokter_id"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Dokter<span class="text-red-500">*</span>
                            </label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                <select id="dokter_id" name="dokter_id"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('dokter_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true">
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                        Pilih Dokter
                                    </option>
                                    @foreach ($dokters as $dokter)
                                        <option value="{{ $dokter->id }}"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                            {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                            {{ $dokter->name }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                @error('dokter_id')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <!-- Form untuk Pasien Lama -->
                    <div x-show="tipePasien === 'lama'" x-transition>
                        @include('pages.transaksi.kunjungan.partials.form-pasien-lama')
                    </div>

                    <!-- Form untuk Pasien Baru -->
                    <div x-show="tipePasien === 'baru'" x-transition style="display: none;">
                        @include('pages.transaksi.kunjungan.partials.form-pasien-baru')
                    </div>
                </div>

                <!-- Keluhan & Tombol Submit -->
                <div class="mt-6 rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Keluhan Pasien</h4>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Keluhan Utama
                    </label>
                    <textarea id="keluhan_utama" name="keluhan_utama" rows="6"
                        placeholder="Masukkan keluhan utama pasien (jika ada)..." type="text"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('keluhan_utama') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">{{ old('keluhan_utama') }}</textarea>
                    @error('keluhan_utama')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('kunjungan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Batal</a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Simpan
                        Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
        <script>
            function formPendaftaran() {
                return {
                    tipePasien: '{{ old('tipe_pasien', 'lama') }}',
                    allPasiens: @json($pasiens),
                    search: '',
                    selectedPasienId: '{{ old('pasien_id') }}',

                    get filteredPasiens() {
                        if (this.search === '') return [];
                        return this.allPasiens.filter(p =>
                            p.nama_pasien.toLowerCase().includes(this.search.toLowerCase()) ||
                            p.no_rekam_medis.toLowerCase().includes(this.search.toLowerCase())
                        ).slice(0, 5);
                    },

                    get selectedPasien() {
                        if (!this.selectedPasienId) return null;
                        return this.allPasiens.find(p => p.id == this.selectedPasienId);
                    },

                    selectPasien(pasienId) {
                        this.selectedPasienId = pasienId;
                        this.search = '';
                    },

                    calculateAge(tanggalLahir) {
                        if (!tanggalLahir) return '';
                        const birthDate = new Date(tanggalLahir);
                        const today = new Date();
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const m = today.getMonth() - birthDate.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
                        return age + ' tahun';
                    },

                    tabClass(tabName) {
                        return {
                            'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500': this.tipePasien ===
                                tabName,
                            'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': this
                                .tipePasien !== tabName
                        };
                    }
                }
            }

            // Script untuk dropdown wilayah dinamis
            document.addEventListener('DOMContentLoaded', function() {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) return;
                const csrfToken = csrfTokenMeta.getAttribute('content');

                const provinsiSelect = document.getElementById('provinsi_id');
                const kabupatenSelect = document.getElementById('kabupaten_id');
                const kecamatanSelect = document.getElementById('kecamatan_id');

                if (!provinsiSelect) return;

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
                        if (!response.ok) throw new Error('Network response was not ok');
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
                    const provinsiId = this.value;
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
            });
        </script>
    @endpush
</x-app-layout>
