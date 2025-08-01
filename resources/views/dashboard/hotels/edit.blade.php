<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.edit') @lang('site.dashboard.hotels')
        </h1>

        <form action="{{ route('dashboard.hotels.update', $hotel->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.name')</label>
                <input type="text" name="name" value="{{ old('name', $hotel->name) }}" class="w-full border border-gray-300 rounded p-2">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.address')</label>
                <textarea name="address" class="w-full border border-gray-300 rounded p-2">{{ old('address', $hotel->address) }}</textarea>
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.city')</label>
                <input type="text" name="city" value="{{ old('city', $hotel->city) }}" class="w-full border border-gray-300 rounded p-2">
                @error('city')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.country')</label>
                <input type="text" name="country" value="{{ old('country', $hotel->country) }}" class="w-full border border-gray-300 rounded p-2">
                @error('country')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.phone_number')</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $hotel->phone_number) }}" class="w-full border border-gray-300 rounded p-2">
                @error('phone_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.email')</label>
                <input type="text" name="email" value="{{ old('email', $hotel->email) }}" class="w-full border border-gray-300 rounded p-2">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.star_rating')</label>
                <input type="number" name="star_rating" value="{{ old('star_rating', $hotel->star_rating) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('star_rating')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.description')</label>
                <textarea name="description" class="w-full border border-gray-300 rounded p-2">{{ old('description', $hotel->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price_per_night')</label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night', $hotel->price_per_night) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('price_per_night')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rating')</label>
                <input type="number" name="rating" value="{{ old('rating', $hotel->rating) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('rating')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.amenities')</label>
                <textarea name="amenities" class="w-full border border-gray-300 rounded p-2" placeholder="Enter JSON data">{{ old('amenities', json_encode($hotel->amenities, JSON_PRETTY_PRINT)) }}</textarea>
                @error('amenities')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.image')</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded p-2">                @isset($hotel->image)
                    <img src="{{ Storage::url($hotel->image) }}" alt="image" class="mt-2 w-32 h-32 rounded">
                @endisset                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.update')
            </button>
        </form>
    </div>
</x-app-layout>