<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Record Payment
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4">
                    Order {{ $order->order_number }}
                </h3>

                <div class="space-y-2 mb-6">
                    <p>
                        <strong>Order total:</strong>
                        ₱{{ number_format($order->total_amount, 2) }}
                    </p>

                    <p>
                        <strong>Already paid:</strong>
                        ₱{{ number_format($paidCents / 100, 2) }}
                    </p>

                    <p>
                        <strong>Remaining balance:</strong>
                        ₱{{ number_format($remainingBalance, 2) }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-3 text-red-800">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($remainingBalance <= 0)
                    <p class="rounded bg-green-100 p-3 text-green-800">
                        This order is fully paid. No additional payment is needed.
                    </p>
                @else
                    <form method="POST"
                        action="{{ route('payments.store', $order) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="amount" class="block font-medium">
                                Payment Amount (₱)
                            </label>

                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                min="0.01"
                                max="{{ number_format($remainingBalance, 2, '.', '') }}"
                                step="0.01"
                                value="{{ old('amount') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300"
                            />

                            @error('amount')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="payment_method" class="block font-medium">
                                Payment Method
                            </label>

                            <select
                                id="payment_method"
                                name="payment_method"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300"
                            >
                                <option value="">Select payment method</option>
                                <option value="cash"
                                    @selected(old('payment_method') === 'cash')>
                                    Cash
                                </option>
                                <option value="gcash"
                                    @selected(old('payment_method') === 'gcash')>
                                    GCash
                                </option>
                            </select>

                            @error('payment_method')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="rounded-md bg-gray-800 px-4 py-2 text-white">
                            Record Payment
                        </button>

                        <a href="{{ route('orders.index') }}"
                            class="ml-3 text-gray-700 underline">
                            Cancel
                        </a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>