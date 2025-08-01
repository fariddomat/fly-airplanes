<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Booking</h1>
        <a href="{{ route('dashboard.bookings.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Booking</a>

        <div class="overflow-x-auto mt-4">
            <x-autocrud::table
                :columns="['id', 'user_id', 'flight_id', 'return_flight_id', 'num_passengers', 'booking_date', 'total_price', 'status', 'trip_type', 'passenger_details']"
                :data="$bookings"
                routePrefix="dashboard.bookings"
                :show="true"
                :edit="true"
                :delete="true"
                :restore="true"
            />
        </div>
    </div>
</x-app-layout>