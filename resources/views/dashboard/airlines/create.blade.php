<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.create') @lang('site.dashboard.airlines')
        </h1>

        <form action="{{ route('dashboard.airlines.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airline_name')</label>
                <input type="text" name="airline_name" value="{{ old('airline_name') }}" class="w-full border border-gray-300 rounded p-2">
                @error('airline_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.airline_code')</label>
                <input type="text" name="airline_code" value="{{ old('airline_code') }}" class="w-full border border-gray-300 rounded p-2">
                @error('airline_code')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-700">
                @lang('site.create')
            </button>
        </form>
    </div>
</x-app-layout>