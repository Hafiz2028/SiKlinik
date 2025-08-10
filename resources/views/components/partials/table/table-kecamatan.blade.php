@props(['kecamatans'])

<table class="min-w-full">
    <thead>
        <tr class="border-gray-100 border-y dark:border-gray-800">
            <th class="px-4 py-3 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kecamatan</p>
            </th>
            <th class="px-4 py-3 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kabupaten/Kota</p>
            </th>
            <th class="px-4 py-3 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Provinsi</p>
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($kecamatans as $kecamatan)
            <tr>
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $kecamatan->nama }}</p>
                </td>
                <td class="px-4 py-3">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $kecamatan->kabupaten->nama ?? 'N/A' }}
                    </p>
                </td>
                <td class="px-4 py-3">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                        {{ $kecamatan->kabupaten->provinsi->nama ?? 'N/A' }}</p>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- Perbaikan Pagination: Menambahkan parameter query yang ada --}}
<div class="mt-4">{{ $kecamatans->appends(request()->query())->links() }}</div>
