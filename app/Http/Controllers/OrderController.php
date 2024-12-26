<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index(){
        return view('home');
    }

    public function viewCheckoutPage(){
        return view('user.order.checkout');
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
        
        return view('user.order.checkout', compact('order', 'name', 'email'));
    }

    public function checkout(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'nullable|email',
                'address' => 'required|string',
                'phone' => 'required|string',
                'total_price' => 'required|integer',
                'products' => 'required|array',
                'quantities' => 'required|array',
            ]);
    
            // Proses data pesanan
            $order = Order::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'total_price' => $validated['total_price'],
            ]);
    
            foreach ($validated['products'] as $index => $productId) {
                $order->products()->attach($productId, [
                    'quantity' => $validated['quantities'][$index],
                    'price' => Products::find($productId)->price,
                ]);
            }
    
            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
    
            // Buat payload untuk Midtrans
            $payload = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                ],
                'item_details' => $order->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'price' => $product->pivot->price,
                        'quantity' => $product->pivot->quantity,
                        'name' => $product->name,
                    ];
                })->toArray(),
            ];
    
            // Dapatkan Snap token
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
    
            // Kembalikan respons JSON
            return response()->json([
                'snapToken' => $snapToken,
                'orderId' => $order->id,
            ]);
        } catch (\Exception $e) {
            // Tangani error dan log
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
