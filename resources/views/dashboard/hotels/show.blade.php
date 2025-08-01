<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.hotels')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.name')</label>
                <p class="text-gray-900">{{ $hotel->name ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.address')</label>
                <p class="text-gray-900">{{ $hotel->address ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.city')</label>
                <p class="text-gray-900">{{ $hotel->city ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.country')</label>
                <p class="text-gray-900">{{ $hotel->country ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.phone_number')</label>
                <p class="text-gray-900">{{ $hotel->phone_number ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.email')</label>
                <p class="text-gray-900">{{ $hotel->email ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.star_rating')</label>
                <p class="text-gray-900">{{ $hotel->star_rating ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.description')</label>
                <p class="text-gray-900">{{ $hotel->description ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price_per_night')</label>
                <p class="text-gray-900">{{ $hotel->price_per_night ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rating')</label>
                <p class="text-gray-900">{{ $hotel->rating ?? '—' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.amenities')</label>
                <pre class="text-gray-900 bg-gray-100 p-2 rounded">{{ json_encode($hotel->amenities, JSON_PRETTY_PRINT) ?? '—' }}</pre>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.image')</label>
                @isset($hotel->image)
                    <img src="{{ Storage::url($hotel->image) }}" alt="image" class="mt-2 w-48 h-48 rounded">
                @else
                    <p class="text-gray-900">—</p>
                @endisset
            </div>
            <a href="{{ route('dashboard.hotels.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>