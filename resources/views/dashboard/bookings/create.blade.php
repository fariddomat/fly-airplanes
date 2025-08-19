<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.create') @lang('site.dashboard.bookings')
        </h1>

        <form action="{{ route('dashboard.bookings.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <select name="user_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.user_id')</option>
                    @foreach ($users as $option)
                        <option value="{{ $option->id }}" {{ old('user_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.flight_id')</label>
                <select name="flight_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.flight_id')</option>
                    @foreach ($flights as $option)
                        <option value="{{ $option->id }}" {{ old('flight_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('flight_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.return_flight_id')</label>
                <select name="return_flight_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.return_flight_id')</option>
                    @foreach ($returnFlights as $option)
                        <option value="{{ $option->id }}" {{ old('return_flight_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('return_flight_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.num_passengers')</label>
                <input type="number" name="num_passengers" value="{{ old('num_passengers') }}" class="w-full border border-gray-300 rounded p-2" >
                @error('num_passengers')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <input type="datetime-local" name="booking_date" value="{{ old('booking_date') }}" class="w-full border border-gray-300 rounded p-2">
                @error('booking_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <input type="number" name="total_price" value="{{ old('total_price') }}" class="w-full border border-gray-300 rounded p-2" >
                @error('total_price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <select name="status" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.status')</option>
                    <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>

                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.trip_type')</label>
                <select name="trip_type" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.trip_type')</option>
                    <option value="oneway" {{ old('trip_type') == 'oneway' ? 'selected' : '' }}>oneway</option>
                    <option value="roundtrip" {{ old('trip_type') == 'roundtrip' ? 'selected' : '' }}>roundtrip</option>
                    <option value="multicity" {{ old('trip_type') == 'multicity' ? 'selected' : '' }}>multicity</option>

                </select>
                @error('trip_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.passenger_details')</label>
                <textarea name="passenger_details" class="w-full border border-gray-300 rounded p-2">{{ old('passenger_details') }}</textarea>
                @error('passenger_details')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.create')
            </button>
        </form>
    </div>
</x-app-layout>
