<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.flights')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airline_id')</label>
                <p class="text-gray-900">
                    @isset($flight->airline)
                        {{ $flight->airline->name ?? '—' }}
                    @else
                        {{ $flight->airline_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.departure_airport_id')</label>
                <p class="text-gray-900">
                    @isset($flight->departureAirport)
                        {{ $flight->departureAirport->name ?? '—' }}
                    @else
                        {{ $flight->departure_airport_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.arrival_airport_id')</label>
                <p class="text-gray-900">
                    @isset($flight->arrivalAirport)
                        {{ $flight->arrivalAirport->name ?? '—' }}
                    @else
                        {{ $flight->arrival_airport_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.departure_time')</label>
                <p class="text-gray-900">{{ $flight->departure_time ? $flight->departure_time->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.arrival_time')</label>
                <p class="text-gray-900">{{ $flight->arrival_time ? $flight->arrival_time->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.flight_number')</label>
                <p class="text-gray-900">{{ $flight->flight_number ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price')</label>
                <p class="text-gray-900">{{ $flight->price ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.available_seats')</label>
                <p class="text-gray-900">{{ $flight->available_seats ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.class')</label>
                <p class="text-gray-900">{{ $flight->class ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.duration')</label>
                <p class="text-gray-900">{{ $flight->duration ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.stops')</label>
                <p class="text-gray-900">{{ $flight->stops ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.amenities')</label>
                <p class="text-gray-900">{{ $flight->amenities ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.flights.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>