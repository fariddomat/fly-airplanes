<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.create') @lang('site.dashboard.cars')
        </h1>

        <form action="{{ route('dashboard.cars.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.rentalcompany_id')</label>
                <select name="rentalcompany_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">@lang('site.select_rentalcompany_id')</option>
                    @foreach ($rentalcompanies as $option)
                        <option value="{{ $option->id }}" {{ old('rentalcompany_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('rentalcompany_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_model')</label>
                <input type="text" name="car_model" value="{{ old('car_model') }}" class="w-full border border-gray-300 rounded p-2">
                @error('car_model')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_make')</label>
                <input type="text" name="car_make" value="{{ old('car_make') }}" class="w-full border border-gray-300 rounded p-2">
                @error('car_make')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.car_year')</label>
                <input type="number" name="car_year" value="{{ old('car_year') }}" class="w-full border border-gray-300 rounded p-2" >
                @error('car_year')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.create')
            </button>
        </form>
    </div>
</x-app-layout>