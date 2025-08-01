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
                <label class="block text-sm font-medium text-gray-700">@lang('site.name')</label>
                <p class="text-gray-900">{{ $car->name ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.year')</label>
                <p class="text-gray-900">{{ $car->year ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.type')</label>
                <p class="text-gray-900">{{ $car->type ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.transmission')</label>
                <p class="text-gray-900">{{ $car->transmission ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.fuel_type')</label>
                <p class="text-gray-900">{{ $car->fuel_type ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price')</label>
                <p class="text-gray-900">{{ $car->price ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.img')</label>
                @isset($car->img)
                    <img src="{{ Storage::url($car->img) }}" alt="img" class="mt-2 w-48 h-48 rounded">
                @else
                    <p class="text-gray-900">—</p>
                @endisset
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.seats')</label>
                <p class="text-gray-900">{{ $car->seats ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.luggage_capacity')</label>
                <p class="text-gray-900">{{ $car->luggage_capacity ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.features')</label>
                <pre class="text-gray-900 bg-gray-100 p-2 rounded">{{ json_encode($car->features, JSON_PRETTY_PRINT) ?? '—' }}</pre>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rating')</label>
                <p class="text-gray-900">{{ $car->rating ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.cars.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>