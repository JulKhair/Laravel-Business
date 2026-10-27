 <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Order
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="customer_id" class="block font-medium">
                            Customer
                        </label>

                        <select id="customer_id" name="customer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Select a customer</option>

                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('customer_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Products</label>

                        @foreach ($products as $product)
                            <div class="flex items-center gap-3 py-2">
                                <input type="checkbox"
                                    id="product_{{ $product->id }}"
                                    name="items[{{ $product->id }}][selected]"
                                    value="1"
                                    @checked(old("items.{$product->id}.selected"))>

                                <label for="product_{{ $product->id }}"
                                    class="flex-1">
                                    {{ $product->name }}
                                    — ₱{{ number_format($product->price, 2) }}
                                    ({{ $product->stock_quantity }} in stock)
                                </label>

                                <label for="quantity_{{ $product->id }}"
                                    class="sr-only">
                                    Quantity for {{ $product->name }}
                                </label>

                                <input type="number"
                                    id="quantity_{{ $product->id }}"
                                    name="items[{{ $product->id }}][quantity]"
                                    min="1"
                                    max="{{ $product->stock_quantity }}"
                                    value="{{ old("items.{$product->id}.quantity", 1) }}"
                                    class="w-24 rounded-md border-gray-300"
                                    aria-label="Quantity for {{ $product->name }}">
                            </div>
                        @endforeach

                        @error('items')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="rounded-md bg-gray-800 px-4 py-2 text-white">
                        Create Order
                    </button>

                    <a href="{{ route('orders.index') }}"
                        class="ml-3 text-gray-700 underline">
                        Cancel
                    </a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>