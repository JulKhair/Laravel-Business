<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Order $order)
{
    $order->load('payments');

    $paidCents = $order->payments->sum(
        fn ($payment) => (int) round(
            (float) $payment->amount * 100
        )
    );

    $totalCents = (int) round(
        (float) $order->total_amount * 100
    );

    $remainingBalance = max(0, $totalCents - $paidCents) / 100;

    return view('payments.create', compact(
        'order',
        'paidCents',
        'remainingBalance'
    ));
}
    public function store(Request $request, Order $order)
{
    
    $validated = $request->validate([
        'amount' => [
            'required',
            'numeric',
            'decimal:0,2',
            'min:0.01',
        ],
        'payment_method' => [
            'required',
            'string',
            'in:cash,gcash',
        ],
    ]);

    $payment = DB::transaction(function () use (
        $order,
        $validated
    ) {
        
        $lockedOrder = Order::whereKey($order->id)
            ->lockForUpdate()
            ->firstOrFail();

        
        $orderTotalCents = (int) round(
            (float) $lockedOrder->total_amount * 100
        );

        $existingPayments = $lockedOrder->payments()->get();

        $paidCents = $existingPayments->sum(
            fn ($payment) => (int) round(
                (float) $payment->amount * 100
            )
        );

        $newPaymentCents = (int) round(
            (float) $validated['amount'] * 100
        );

        
        if ($paidCents + $newPaymentCents > $orderTotalCents) {
            throw ValidationException::withMessages([
                'amount' => 'This payment exceeds the order balance. '
                    . 'Remaining balance: ₱'
                    . number_format(
                        max(0, $orderTotalCents - $paidCents) / 100,
                        2
                    ),
            ]);
        }

        
        do {
            $reference = 'PAY-' . now()->format('YmdHis')
                . '-' . Str::upper(Str::random(6));
        } while (
            Payment::where(
                'payment_reference',
                $reference
            )->exists()
        );

        
        return $lockedOrder->payments()->create([
            'payment_reference' => $reference,
            'payment_method' => $validated['payment_method'],
            'amount' => $newPaymentCents / 100,
            'paid_at' => now(),
        ]);
    });

    return redirect()
        ->route('orders.index')
        ->with(
            'success',
            "Payment {$payment->payment_reference} recorded successfully."
        );
}
}
