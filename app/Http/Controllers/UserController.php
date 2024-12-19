<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validasi produk yang ada
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = session('cart', []);

        $found = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += $quantity; // Tambahkan jumlah produk
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);


        //return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');

        $user = Auth::user();

        // Ambil data dari session
        $cart = session()->get('cart', []); // 'cart' adalah contoh key session

        // Simpan data ke pivot table
        foreach ($cart as $product_id => $quantity) {
            $user->products()->attach($product_id, ['quantity' => $quantity]);
        }

        // Hapus session
        session()->forget('cart');

        // Logout user
        Auth::logout();

        return redirect('/login');
    }
}
