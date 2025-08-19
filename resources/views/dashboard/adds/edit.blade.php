<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.edit') @lang('site.dashboard.adds')
        </h1>

        <form action="{{ route('dashboard.adds.update', $add->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_id')</label>
                <select name="booking_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.booking_id')</option>
                    @foreach ($bookings as $option)
                        <option value="{{ $option->id }}" {{ $add->booking_id == $option->id ? 'selected' : '' }}>{{ $option->id }}</option>
                    @endforeach
                </select>
                @error('booking_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="insurance_purchased" value="1" class="mr-2" {{ $add->insurance_purchased ? 'checked' : '' }}>
                    @lang('site.insurance_purchased')
                </label>
                @error('insurance_purchased')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.carrental_id')</label>
                <select name="carrental_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.carrental_id')</option>
                    @foreach ($carrentals as $option)
                        <option value="{{ $option->id }}" {{ $add->carrental_id == $option->id ? 'selected' : '' }}>{{ $option->id }}</option>
                    @endforeach
                </select>
                @error('carrental_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.hotelbooking_id')</label>
                <select name="hotelbooking_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.hotelbooking_id')</option>
                    @foreach ($hotelbookings as $option)
                        <option value="{{ $option->id }}" {{ $add->hotelbooking_id == $option->id ? 'selected' : '' }}>{{ $option->id }}</option>
                    @endforeach
                </select>
                @error('hotelbooking_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.payment_method')</label>
                <input type="text" name="payment_method" value="{{ old('payment_method', $add->payment_method) }}" class="w-full border border-gray-300 rounded p-2">
                @error('payment_method')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.update')
            </button>
        </form>
    </div>
</x-app-layout>
