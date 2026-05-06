<?php

use Illuminate\Support\Facades\Route;

use App\Models\Book;
use App\Models\Package;

use App\Http\Controllers\BookController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminPaymentController;

/* =========================
   LANDING PAGE
========================= */

Route::get('/', function () {
    $books = Book::latest()->take(8)->get();

    $packages = Package::where('is_active', true)
        ->latest()
        ->get();

    return view('landing.home', compact('books', 'packages'));
});

/* =========================
   DETAIL BUKU
========================= */

Route::get('/books/{id}', function ($id) {
    $book = Book::findOrFail($id);

    return view('landing.book-detail', compact('book'));
});

/* =========================
   PEMBAYARAN USER
========================= */

Route::middleware(['auth'])->group(function () {

    // Pembayaran paket
    Route::get('/payment/package/{id}', [PaymentController::class, 'createPackage']);

    // Pembayaran buku
    Route::get('/payment/book/{id}', [PaymentController::class, 'createBook']);

    // Pembayaran order dari cart
    Route::get('/payment/order/{order}', [PaymentController::class, 'createOrder'])
        ->name('payment.order');

    // Simpan pembayaran biasa
    Route::post('/payment', [PaymentController::class, 'store'])
        ->name('payment.store');

    // Simpan pembayaran dari order/cart
    Route::post('/payment/order/{order}', [PaymentController::class, 'storeOrder'])
        ->name('payment.store.order');

    Route::get('/payment-success', function () {
        return view('landing.payment-success');
    })->name('payment.success');

});
/* =========================
   DASHBOARD
========================= */

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth'])
->name('dashboard');

/* =========================
   ADMIN LOGIN WAJIB
========================= */

Route::middleware(['auth'])->group(function () {

    /* BOOKS */
    Route::get('/admin/books', [BookController::class, 'index']);
    Route::get('/admin/books/create', [BookController::class, 'create']);
    Route::post('/admin/books', [BookController::class, 'store']);
    Route::get('/admin/books/{id}/edit', [BookController::class, 'edit']);
    Route::put('/admin/books/{id}', [BookController::class, 'update']);
    Route::delete('/admin/books/{id}', [BookController::class, 'destroy']);

    /* PACKAGES */
    Route::get('/admin/packages', [PackageController::class, 'index']);
    Route::get('/admin/packages/create', [PackageController::class, 'create']);
    Route::post('/admin/packages', [PackageController::class, 'store']);
    Route::get('/admin/packages/{id}/edit', [PackageController::class, 'edit']);
    Route::put('/admin/packages/{id}', [PackageController::class, 'update']);
    Route::delete('/admin/packages/{id}', [PackageController::class, 'destroy']);

    /* PAYMENTS */
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])
        ->name('admin.payments');

    Route::post('/admin/payments/{id}/approve', [AdminPaymentController::class, 'approve'])
        ->name('admin.payments.approve');

    Route::post('/admin/payments/{id}/reject', [AdminPaymentController::class, 'reject'])
        ->name('admin.payments.reject');

    Route::put('/admin/payments/{id}/status', [AdminPaymentController::class, 'updateStatus']);

    Route::delete('/admin/payments/{id}', [AdminPaymentController::class, 'destroy']);

    Route::get('/payment/order/{id}', [PaymentController::class, 'createOrder'])
    ->middleware('auth');

    });

/* =========================
   PROFILE BREEZE
========================= */

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

use App\Http\Controllers\CheckoutController;

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'store']);

});

use App\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::put('/cart/{cart}/qty', [CartController::class, 'updateQty'])
        ->name('cart.qty');

    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');
});



require __DIR__.'/auth.php';