<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">


            @if (session('success'))
    <div class="mb-4 rounded bg-green-100 p-3 text-green-800">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded bg-red-100 p-3 text-red-800">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <table class="min-w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3 text-left">Order Number</th>
                            <th class="border p-3 text-left">Customer</th>
                            <th class="border p-3 text-left">Staff Member</th>
                            <th class="border p-3 text-left">Total Amount</th>
                            <th class="border p-3 text-left">Status</th>
                            <th class="border p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="border p-3">
                                    {{ $order->order_number }}
                                </td>

                                <td class="border p-3">
                                    {{ $order->customer->name ?? 'Unknown' }}
                                </td>

                                <td class="border p-3">
                                    {{ $order->user->name ?? 'Unknown' }}
                                </td>

                                <td class="border p-3">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>

                                <td class="border p-3">
                                    {{ ucfirst($order->status) }}
                                </td>

                                <td class="border p-3">
                                   <a href="{{ route('payments.create', $order) }}"
                                      class="text-blue-600 underline">
                                      Record Payment
                                   </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-3 text-center">
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>