@props(['provinsis'])

<table class="min-w-full">
    <thead>
        <tr class="border-gray-100 border-y dark:border-gray-800">
            <th class="px-4 py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p></th>
            <th class="px-4 py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Provinsi</p></th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($provinsis as $provinsi)
            <tr>
                <td class="px-4 py-3"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $provinsi->id }}</p></td>
                <td class="px-4 py-3"><p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $provinsi->nama }}</p></td>
            </tr>
        @empty
            <tr><td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data.</td></tr>
        @endforelse
    </tbody>
</table>
{{-- Perbaikan Pagination: Menambahkan parameter query yang ada --}}
<div class="mt-4">{{ $provinsis->appends(request()->query())->links() }}</div>
