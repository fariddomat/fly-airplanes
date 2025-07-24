<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Carrental</h1>
        <a href="{{ route('dashboard.carrentals.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded shadow" wire:navigate>➕ @lang('site.add') Carrental</a>

        <div class="overflow-x-auto mt-4">
            <x-autocrud::table
                :columns="['id', 'user_id', 'rentalcompany_id', 'car_id', 'status']"
                :data="$carrentals"
                routePrefix="dashboard.carrentals"
                :show="true"
                :edit="true"
                :delete="true"
                :restore="true"
            />
        </div>
    </div>
</x-app-layout>
