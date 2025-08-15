<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.edit') @lang('site.dashboard.carrentals')
        </h1>

        <form action="{{ route('dashboard.carrentals.update', $carrental->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <select name="user_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_user_id')</option>
                    @foreach ($users as $option)
                        <option value="{{ $option->id }}" {{ $carrental->user_id == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_id')</label>
                <select name="car_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_car_id')</option>
                    @foreach ($cars as $option)
                        <option value="{{ $option->id }}" {{ $carrental->car_id == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('car_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.pickup_location')</label>
                <textarea name="pickup_location" class="w-full border border-gray-300 rounded p-2">{{ old('pickup_location', $carrental->pickup_location) }}</textarea>
                @error('pickup_location')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.return_location')</label>
                <textarea name="return_location" class="w-full border border-gray-300 rounded p-2">{{ old('return_location', $carrental->return_location) }}</textarea>
                @error('return_location')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.pickup_date')</label>
                <input type="date" name="pickup_date" value="{{ old('pickup_date', $carrental->pickup_date) }}" class="w-full border border-gray-300 rounded p-2">
                @error('pickup_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.pickup_time')</label>
                <input type="text" name="pickup_time" value="{{ old('pickup_time', $carrental->pickup_time) }}" class="w-full border border-gray-300 rounded p-2">
                @error('pickup_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.return_date')</label>
                <input type="date" name="return_date" value="{{ old('return_date', $carrental->return_date) }}" class="w-full border border-gray-300 rounded p-2">
                @error('return_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.dropoff_time')</label>
                <input type="text" name="dropoff_time" value="{{ old('dropoff_time', $carrental->dropoff_time) }}" class="w-full border border-gray-300 rounded p-2">
                @error('dropoff_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <input type="number" name="total_price" value="{{ old('total_price', $carrental->total_price) }}" class="w-full border border-gray-300 rounded p-2" >
                @error('total_price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <input type="datetime-local" name="booking_date" value="{{ old('booking_date', $carrental->booking_date ? $carrental->booking_date : '') }}" class="w-full border border-gray-300 rounded p-2">
                @error('booking_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <select name="status" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_status')</option>
                    <option value="Confirmed" {{ old('status', $carrental->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Cancelled" {{ old('status', $carrental->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Pending" {{ old('status', $carrental->status) == 'Pending' ? 'selected' : '' }}>Pending</option>

                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rental_type')</label>
                <select name="rental_type" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_rental_type')</option>
                    <option value="same-location" {{ old('rental_type', $carrental->rental_type) == 'same-location' ? 'selected' : '' }}>same-location</option>
                    <option value="different-location" {{ old('rental_type', $carrental->rental_type) == 'different-location' ? 'selected' : '' }}>different-location</option>

                </select>
                @error('rental_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.driver_age')</label>
                <select name="driver_age" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_driver_age')</option>
                    <option value="21-24" {{ old('driver_age', $carrental->driver_age) == '21-24' ? 'selected' : '' }}>21-24</option>
                    <option value="25-29" {{ old('driver_age', $carrental->driver_age) == '25-29' ? 'selected' : '' }}>25-29</option>
                    <option value="30-64" {{ old('driver_age', $carrental->driver_age) == '30-64' ? 'selected' : '' }}>30-64</option>
                    <option value="65+" {{ old('driver_age', $carrental->driver_age) == '65+' ? 'selected' : '' }}>65+</option>

                </select>
                @error('driver_age')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.extras')</label>
                <textarea name="extras" class="w-full border border-gray-300 rounded p-2" placeholder="Enter JSON data">{{ old('extras', json_encode($carrental->extras, JSON_PRETTY_PRINT)) }}</textarea>
                @error('extras')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.driver_details')</label>
                <textarea name="driver_details" class="w-full border border-gray-300 rounded p-2" placeholder="Enter JSON data">{{ old('driver_details', json_encode($carrental->driver_details, JSON_PRETTY_PRINT)) }}</textarea>
                @error('driver_details')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.update')
            </button>
        </form>
    </div>
</x-app-layout>
