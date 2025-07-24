<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            @lang('site.show') @lang('site.dashboard.adds')
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.booking_id')</label>
                <p class="text-gray-900">
                    @isset($add->booking)
                        {{ $add->booking->name ?? '—' }}
                    @else
                        {{ $add->booking_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.insurance_purchased')</label>
                <p class="text-gray-900">{{ $add->insurance_purchased ? 'Yes' : 'No' }}</p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.carrental_id')</label>
                <p class="text-gray-900">
                    @isset($add->carrental)
                        {{ $add->carrental->name ?? '—' }}
                    @else
                        {{ $add->carrental_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.hotelbooking_id')</label>
                <p class="text-gray-900">
                    @isset($add->hotelbooking)
                        {{ $add->hotelbooking->name ?? '—' }}
                    @else
                        {{ $add->hotelbooking_id ?? '—' }}
                    @endisset
                </p>
            </div>            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">@lang('site.payment_method')</label>
                <p class="text-gray-900">{{ $add->payment_method ?? '—' }}</p>
            </div>
            <a href="{{ route('dashboard.adds.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-700">
                @lang('site.back')
            </a>
        </div>
    </div>
</x-app-layout>