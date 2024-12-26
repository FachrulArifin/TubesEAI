<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function dashboard(Request $request){
        $query = Order::with('products');

        if ($request->has('status') && $request->status != '') {
            // Filter berdasarkan status jika ada pilihan
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan status terlebih dahulu, lalu waktu terbaru
        $query->orderByRaw("FIELD(status, 'paid', 'unpaid') ASC")
            ->orderBy('updated_at', 'DESC');

        $data = $query->get();

        return view('admin.dashboard', compact('data'));
    }

    public function viewAddProduct(){
        return view('admin.addProduct');
    }

    public function viewUserList(){
        return view('admin.userControl');
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

    public function getUser(){
        $user = User::all(); // Mengambil semua produk dari database
        return response()->json($user);
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
