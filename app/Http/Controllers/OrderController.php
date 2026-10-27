<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    public function index()
{
    $orders = \App\Models\Order::with([
        'customer',
        'user',
    ])->latest()->get();

    return view('orders.index', compact('orders'));
}

    public function create()
{
    $customers = \App\Models\Customer::orderBy('name')->get();

    $products = \App\Models\Product::where('is_available', true)
        ->orderBy('name')
        ->get();

    return view('orders.create', compact(
        'customers',
        'products'
    ));
}

public function store(Request $request)
{

    $request->validate([
        'customer_id' => [
            'required',
            'integer',
            'exists:customers,id',
        ],
        'items' => [
            'required',
            'array',
        ],
        'items.*.selected' => [
            'nullable',
            'in:1',
        ],
        'items.*.quantity' => [
            'nullable',
            'integer',
            'min:1',
        ],
    ]);

    $submittedItems = $request->input('items', []);

    $selectedIds = collect($submittedItems)
        ->filter(fn ($item) =>
            isset($item['selected']) &&
            (string) $item['selected'] === '1'
        )
        ->keys()
        ->map(fn ($id) => (int) $id)
        ->values();


    if ($selectedIds->isEmpty()) {
        throw ValidationException::withMessages([
            'items' => 'Please select at least one product.',
        ]);
    }


    $products = Product::whereIn('id', $selectedIds)
        ->where('is_available', true)
        ->get()
        ->keyBy('id');


    if ($products->count() !== $selectedIds->unique()->count()) {
        throw ValidationException::withMessages([
            'items' => 'One or more selected products are unavailable.',
        ]);
    }


    foreach ($selectedIds as $productId) {
        $product = $products->get($productId);
        $quantity = $submittedItems[$productId]['quantity'] ?? null;

        if (
            !is_numeric($quantity) ||
            (int) $quantity != $quantity ||
            (int) $quantity < 1
        ) {
            throw ValidationException::withMessages([
                "items.{$productId}.quantity" =>
                    'Each selected product must have a valid quantity.',
            ]);
        }

        if ((int) $quantity > $product->stock_quantity) {
            throw ValidationException::withMessages([
                "items.{$productId}.quantity" =>
                    "Not enough stock for {$product->name}.",
            ]);
        }
    }


    $order = DB::transaction(function () use (
        $request,
        $selectedIds,
        $submittedItems
    ) {
        // Lock selected product rows while calculating and saving.
        $products = Product::whereIn('id', $selectedIds)
            ->where('is_available', true)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        if ($products->count() !== $selectedIds->unique()->count()) {
            throw ValidationException::withMessages([
                'items' => 'A selected product is no longer available.',
            ]);
        }

        $totalCents = 0;
        $orderItems = [];

        foreach ($selectedIds as $productId) {
            $product = $products->get($productId);
            $quantity = (int) $submittedItems[$productId]['quantity'];

            if ($quantity > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    "items.{$productId}.quantity" =>
                        "Not enough stock for {$product->name}.",
                ]);
            }


            $unitPriceCents = (int) round(
                (float) $product->price * 100
            );

            $subtotalCents = $quantity * $unitPriceCents;
            $totalCents += $subtotalCents;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPriceCents / 100,
                'subtotal' => $subtotalCents / 100,
            ];
        }


        do {
            $orderNumber = 'ORD-' . now()->format('YmdHis')
                . '-' . Str::upper(Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());


        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
            'order_date' => now(),
            'status' => 'pending',
            'total_amount' => $totalCents / 100,
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        return $order;
    });

    return redirect()
        ->route('orders.index')
        ->with('success', "Order {$order->order_number} was created.");
}

}
