<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()]);
        }
        return session('cart_session_id');
    }

    public function index()
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::where('session_id', $sessionId)->with('item')->get();

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->available_quantity,
        ]);

        $sessionId = $this->getSessionId();

        // Cek apakah item sudah ada di cart
        $cartItem = Cart::where('session_id', $sessionId)
            ->where('item_id', $item->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $item->available_quantity) {
                return back()->with('error', 'Jumlah melebihi stok tersedia!');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Tambah item baru ke cart
            Cart::create([
                'session_id' => $sessionId,
                'item_id' => $item->id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $cart->item->available_quantity) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Barang berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        $sessionId = $this->getSessionId();
        Cart::where('session_id', $sessionId)->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
