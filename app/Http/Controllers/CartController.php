<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('cart.index', compact('carts'));
    }

    public function add(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($cart) {
            $cart->update([
                'qty' => $cart->qty + 1
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
                'qty' => 1,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    public function updateQty(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->update([
            'qty' => max(1, $request->qty)
        ]);

        return back();
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function checkout(Request $request)
{
    $request->validate([
        'cart_ids' => 'required|array'
    ]);

    $carts = Cart::with('book')
        ->where('user_id', auth()->id())
        ->whereIn('id', $request->cart_ids)
        ->get();

    if ($carts->isEmpty()) {
        return back()->with('error', 'Pilih minimal satu item untuk checkout.');
    }

    $total = $carts->sum(function ($cart) {
        return ($cart->book->harga ?? 0) * $cart->qty;
    });

    $order = Order::create([
    'user_id' => auth()->id(),
    'name' => auth()->user()->name,
    'phone' => '-',
    'shipping_address' => '-',
    'total_price' => $total,
    'status' => 'pending',
    ]);

    foreach ($carts as $cart) {

    $price = $cart->book->harga ?? 0;
    $subtotal = $price * $cart->qty;

    OrderItem::create([
        'order_id' => $order->id,
        'book_id' => $cart->book_id,
        'book_title' => $cart->book->title ?? '-',
        'qty' => $cart->qty,
        'price' => $price,
        'subtotal' => $subtotal,
    ]);
}

    Cart::whereIn('id', $request->cart_ids)
        ->where('user_id', auth()->id())
        ->delete();

    return redirect()->route('payment.order', $order->id);
}
}