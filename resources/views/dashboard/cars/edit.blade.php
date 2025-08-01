<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.edit') @lang('site.dashboard.cars')
        </h1>

        <form action="{{ route('dashboard.cars.update', $car->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rentalcompany_id')</label>
                <select name="rentalcompany_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_rentalcompany_id')</option>
                    @foreach ($rentalcompanies as $option)
                        <option value="{{ $option->id }}" {{ $car->rentalcompany_id == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('rentalcompany_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.name')</label>
                <input type="text" name="name" value="{{ old('name', $car->name) }}" class="w-full border border-gray-300 rounded p-2">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.year')</label>
                <input type="number" name="year" value="{{ old('year', $car->year) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('year')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.type')</label>
                <select name="type" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_type')</option>
                    <option value="economy" {{ old('type', $car->type) == 'economy' ? 'selected' : '' }}>economy</option>
                    <option value="compact" {{ old('type', $car->type) == 'compact' ? 'selected' : '' }}>compact</option>
                    <option value="sedan" {{ old('type', $car->type) == 'sedan' ? 'selected' : '' }}>sedan</option>
                    <option value="suv" {{ old('type', $car->type) == 'suv' ? 'selected' : '' }}>suv</option>
                    <option value="luxury" {{ old('type', $car->type) == 'luxury' ? 'selected' : '' }}>luxury</option>
                    <option value="van" {{ old('type', $car->type) == 'van' ? 'selected' : '' }}>van</option>
                    <option value="convertible" {{ old('type', $car->type) == 'convertible' ? 'selected' : '' }}>convertible</option>

                </select>
                @error('type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.transmission')</label>
                <select name="transmission" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_transmission')</option>
                    <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>automatic</option>
                    <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>manual</option>

                </select>
                @error('transmission')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.fuel_type')</label>
                <select name="fuel_type" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_fuel_type')</option>
                    <option value="petrol" {{ old('fuel_type', $car->fuel_type) == 'petrol' ? 'selected' : '' }}>petrol</option>
                    <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>diesel</option>
                    <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>hybrid</option>
                    <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>electric</option>

                </select>
                @error('fuel_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price')</label>
                <input type="number" name="price" value="{{ old('price', $car->price) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.img')</label>
                <input type="file" name="img" accept="image/*" class="w-full border border-gray-300 rounded p-2">                @isset($car->img)
                    <img src="{{ Storage::url($car->img) }}" alt="img" class="mt-2 w-32 h-32 rounded">
                @endisset                @error('img')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.seats')</label>
                <input type="number" name="seats" value="{{ old('seats', $car->seats) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('seats')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.luggage_capacity')</label>
                <input type="number" name="luggage_capacity" value="{{ old('luggage_capacity', $car->luggage_capacity) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('luggage_capacity')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.features')</label>
                <textarea name="features" class="w-full border border-gray-300 rounded p-2" placeholder="Enter JSON data">{{ old('features', json_encode($car->features, JSON_PRETTY_PRINT)) }}</textarea>
                @error('features')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rating')</label>
                <input type="number" name="rating" value="{{ old('rating', $car->rating) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('rating')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.update')
            </button>
        </form>
    </div>
</x-app-layout>