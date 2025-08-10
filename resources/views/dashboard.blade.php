<x-app-layout>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">
                <x-partials.metric-group.metric-group-01 />
                <x-partials.chart.chart-01 />
            </div>
            <div class="col-span-12 xl:col-span-5">
                <x-partials.chart.chart-02 />
            </div>
            <div class="col-span-12">
                <x-partials.chart.chart-03 />
            </div>
            <div class="col-span-12 xl:col-span-5">
                <x-partials.map-01 />
            </div>
            <div class="col-span-12 xl:col-span-7">
                <x-partials.table.table-01 />
            </div>
        </div>
    </div>
</x-app-layout>
