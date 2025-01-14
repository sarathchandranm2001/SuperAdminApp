<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'order_rcptid_11',
            'amount' => $request->amount * 100, // Amount in paise
            'currency' => 'INR',
        ]);

        return response()->json([
            'orderId' => $order->id,
            'key' => env('RAZORPAY_KEY'),
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $signatureStatus = $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ]);

        if ($signatureStatus) {
            return redirect()->route('payment.page')->with('success', 'Payment Successful!');
        } else {
            return redirect()->route('payment.page')->with('error', 'Payment Verification Failed!');
        }
    }
}
