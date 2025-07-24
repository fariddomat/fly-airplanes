<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.cars')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rentalcompany_id')</label>
                <p class="text-gray-900">
                    @isset($car->rentalcompany)
                        {{ $car->rentalcompany->name ?? '—' }}
                    @else
                        {{ $car->rentalcompany_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_model')</label>
                <p class="text-gray-900">{{ $car->car_model ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_make')</label>
                <p class="text-gray-900">{{ $car->car_make ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_year')</label>
                <p class="text-gray-900">{{ $car->car_year ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.cars.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>