<x-app-layout>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-partials.metric-card icon="pasien" title="Kunjungan Hari Ini" :value="$kunjunganHariIni"
                bg="from-sky-500 to-blue-600" textColor="text-white" />
            <x-partials.metric-card icon="total-pasien" title="Total Pasien" :value="$totalPasien"
                bg="from-green-500 to-emerald-600" textColor="text-white" />
            <x-partials.metric-card icon="pendapatan" title="Pendapatan Hari Ini"
                value="Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}" bg="from-amber-500 to-yellow-500"
                textColor="text-white" />
            <x-partials.metric-card icon="obat" title="Obat Hampir Habis" :value="$obatHampirHabis"
                bg="from-rose-500 to-pink-600" textColor="text-white" />
        </div>

        {{-- Charts & Tables --}}
        <div class="mt-6 grid grid-cols-12 gap-6">

            {{-- Tren Kunjungan --}}
            <div class="col-span-12 xl:col-span-8">
                <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-md">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tren Kunjungan</h4>
                    <div id="chart-kunjungan"></div>
                </div>
            </div>

            {{-- Tindakan Terbanyak --}}
            <div class="col-span-12 xl:col-span-4">
                <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-md">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tindakan Terbanyak</h4>
                    <div id="chart-tindakan"></div>
                </div>
            </div>

            {{-- Obat Terlaris --}}
            <div class="col-span-12 xl:col-span-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-md">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Obat Paling Sering Diresepkan
                    </h4>
                    <div id="chart-obat"></div>
                </div>
            </div>

            {{-- Kunjungan Terbaru --}}
            <div class="col-span-12 xl:col-span-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-md">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Kunjungan Terbaru</h4>
                    <div class="space-y-3">
                        @forelse($kunjunganTerbaru as $kunjungan)
                            <div
                                class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div>
                                    <h5 class="font-medium text-gray-800 dark:text-white">
                                        {{ $kunjungan->pasien->nama_pasien }}</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-300">{{ $kunjungan->kode_kunjungan }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full
                                        @switch($kunjungan->status_kunjungan)
                                            @case('Menunggu') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @break
                                            @case('Diperiksa') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @break
                                            @case('Menunggu Pembayaran') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 @break
                                            @case('Selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @break
                                            @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @break
                                        @endswitch">
                                        {{ $kunjungan->status_kunjungan }}
                                    </span>
                                    @if ($kunjungan->status_kunjungan === 'Selesai' && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('petugas-pendaftaran') || auth()->user()->hasRole('kasir')))
                                        <a href="{{ url('/transaksi/kunjungan/' . $kunjungan->id) }}"
                                            class="flex items-center gap-1 px-2 py-1 bg-sky-500 text-white rounded-md text-xs hover:bg-sky-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-8-4a1 1 0 100 2 1 1 0 000-2zm1 4H9v5h2v-5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-300 py-4">Belum ada data kunjungan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            const labelsKunjungan = @json($labelsKunjungan);
            const dataKunjungan = @json($dataKunjungan);
            const labelsTindakan = @json($labelsTindakan);
            const dataTindakan = @json($dataTindakan);
            const labelsObat = @json($labelsObat);
            const dataObat = @json($dataObat);

            // Chart Tren Kunjungan
            new ApexCharts(document.querySelector("#chart-kunjungan"), {
                series: [{
                    name: 'Kunjungan',
                    data: dataKunjungan
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                markers: {
                    size: 4,
                    colors: ['#2563EB'],
                    strokeColors: '#fff',
                    strokeWidth: 2
                },
                xaxis: {
                    categories: labelsKunjungan
                },
                colors: ['#3B82F6']
            }).render();

            // Chart Tindakan Terbanyak
            new ApexCharts(document.querySelector("#chart-tindakan"), {
                series: dataTindakan,
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: labelsTindakan,
                colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total'
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                legend: {
                    position: 'bottom'
                }
            }).render();

            // Chart Obat Terlaris
            new ApexCharts(document.querySelector("#chart-obat"), {
                series: [{
                    name: 'Jumlah',
                    data: dataObat
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        distributed: true
                    }
                },
                colors: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE', '#DBEAFE'],
                xaxis: {
                    categories: labelsObat
                }
            }).render();
        </script>
    @endpush
</x-app-layout>
