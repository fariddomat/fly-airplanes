<!-- resources/views/dashboard/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @lang('site.dashboard')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">@lang('site.welcome') {{ auth()->user()->name }}</h3>

                    <!-- User Role Dashboard -->
                    @role('user')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.flight_bookings')</h4>
                                <p class="text-3xl">{{ $total_bookings }}</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.car_rentals')</h4>
                                <p class="text-3xl">{{ $total_carrentals }}</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.hotel_bookings')</h4>
                                <p class="text-3xl">{{ $total_hotelbookings }}</p>
                            </div>
                        </div>

                        <!-- Recent Bookings -->
                        <div class="mt-8">
                            <h4 class="text-xl font-semibold mb-4">@lang('site.recent_bookings')</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Type</th>
                                            <th class="py-3 px-6 text-left">Details</th>
                                            <th class="py-3 px-6 text-left">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 dark:text-gray-100 text-sm font-light">
                                        @foreach ($recent_bookings as $booking)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="py-3 px-6 text-left">
                                                    {{ class_basename($booking) }}
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    @if ($booking instanceof \App\Models\Booking)
                                                        Flight: {{ $booking->flight->name ?? 'N/A' }}
                                                    @elseif ($booking instanceof \App\Models\Carrental)
                                                        Car: {{ $booking->car->name ?? 'N/A' }}
                                                    @elseif ($booking instanceof \App\Models\Hotelbooking)
                                                        Hotel: {{ $booking->hotel->name ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    {{ $booking->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endrole

                    <!-- Administrator and Superadministrator Dashboard -->
                    @role('administrator|superadministrator')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.airports')</h4>
                                <p class="text-3xl">{{ $total_airports }}</p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.airlines')</h4>
                                <p class="text-3xl">{{ $total_airlines }}</p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.flights')</h4>
                                <p class="text-3xl">{{ $total_flights }}</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.bookings')</h4>
                                <p class="text-3xl">{{ $total_bookings }}</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.rental_companies')</h4>
                                <p class="text-3xl">{{ $total_rentalcompanies }}</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.cars')</h4>
                                <p class="text-3xl">{{ $total_cars }}</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.car_rentals')</h4>
                                <p class="text-3xl">{{ $total_carrentals }}</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.hotels')</h4>
                                <p class="text-3xl">{{ $total_hotels }}</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.hotel_bookings')</h4>
                                <p class="text-3xl">{{ $total_hotelbookings }}</p>
                            </div>
                            {{-- <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-semibold">@lang('site.adds')</h4>
                                <p class="text-3xl">{{ $total_adds }}</p>
                            </div> --}}
                            @role('superadministrator')
                                <div class="bg-red-100 dark:bg-red-900 p-4 rounded-lg shadow">
                                    <h4 class="text-lg font-semibold">@lang('site.users')</h4>
                                    <p class="text-3xl">{{ $total_users }}</p>
                                </div>
                            @endrole
                        </div>

                        <!-- Recent Bookings -->
                        <div class="mt-8">
                            <h4 class="text-xl font-semibold mb-4">@lang('site.recent_bookings')</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Type</th>
                                            <th class="py-3 px-6 text-left">Details</th>
                                            <th class="py-3 px-6 text-left">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 dark:text-gray-100 text-sm font-light">
                                        @foreach ($recent_bookings as $booking)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="py-3 px-6 text-left">
                                                    {{ class_basename($booking) }}
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    @if ($booking instanceof \App\Models\Booking)
                                                        Flight: {{ $booking->flight->name ?? 'N/A' }}
                                                    @elseif ($booking instanceof \App\Models\Carrental)
                                                        Car: {{ $booking->car->name ?? 'N/A' }}
                                                    @elseif ($booking instanceof \App\Models\Hotelbooking)
                                                        Hotel: {{ $booking->hotel->name ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    {{ $booking->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Users (Superadministrator Only) -->
                        @role('superadministrator')
                            <div class="mt-8">
                                <h4 class="text-xl font-semibold mb-4">@lang('site.recent_users')</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                                        <thead>
                                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                                                <th class="py-3 px-6 text-left">Name</th>
                                                <th class="py-3 px-6 text-left">Email</th>
                                                <th class="py-3 px-6 text-left">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 dark:text-gray-100 text-sm font-light">
                                            @foreach ($recent_users as $user)
                                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="py-3 px-6 text-left">{{ $user->name }}</td>
                                                    <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                                                    <td class="py-3 px-6 text-left">{{ $user->created_at->format('Y-m-d') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endrole
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
