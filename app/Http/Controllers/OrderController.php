<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return view('index');
    }

    public function checkout(Request $request){
        $request->request->add(['total_price' => $request->qty * 10000, 'status' => 'Unpaid']);
        $order = Order::create($request->all());

        //REQUEST START

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->total_price,
            ),
            'customer_details' => array(
                'first_name' => $order->firstname,
                'last_name' => $order->lastname,
                'phone' => $order->phone,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('checkout', compact('snapToken', 'order'));
    }

    public function callback(Request $request){
        try {
            //\Log::info('Received Midtrans callback', $request->all());
    
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
            
            if ($hashed == $request->signature_key) {
                if ($request->transaction_status == 'settlement') {
                    $order = Order::find($request->order_id);
                    if ($order) {
                        $order->update(['status' => 'paid']);
                    } else {
                        //\Log::error('Order not found', ['order_id' => $request->order_id]);
                    }
                }
            } else {
                //\Log::error('Signature mismatch', ['expected' => $hashed, 'received' => $request->signature_key]);
            }
        } catch (\Exception $e) {
            //\Log::error('Error in Midtrans callback', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function invoice($id){
        $order = Order::find($id);
        return view('invoice', compact('order'));
    }
}
