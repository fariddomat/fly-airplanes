<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.create') @lang('site.dashboard.hotelbookings')
        </h1>

        <form action="{{ route('dashboard.hotelbookings.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.user_id')</label>
                <select name="user_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_user_id')</option>
                    @foreach ($users as $option)
                        <option value="{{ $option->id }}" {{ old('user_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.hotel_id')</label>
                <select name="hotel_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_hotel_id')</option>
                    @foreach ($hotels as $option)
                        <option value="{{ $option->id }}" {{ old('hotel_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('hotel_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.check_in_date')</label>
                <input type="date" name="check_in_date" value="{{ old('check_in_date') }}" class="w-full border border-gray-300 rounded p-2">
                @error('check_in_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.check_out_date')</label>
                <input type="date" name="check_out_date" value="{{ old('check_out_date') }}" class="w-full border border-gray-300 rounded p-2">
                @error('check_out_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.room_type')</label>
                <input type="text" name="room_type" value="{{ old('room_type') }}" class="w-full border border-gray-300 rounded p-2">
                @error('room_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.total_price')</label>
                <input type="number" name="total_price" value="{{ old('total_price') }}" class="w-full border border-gray-300 rounded p-2" >
                @error('total_price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_date')</label>
                <input type="datetime-local" name="booking_date" value="{{ old('booking_date') }}" class="w-full border border-gray-300 rounded p-2">
                @error('booking_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.status')</label>
                <select name="status" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_status')</option>
                    <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>

                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.create')
            </button>
        </form>
    </div>
</x-app-layout>