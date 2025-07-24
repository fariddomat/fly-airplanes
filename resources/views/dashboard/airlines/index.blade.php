<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Airline</h1>
        <a href="{{ route('dashboard.airlines.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Airline</a>

        <div class="overflow-x-auto mt-4">
            <x-autocrud::table
                :columns="['id', 'airline_name', 'airline_code']"
                :data="$airlines"
                routePrefix="dashboard.airlines"
                :show="true"
                :edit="true"
                :delete="true"
                :restore="true"
            />
        </div>
    </div>
</x-app-layout>