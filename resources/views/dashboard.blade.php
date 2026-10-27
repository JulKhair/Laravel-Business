<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>


<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <a href="{{ route('orders.index') }}"
               class="block rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    View Orders
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Browse existing orders and check their statuses.
                </p>
            </a>

            <a href="{{ route('orders.create') }}"
               class="block rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    Create Order
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Create a new order for a customer.
                </p>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    My Profile
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    View or update your account settings.
                </p>
            </a>

        </div>
    </div>
</div>

</x-app-layout>