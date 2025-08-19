<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Booking</h1>
        @if (!Auth::user()->hasRole('user'))
        <a href="{{ route('dashboard.bookings.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Booking</a>
        @endif
        <div class="overflow-x-auto mt-4">
            @if (Auth::user()->hasRole('user'))
<x-autocrud::table
                :columns="['id', 'user.name', 'booking_date', 'status']"
                :data="$bookings"
                routePrefix="dashboard.bookings"
                :show="true"
                :edit="false"
                :delete="false"
                :restore="false"
            />
            @else
            <x-autocrud::table
                :columns="['id', 'user.name', 'booking_date', 'status']"
                :data="$bookings"
                routePrefix="dashboard.bookings"
                :show="true"
                :edit="true"
                :delete="true"
                :restore="true"
            />
            @endif
        </div>
    </div>
</x-app-layout>
