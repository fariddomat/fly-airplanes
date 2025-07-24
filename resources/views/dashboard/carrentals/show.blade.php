<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.carrentals')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <p class="text-gray-900">
                    @isset($carrental->user)
                        {{ $carrental->user->name ?? '—' }}
                    @else
                        {{ $carrental->user_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rentalcompany_id')</label>
                <p class="text-gray-900">
                    @isset($carrental->rentalcompany)
                        {{ $carrental->rentalcompany->name ?? '—' }}
                    @else
                        {{ $carrental->rentalcompany_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_id')</label>
                <p class="text-gray-900">
                    @isset($carrental->car)
                        {{ $carrental->car->name ?? '—' }}
                    @else
                        {{ $carrental->car_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.pickup_location')</label>
                <p class="text-gray-900">{{ $carrental->pickup_location ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.return_location')</label>
                <p class="text-gray-900">{{ $carrental->return_location ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.pickup_date')</label>
                <p class="text-gray-900">{{ $carrental->pickup_date ? $carrental->pickup_date->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.return_date')</label>
                <p class="text-gray-900">{{ $carrental->return_date ? $carrental->return_date->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <p class="text-gray-900">{{ $carrental->total_price ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <p class="text-gray-900">{{ $carrental->booking_date ? $carrental->booking_date->format('Y-m-d" . (datetime === 'datetime' ? ' H:i' : '') . "') : '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <p class="text-gray-900">{{ $carrental->status ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.carrentals.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>