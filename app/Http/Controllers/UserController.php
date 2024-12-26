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
        // Validasi input
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'product_name' => 'required|string',
            'product_img' => 'required|string',
            'product_qty' => 'required|integer|min:1',
        ]);
    
        $user = Auth::user();
        $productId = $request->input('product_id');
        $quantity = $request->input('product_qty');
    
        // Cari produk di pivot table
        $existingProduct = $user->products()->where('products.id', $productId)->first();
    
        if ($existingProduct) {
            // Jika sudah ada, tambahkan jumlahnya
            $currentQuantity = $existingProduct->pivot->quantity;
            $user->products()->updateExistingPivot($productId, [
                'quantity' => $currentQuantity + $quantity,
                'updated_at' => now(),
            ]);
        } else {
            // Jika belum ada, tambahkan data baru
            $user->products()->attach($productId, [
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
}
