<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function viewCheckoutPage()
    {
        return view('user.order.checkout');
    }

    public function viewCheckout(Request $request)
    {
        $totalPrice = array_sum(array_map(function ($price, $quantity) {
            return $price * $quantity; // Mengalikan harga dengan jumlah untuk setiap item
        }, $request->prices, $request->quantities));

        $request->merge(['total_price' => $totalPrice]);
        $orderData = $request->all();
        $user = Auth::user();

        return view('user.order.checkout', [
            'order' => $orderData,
            'name' => $user->name,
            'email' => $user->email,
            'total_price' => $request->total_price
        ]);
    }

    public function checkout(Request $request)
    {
        try {
            $validated = $this->validateCheckoutData($request);

            $order = $this->createOrder($validated);

            $snapToken = $this->generateSnapToken($order);

            return response()->json([
                'snapToken' => $snapToken,
                'orderId' => $order->id,
                'total_price' => $order->total_price,

            ], 200, ['Content-Security-Policy' => "default-src 'self'; connect-src https:"]);
        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        try {
            Log::info('Received Midtrans callback', $request->all());

            // Calculate the expected signature
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
            // Validate the signature key
            if ($hashed === $request->signature_key) {
                if ($request->transaction_status === 'settlement') {
                    $order = Order::find($request->order_id);
                    if ($order) {
                        $order->update(['status' => 'paid']);
                    } else {
                        Log::error('Order not found', ['order_id' => $request->order_id]);
                    }
                }
            } else {
                Log::error('Signature mismatch', [
                    'expected' => $hashed,
                    'received' => $request->signature_key,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in Midtrans callback', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function invoice($id)
    {
        $order = Order::with('products')->where('id', $id)->first();

        return view('user.order.invoice', compact('order'));
    }

    private function validateCheckoutData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'phone' => 'required|string',
            'total_price' => 'required|integer',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);
    }

    private function createOrder($data)
    {
        $order = Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'total_price' => $data['total_price'],
        ]);

        foreach ($data['products'] as $index => $productId) {
            $product = Products::find($productId);
            if ($product) {
                $order->products()->attach($productId, [
                    'quantity' => $data['quantities'][$index],
                    'price' => $product->price,
                ]);
            }
        }

        return $order;
    }

    private function generateSnapToken($order)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

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

        return Snap::getSnapToken($payload);
    }

    private function validateMidtransSignature(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        return $expectedSignature === $request->signature_key;
    }
}
