<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Flight</h1>
        <a href="{{ route('dashboard.flights.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Flight</a>

        <div class="overflow-x-auto mt-4">
            <x-autocrud::table
                :columns="['id', 'airline.name', 'departure_airport.airport_name', 'arrival_airport.airport_name', 'departure_time']"
                :data="$flights"
                routePrefix="dashboard.flights"
                :show="true"
                :edit="true"
                :delete="true"
                :restore="true"
            />
        </div>
    </div>
</x-app-layout>
