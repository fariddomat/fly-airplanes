<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.create') @lang('site.dashboard.flights')
        </h1>

        <form action="{{ route('dashboard.flights.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airline_id')</label>
                <select name="airline_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_airline_id')</option>
                    @foreach ($airlines as $option)
                        <option value="{{ $option->id }}" {{ old('airline_id') == $option->id ? 'selected' : '' }}>
                            {{ $option->name }}</option>
                    @endforeach
                </select>
                @error('airline_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.departure_airport_id')</label>
                <select name="departure_airport_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_departure_airport_id')</option>
                    @foreach ($departureAirports as $option)
                        <option value="{{ $option->id }}"
                            {{ old('departure_airport_id') == $option->id ? 'selected' : '' }}>{{ $option->airport_name }}
                        </option>
                    @endforeach
                </select>
                @error('departure_airport_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.arrival_airport_id')</label>
                <select name="arrival_airport_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_arrival_airport_id')</option>
                    @foreach ($arrivalAirports as $option)
                        <option value="{{ $option->id }}"
                            {{ old('arrival_airport_id') == $option->id ? 'selected' : '' }}>{{ $option->airport_name }}
                        </option>
                    @endforeach
                </select>
                @error('arrival_airport_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.departure_time')</label>
                <input type="datetime-local" name="departure_time" value="{{ old('departure_time') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('departure_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.arrival_time')</label>
                <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('arrival_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.flight_number')</label>
                <input type="text" name="flight_number" value="{{ old('flight_number') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('flight_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.price')</label>
                <input type="number" name="price" value="{{ old('price') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.available_seats')</label>
                <input type="number" name="available_seats" value="{{ old('available_seats') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('available_seats')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.class')</label>
                <select name="class" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_class')</option>
                    <option value="Economy" {{ old('class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                    <option value="Business" {{ old('class') == 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="First" {{ old('class') == 'First' ? 'selected' : '' }}>First</option>

                </select>
                @error('class')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.duration')</label>
                <input type="text" name="duration" value="{{ old('duration') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('duration')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.stops')</label>
                <select name="stops" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_stops')</option>
                    <option value="direct" {{ old('stops') == 'direct' ? 'selected' : '' }}>direct</option>
                    <option value="one-stop" {{ old('stops') == 'one-stop' ? 'selected' : '' }}>one-stop</option>
                    <option value="multi-stop" {{ old('stops') == 'multi-stop' ? 'selected' : '' }}>multi-stop</option>

                </select>
                @error('stops')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.amenities')</label>
                <input type="text" name="amenities" value="{{ old('amenities') }}"
                    class="w-full border border-gray-300 rounded p-2">
                @error('amenities')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.create')
            </button>
        </form>
    </div>
</x-app-layout>
