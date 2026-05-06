<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
            ->with('book')
            ->get();

        if ($carts->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang kosong');
        }

        $total = $carts->sum(function ($item) {
            return $item->book->harga * $item->qty;
        });

        return view('user.checkout', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'shipping_address' => 'required',
        ]);

        $carts = Cart::where('user_id', auth()->id())
            ->with('book')
            ->get();

        if ($carts->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang kosong');
        }

        $total = $carts->sum(function ($item) {
            return $item->book->price * $item->qty;
        });

        // 🔥 BUAT ORDER
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'total_price' => $total,
            'status' => 'menunggu_pembayaran',
        ]);

        // 🔥 BUAT ORDER ITEMS
        foreach ($carts as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'book_title' => $item->book->title,
                'price' => $item->book->harga,
                'qty' => $item->qty,
                'subtotal' => $item->book->harga * $item->qty,
            ]);
        }

        // 🔥 HAPUS CART
        Cart::where('user_id', auth()->id())->delete();

        // 🔥 REDIRECT KE PEMBAYARAN
        return redirect('/payment/order/' . $order->id);
    }
}