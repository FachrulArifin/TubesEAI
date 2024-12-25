<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{   
    public function showUser(){
        $user = Auth::user();

        $data = Products::all();
        $cart = $user->products;
        //dd($cart);

        //return redirect()->route('user.showUser')->with(compact('data', 'cart'));
        return view('user.index', compact('data', 'cart'));
    }

    public function addToCart(Request $request)
    {
        // Validasi produk yang ada
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $imgPath = $request->input('product_img');

        $cart = session('cart', []);

        $found = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['product_name'] == $productName;
                $item['product_img'] == $imgPath;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'product_name' => $productName,
                'product_img' => $imgPath,
            ];
        }

        session(['cart' => $cart]);

        $user = Auth::user();

        // Ambil data dari session
        $cart = session()->get('cart', []); // 'cart' adalah contoh key session

        $syncData = [];

        // Simpan data ke pivot table
        foreach ($cart as $data) {


            if (isset($item['product_id'], $item['quantity']) && is_numeric($item['product_id']) && is_numeric($item['quantity'])) {
                $existingProduct = $user->products()->where('products_id', $item['product_id'])->first();
        
                if ($existingProduct) {
                    if($item['product_id'] == $productId){
                        // Tambahkan jumlah jika sudah ada
                        $currentQuantity = $existingProduct->pivot->quantity;
                        $syncData[$item['product_id']] = [
                            'quantity' => $currentQuantity + 1,
                            'updated_at' => now(),
                        ];
                    }
                    
                } else {
                    // Tambahkan data baru
                    $syncData[$item['product_id']] = [
                        'quantity' => $item['quantity'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        $user->products()->syncWithoutDetaching($syncData);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
