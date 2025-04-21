<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Node\NodeWalker;

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

        $plan = Plan::find((int)$request->plan_id);

        $order_id = uniqid('CDFLX-') . '-' . $user->id;
        $total_amount = number_format(($plan->price * 0.12) + $plan->price, '0', '', '');

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $total_amount,
            ],
            'item_details' => [
                [
                    'id' => $order_id,
                    'price' => $total_amount,
                    'quantity' => 1,
                    'name' => $plan->title,
                ]
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Transaction::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'transaction_number' => $order_id,
                'midtrans_snap_token' => $snapToken,
                'total_amount' => $total_amount,
            ]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken
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
