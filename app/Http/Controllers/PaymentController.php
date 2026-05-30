<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Book;
use App\Models\Order;
use App\Models\BookChapterItem;

class PaymentController extends Controller
{
    public function createPackage($id)
    {
        $package = Package::findOrFail($id);

        return view('landing.payment', [
            'package' => $package,
            'book' => null,
            'order' => null,
            'chapterItem' => null,
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
            'chapterItem' => null,
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
            'chapterItem' => null,
            'type' => 'order',
        ]);
    }

    public function createBookChapter($id)
    {
        $chapterItem = BookChapterItem::with('bookChapter.package')->findOrFail($id);

        if ($chapterItem->status !== 'available') {
            return back()->with('error', 'Bab ini sudah tidak tersedia.');
        }

        $hargaDasar = $chapterItem->price ?: optional($chapterItem->bookChapter->package)->price ?: 0;
        $diskon = $chapterItem->discount ?? optional($chapterItem->bookChapter->package)->discount ?? 0;
        $hargaAkhir = $hargaDasar - ($hargaDasar * $diskon / 100);

        return view('landing.payment', [
            'package' => null,
            'book' => null,
            'order' => null,
            'chapterItem' => $chapterItem,
            'type' => 'book_chapter',
            'hargaDasar' => $hargaDasar,
            'diskon' => $diskon,
            'hargaAkhir' => $hargaAkhir,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:package,book,order,book_chapter',
            'proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'package_id' => 'nullable|exists:packages,id',
            'book_id' => 'nullable|exists:books,id',
            'order_id' => 'nullable|exists:orders,id',
            'book_chapter_item_id' => 'nullable|exists:book_chapter_items,id',
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

        if ($request->type === 'book_chapter' && !$request->book_chapter_item_id) {
            return back()->withErrors([
                'book_chapter_item_id' => 'Data bab tidak ditemukan.'
            ])->withInput();
        }

        if ($request->type === 'order') {
            $order = Order::findOrFail($request->order_id);

            if (!auth()->check() || $order->user_id !== auth()->id()) {
                abort(403);
            }
        }

        if ($request->type === 'book_chapter') {
            $chapterItem = BookChapterItem::findOrFail($request->book_chapter_item_id);

            if ($chapterItem->status !== 'available') {
                return back()->withErrors([
                    'book_chapter_item_id' => 'Bab ini sudah tidak tersedia.'
                ])->withInput();
            }
        }

        if (!file_exists(public_path('payments'))) {
            mkdir(public_path('payments'), 0755, true);
        }

        $proofName = time() . '_' . uniqid() . '.' . $request->proof->extension();

        $request->proof->move(
            public_path('payments'),
            $proofName
        );

        Payment::create([
            'user_id' => auth()->id(),
            'package_id' => $request->type === 'package' ? $request->package_id : null,
            'book_id' => $request->type === 'book' ? $request->book_id : null,
            'order_id' => $request->type === 'order' ? $request->order_id : null,
            'book_chapter_item_id' => $request->type === 'book_chapter' ? $request->book_chapter_item_id : null,
            'type' => $request->type,

            // otomatis dari akun login
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone ?? '-',

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


    public function destroy(Payment $payment)
    {
        if ($payment->proof && file_exists(public_path('payments/' . $payment->proof))) {
            unlink(public_path('payments/' . $payment->proof));
        }

        $payment->delete();

        return back()->with('success', 'Data pembayaran berhasil dihapus.');
    }
}