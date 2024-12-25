<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        return view('home');
    }

    public function viewCheckout(Request $request){
        // Menjumlahkan semua harga yang ada dalam array prices
        $total_price = array_sum($request->prices);

        // Menambahkan total_price ke dalam data request
        $request->request->add([
            'total_price' => $total_price,
        ]);
        $order = $request->all();

        $user = Auth::user();

        // Mengakses nama dan email
        $name = $user->name;
        $email = $user->email;
        
        //dd($order);
        return view('user.order.checkout', compact('order', 'name', 'email'));
    }

    public function checkout(Request $request){
        $request->request->add(['status' => 'Unpaid']);
        $order = Order::create($request->all());
        // Inisialisasi total_price
        // $totalPrice = 0;

        // // Loop melalui selected_items untuk menghitung total_price
        // if ($request->has('selected_items')) {
        //     foreach ($request->selected_items as $itemId) {
        //         $quantity = $request->quantities[$itemId] ?? 0;
        //         $price = $request->prices[$itemId] ?? 0;

        //         // Penjumlahan total price
        //         $totalPrice += $quantity * $price;
        //     }
        // }

        // // Tambahkan total_price dan status ke dalam request
        // $request->request->add([
        //     'total_price' => $totalPrice,
        //     'status' => 'Unpaid',
        // ]);

        // $order = Order::create($request->all());
        dd($order);

        // //REQUEST START

        // // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => $order->id,
        //         'gross_amount' => $order->total_price,
        //     ),
        //     'customer_details' => array(
        //         'name' => $order->firstname,
        //         'address' => $order->lastname,
        //         'phone' => $order->phone,
        //     ),
        // );

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
        // return view('order.checkout', compact('snapToken', 'order'));
    }

    public function callback(Request $request){
        try {
            Log::info('Received Midtrans callback', $request->all());
    
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
        } catch (Exception $e) {
            //\Log::error('Error in Midtrans callback', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function invoice($id){
        $order = Order::find($id);
        return view('invoice', compact('order'));
    }
}
