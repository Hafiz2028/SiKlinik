<x-app-layout>
    <div class="p-4 mx-auto max-w-7xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Pemeriksaan Pasien` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6"
            x-data="pemeriksaanManager()">

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">Terdapat kesalahan pada input Anda:</p>
                    <ul class="list-disc list-inside mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <x-alert type="error" :message="session('error')" />

            <!-- Informasi Pasien -->
            <div class="mb-6 rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Data Pasien</h3>
                    <span
                        class="mt-2 sm:mt-0 px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">{{ $kunjungan->status_kunjungan }}</span>
                </div>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Nama Pasien</p>
                        <p class="font-semibold text-gray-800 dark:text-white/90">{{ $kunjungan->pasien->nama_pasien }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">No. Rekam Medis</p>
                        <p class="font-semibold text-gray-800 dark:text-white/90">
                            {{ $kunjungan->pasien->no_rekam_medis }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800 dark:text-white/90">
                            {{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->isoFormat('D MMMM Y') }}</p>
                    </div>
                    <div class="sm:col-span-2 md:col-span-3">
                        <p class="text-gray-500 dark:text-gray-400">Keluhan Utama</p>
                        <p class="font-semibold text-gray-800 dark:text-white/90">{{ $kunjungan->keluhan_utama ?: '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('pemeriksaan.update', $kunjungan) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Diagnosis -->
                <div class="mb-6 rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                    <label for="diagnosis"
                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis" rows="4"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('diagnosis') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                        placeholder="Masukkan hasil diagnosis dokter...">{{ old('diagnosis', $kunjungan->diagnosis) }}</textarea>
                    @error('diagnosis')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Tindakan Medis -->
                <div class="mb-6 rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Tindakan Medis</h4>
                    <div class="flex flex-col sm:flex-row sm:items-end sm:gap-4">
                        <div class="flex-grow">
                            <label for="tindakan_select"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pilih
                                Tindakan</label>
                            <div class="relative z-20 bg-transparent">
                                <select id="tindakan_select" x-model="selectedTindakanId"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 "
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true">
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">--
                                        Pilih --</option>
                                    @foreach ($tindakans as $tindakan)
                                        <option value="{{ $tindakan->id }}"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            {{ $tindakan->nama_tindakan }}
                                            ({{ 'Rp ' . number_format($tindakan->harga, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-10 -translate-y-1/2 text-gray-500 dark:text-gray-400"><svg
                                        class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg></span>
                            </div>
                        </div>
                        <button type="button" @click="addTindakan"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 dark:focus:ring-gray-800">Tambah</button>
                    </div>
                    <!-- Daftar Tindakan Terpilih -->
                    <div class="mt-4 space-y-2">
                        <template x-for="(tindakan, index) in selectedTindakans" :key="index">
                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg dark:bg-gray-800">
                                <input type="hidden" name="tindakans[]" :value="tindakan.id">
                                <span class="text-sm text-gray-800 dark:text-white/90"
                                    x-text="tindakan.nama_tindakan"></span>
                                <button type="button" @click="removeTindakan(index)"
                                    class="text-red-500 hover:text-red-700 font-bold text-lg px-2">&times;</button>
                            </div>
                        </template>
                        <p x-show="selectedTindakans.length === 0"
                            class="text-sm text-center text-gray-500 py-2 dark:text-gray-400">Belum ada tindakan yang
                            ditambahkan.</p>
                    </div>
                </div>

                <!-- Resep Obat -->
                <div class="mb-6 rounded-lg border border-gray-200 p-5 dark:border-gray-800">
                    <h4 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Resep Obat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-5">
                            <label for="obat_select"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pilih
                                Obat</label>
                            <div class="relative">
                                <select id="obat_select" x-model="selectedObatId"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true">>
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">--
                                        Pilih --</option>
                                    @foreach ($obats as $obat)
                                        <option class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                            value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok:
                                            {{ $obat->stok }})</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-10 -translate-y-1/2 text-gray-500 dark:text-gray-400"><svg
                                        class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg></span>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label for="obat_jumlah"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah</label>
                            <input type="number" id="obat_jumlah" x-model.number="obatJumlah" min="1"
                                class="h-11 w-full dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30          focus:ring-2 focus:outline-none  ">
                        </div>
                        <div class="md:col-span-4">
                            <label for="obat_dosis"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Dosis</label>
                            <input type="text" id="obat_dosis" x-model="obatDosis"
                                class="h-11 w-full dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30          focus:ring-2 focus:outline-none  "
                                placeholder="Contoh: 3x1 sehari">
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" @click="addObat"
                                class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 dark:focus:ring-gray-800">Tambah</button>
                        </div>
                    </div>
                    <!-- Daftar Obat Terpilih -->
                    <div class="mt-4 space-y-2">
                        <template x-for="(obat, index) in selectedObats" :key="index">
                            <div
                                class="grid grid-cols-12 gap-4 items-center p-2 bg-gray-50 rounded-lg dark:bg-gray-800">
                                <input type="hidden" :name="`obats[${index}][id]`" :value="obat.id">
                                <input type="hidden" :name="`obats[${index}][jumlah]`" :value="obat.jumlah">
                                <input type="hidden" :name="`obats[${index}][dosis]`" :value="obat.dosis">
                                <span class="col-span-5 text-sm text-gray-800 dark:text-white/90"
                                    x-text="obat.nama_obat"></span>
                                <span class="col-span-2 text-sm text-gray-600 dark:text-gray-400"
                                    x-text="`Jml: ${obat.jumlah}`"></span>
                                <span class="col-span-4 text-sm text-gray-600 dark:text-gray-400"
                                    x-text="`Dosis: ${obat.dosis}`"></span>
                                <div class="col-span-1 text-right">
                                    <button type="button" @click="removeObat(index)"
                                        class="text-red-500 hover:text-red-700 font-bold text-lg px-2">&times;</button>
                                </div>
                            </div>
                        </template>
                        <p x-show="selectedObats.length === 0"
                            class="text-sm text-center text-gray-500 py-2 dark:text-gray-400">Belum ada obat yang
                            diresepkan.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('kunjungan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Batal</a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Simpan
                        Hasil Pemeriksaan</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .form-input,
            .form-textarea {
                @apply shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30;
            }

            .form-select {
                @apply shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30;
            }

            .form-textarea {
                @apply h-auto;
            }

            .btn-primary {
                @apply inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800;
            }

            .btn-secondary {
                @apply inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function pemeriksaanManager() {
                return {
                    allTindakans: @json($tindakans),
                    allObats: @json($obats),
                    selectedTindakanId: '',
                    // --- PERBAIKAN FINAL DI SINI ---
                    selectedTindakans: @json($selectedTindakansData),
                    selectedObatId: '',
                    obatJumlah: 1,
                    obatDosis: '',
                    // --- PERBAIKAN FINAL DI SINI ---
                    selectedObats: @json($selectedObatsData),

                    addTindakan() {
                        if (!this.selectedTindakanId) return;
                        const exists = this.selectedTindakans.some(t => t.id == this.selectedTindakanId);
                        if (exists) {
                            alert('Tindakan sudah ditambahkan.');
                            return;
                        }
                        const tindakan = this.allTindakans.find(t => t.id == this.selectedTindakanId);
                        if (tindakan) this.selectedTindakans.push(tindakan);
                        this.selectedTindakanId = '';
                    },
                    removeTindakan(index) {
                        this.selectedTindakans.splice(index, 1);
                    },
                    addObat() {
                        if (!this.selectedObatId || !this.obatJumlah || !this.obatDosis) {
                            alert('Silakan pilih obat, isi jumlah, dan dosis.');
                            return;
                        }
                        const exists = this.selectedObats.some(o => o.id == this.selectedObatId);
                        if (exists) {
                            alert('Obat sudah diresepkan.');
                            return;
                        }
                        const obat = this.allObats.find(o => o.id == this.selectedObatId);
                        if (obat) {
                            if (obat.stok < this.obatJumlah) {
                                alert(`Stok ${obat.nama_obat} tidak mencukupi. Sisa stok: ${obat.stok}`);
                                return;
                            }
                            this.selectedObats.push({
                                id: obat.id,
                                nama_obat: obat.nama_obat,
                                jumlah: this.obatJumlah,
                                dosis: this.obatDosis
                            });
                        }
                        this.selectedObatId = '';
                        this.obatJumlah = 1;
                        this.obatDosis = '';
                    },
                    removeObat(index) {
                        this.selectedObats.splice(index, 1);
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
