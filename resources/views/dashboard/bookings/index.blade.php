<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Booking</h1>
        <a href="{{ route('dashboard.bookings.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Booking</a>

       <div class="overflow-x-auto mt-4">
    <x-autocrud::table
        :columns="['id', 'user.name', 'flight.flight_number', 'status']"
        :data="$bookings"
        routePrefix="dashboard.bookings"
        :show="true"
        :edit="true"
        :delete="true"
        :restore="true"
        :searchable="true"
        :sortable="true"
        :filterable="['confirmed' => 'Confirmed', 'pending' => 'Pending', 'cancelled' => 'Cancelled']"
        :perPageOptions="[10, 25, 50, 100]"
        :exportable="true"
    />
</div>
    </div>
</x-app-layout>
