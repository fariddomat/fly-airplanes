<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.hotelbookings')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <p class="text-gray-900">
                    @isset($hotelbooking->user)
                        {{ $hotelbooking->user->name ?? '—' }}
                    @else
                        {{ $hotelbooking->user_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.hotel_id')</label>
                <p class="text-gray-900">
                    @isset($hotelbooking->hotel)
                        {{ $hotelbooking->hotel->name ?? '—' }}
                    @else
                        {{ $hotelbooking->hotel_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.check_in_date')</label>
                <p class="text-gray-900">{{ $hotelbooking->check_in_date ? $hotelbooking->check_in_date->format('Y-m-d" . (date === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.check_out_date')</label>
                <p class="text-gray-900">{{ $hotelbooking->check_out_date ? $hotelbooking->check_out_date->format('Y-m-d" . (date === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.room_type')</label>
                <p class="text-gray-900">{{ $hotelbooking->room_type ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <p class="text-gray-900">{{ $hotelbooking->total_price ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <p class="text-gray-900">{{ $hotelbooking->booking_date ? $hotelbooking->booking_date->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <p class="text-gray-900">{{ $hotelbooking->status ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.hotelbookings.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>