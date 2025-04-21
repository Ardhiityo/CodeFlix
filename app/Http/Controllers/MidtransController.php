<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $hashed = hash('sha512',  $request->order_id  . $request->status_code . $request->gross_amount . config('midtrans.server_key'));

        Log::info('success 1', ['transaction_status' => $request->transaction_status]);

        if ($hashed !== $request->signature_key) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature key',
            ], 403);
        }

        $transaction = Transaction::with('plan', 'user')
            ->where('transaction_number', $request->order_id)
            ->first();

        Log::info('success 2', ['transaction' => $transaction]);

        if ($request->transaction_status === 'settlement' || $request->transaction_status === 'capture') {

            DB::beginTransaction();
            try {
                Membership::create([
                    'user_id' => $transaction->user_id,
                    'plan_id' => $transaction->plan_id,
                    'active' => true,
                    'start_date' => now(),
                    'end_date' => now()->addDays(30)
                ]);

                $transaction->update([
                    'midtrans_transaction_id' => $request->transaction_id,
                    'payment_status' => 'paid'
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Transaction success',
                ], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create membership',
                    'error' => $th->getMessage(),
                ], 500);
            }
        } else {
            $transaction->update([
                'midtrans_transaction_id' => $request->transaction_id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Transaction failed',
            ], 400);
        }
    }
}
