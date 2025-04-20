<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $orders = $request->only('plan_id');

        $plan = Plan::find((int)$orders['plan_id']);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'transaction_number' => uniqid('CDFLX-') . '-' . $user->id,
            'total_amount' => (int)$plan->price * 1.12
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_number,
                'gross_amount' => number_format($transaction->total_amount, 0, '.', ''),
            ],
            'item_details' => [
                [
                    'id' => $transaction->plan_id,
                    'price' => number_format($transaction->total_amount, 0, '.', ''),
                    'quantity' => 1,
                    'name' => $plan->title,
                ]
            ],
            'customer_details' => [
                'full_name' => $user->name,
                'email' => $user->email
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction->update([
                'midtrans_snap_token' => $snapToken,
            ]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'transaction_number' => $transaction->transaction_number,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create transaction',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function success()
    {
        return view('subscription.success');
    }
}
