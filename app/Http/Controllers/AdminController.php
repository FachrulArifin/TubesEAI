<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function viewAddProduct(){
        return view('admin.addProduct');
    }

    public function viewHistory(){
        return view('admin.history');
    }

    public function addProduct(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file gambar ke storage
        $imagePath = $request->file('image')->store('images', 'public');
    
        // Simpan path ke database
        $product = new Products();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->file_path = $imagePath;
        $product->save();
    
        // Kembalikan respon
        return back()->with('success', 'Gambar berhasil diunggah!')->with('image', $imagePath);
        // Simpan file gambar
        $imagePath = $request->file('image')->store('images', 'public');
    }

    public function getProducts(){
        $products = Products::all(); // Mengambil semua produk dari database
        return response()->json($products);
    }

    public function getProductById($id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json($product);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
    }


    public function deleteProduct($id)
    {
        $product = Products::find($id);
        if ($product) {
            // Hapus file gambar dari storage
                Storage::disk('public')->delete($product->file_path);
            
            // Hapus data dari database
            $product->delete();

            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
    }

    public function updateProduct(Request $request, $id){
        $product = Products::find($id);
        if ($product) {
            $product->update($request->only(['name', 'description', 'price', 'stock']));
            return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui']);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
    }
}
