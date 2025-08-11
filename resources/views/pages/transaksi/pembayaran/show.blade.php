<x-app-layout>
    <div class="p-4 mx-auto max-w-4xl md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Detail Tagihan` }">
            <x-partials.breadcrumb />
        </div>
        <!-- Breadcrumb End -->

        <div
            class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Tagihan Kunjungan</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $kunjungan->kode_kunjungan }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span class="px-3 py-1 text-sm font-medium rounded-full"
                        :class="{
                            'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300': '{{ $kunjungan->status_kunjungan }}'
                            === 'Menunggu Pembayaran',
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': '{{ $kunjungan->status_kunjungan }}'
                            === 'Selesai',
                        }">
                        {{ $kunjungan->status_kunjungan }}
                    </span>
                </div>
            </div>

            <hr class="my-6 dark:border-gray-800">

            <!-- Detail Pasien & Kunjungan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">Pasien</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $kunjungan->pasien->nama_pasien }}</p>
                    <p class="text-gray-500 dark:text-gray-500 text-xs">{{ $kunjungan->pasien->no_rekam_medis }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">Dokter</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $kunjungan->dokter->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">Tanggal Kunjungan</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->isoFormat('D MMMM Y') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">Diagnosis</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $kunjungan->diagnosis ?: '-' }}</p>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="mt-8">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Rincian Biaya</h3>
                <div class="mt-4 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white/90 sm:pl-0">
                                            Item</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white/90">
                                            Harga</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                    @foreach ($kunjungan->tindakan as $tindakan)
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white/90 sm:pl-0">
                                                {{ $tindakan->nama_tindakan }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 text-right">Rp
                                                {{ number_format($tindakan->pivot->harga_saat_transaksi, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($kunjungan->obat as $obat)
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white/90 sm:pl-0">
                                                {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }}
                                                {{ $obat->satuan }})</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 text-right">Rp
                                                {{ number_format($obat->pivot->harga_saat_transaksi * $obat->pivot->jumlah, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row"
                                            class="pt-4 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white/90 sm:pl-0">
                                            Total Tagihan</th>
                                        <td
                                            class="pt-4 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 dark:text-white/90 sm:pr-0">
                                            Rp {{ number_format($kunjungan->total_tagihan, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi Pembayaran -->
            @if ($kunjungan->status_kunjungan == 'Menunggu Pembayaran')
                <div class="mt-8 border-t border-gray-200 dark:border-gray-800 pt-6">
                    <form action="{{ route('pembayaran.update', $kunjungan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="konfirmasi" value="1">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('kunjungan.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">Konfirmasi
                                Pembayaran</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
