<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.edit') @lang('site.dashboard.airports')
        </h1>

        <form action="{{ route('dashboard.airports.update', $airport->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airport_code')</label>
                <input type="text" name="airport_code" value="{{ old('airport_code', $airport->airport_code) }}" class="w-full border border-gray-300 rounded p-2">
                @error('airport_code')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airport_name')</label>
                <input type="text" name="airport_name" value="{{ old('airport_name', $airport->airport_name) }}" class="w-full border border-gray-300 rounded p-2">
                @error('airport_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.city')</label>
                <input type="text" name="city" value="{{ old('city', $airport->city) }}" class="w-full border border-gray-300 rounded p-2">
                @error('city')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.country')</label>
                <input type="text" name="country" value="{{ old('country', $airport->country) }}" class="w-full border border-gray-300 rounded p-2">
                @error('country')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.latitude')</label>
                <input type="text" name="latitude" value="{{ old('latitude', $airport->latitude) }}" class="w-full border border-gray-300 rounded p-2">
                @error('latitude')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.longitude')</label>
                <input type="text" name="longitude" value="{{ old('longitude', $airport->longitude) }}" class="w-full border border-gray-300 rounded p-2">
                @error('longitude')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.update')
            </button>
        </form>
    </div>
</x-app-layout>