<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Book;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createPackage($id)
    {
        $package = Package::findOrFail($id);

        return view('landing.payment', [
            'package' => $package,
            'book' => null,
            'order' => null,
            'type' => 'package',
        ]);
    }

    public function createBook($id)
    {
        $book = Book::findOrFail($id);

        return view('landing.payment', [
            'package' => null,
            'book' => $book,
            'order' => null,
            'type' => 'book',
        ]);
    }

    public function createOrder(Order $order)
    {
        if (!auth()->check() || $order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.book');

        return view('landing.payment', [
            'package' => null,
            'book' => null,
            'order' => $order,
            'type' => 'order',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:package,book,order',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'package_id' => 'nullable|exists:packages,id',
            'book_id' => 'nullable|exists:books,id',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        if ($request->type === 'package' && !$request->package_id) {
            return back()->withErrors([
                'package_id' => 'Data paket tidak ditemukan.'
            ])->withInput();
        }

        if ($request->type === 'book' && !$request->book_id) {
            return back()->withErrors([
                'book_id' => 'Data buku tidak ditemukan.'
            ])->withInput();
        }

        if ($request->type === 'order' && !$request->order_id) {
            return back()->withErrors([
                'order_id' => 'Data pesanan tidak ditemukan.'
            ])->withInput();
        }

        if ($request->type === 'order') {
            $order = Order::findOrFail($request->order_id);

            if (!auth()->check() || $order->user_id !== auth()->id()) {
                abort(403);
            }
        }

        $proofName = time() . '_' . uniqid() . '.' . $request->proof->extension();

        $request->proof->move(
            public_path('payments'),
            $proofName
        );

        Payment::create([
            'package_id' => $request->type === 'package' ? $request->package_id : null,
            'book_id' => $request->type === 'book' ? $request->book_id : null,
            'order_id' => $request->type === 'order' ? $request->order_id : null,
            'type' => $request->type,
            'name' => $request->name,
            'phone' => $request->phone,
            'proof' => $proofName,
            'status' => 'pending',
        ]);

        return redirect()->route('payment.success');
    }

    public function storeOrder(Request $request, Order $order)
    {
        if (!auth()->check() || $order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->merge([
            'type' => 'order',
            'order_id' => $order->id,
        ]);

        return $this->store($request);
    }
}