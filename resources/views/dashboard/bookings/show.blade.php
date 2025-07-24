<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.bookings')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <p class="text-gray-900">
                    @isset($booking->user)
                        {{ $booking->user->name ?? '—' }}
                    @else
                        {{ $booking->user_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.flight_id')</label>
                <p class="text-gray-900">
                    @isset($booking->flight)
                        {{ $booking->flight->name ?? '—' }}
                    @else
                        {{ $booking->flight_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.num_passengers')</label>
                <p class="text-gray-900">{{ $booking->num_passengers ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <p class="text-gray-900">{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <p class="text-gray-900">{{ $booking->total_price ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <p class="text-gray-900">{{ $booking->status ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.bookings.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>