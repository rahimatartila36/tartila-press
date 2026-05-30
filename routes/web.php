<?php

use Illuminate\Support\Facades\Route;

use App\Models\Book;
use App\Models\Package;
use App\Models\BookChapter;

use App\Http\Controllers\BookController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminBookChapterController;
use App\Http\Controllers\AdminBookChapterItemController;
use App\Http\Controllers\BookChapterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookCatalogController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $books = Book::latest()
        ->take(8)
        ->get();

    $packages = Package::where('is_active', true)
        ->latest()
        ->get();

    $bookChapters = BookChapter::with(['items', 'package'])
        ->latest()
        ->take(6)
        ->get();

    return view('landing.home', compact(
        'books',
        'packages',
        'bookChapters'
    ));
});

/*
|--------------------------------------------------------------------------
| Public Book Catalog
|--------------------------------------------------------------------------
*/

Route::get('/katalog-buku', [BookCatalogController::class, 'index'])
    ->name('books.catalog');

Route::get('/books/{id}', function ($id) {
    $book = Book::findOrFail($id);

    return view('landing.book-detail', compact('book'));
});

/*
|--------------------------------------------------------------------------
| Public Book Chapter
|--------------------------------------------------------------------------
*/

Route::get('/book-chapters', [BookChapterController::class, 'index'])
    ->name('book-chapters.index');

Route::get('/book-chapters/{id}', [BookChapterController::class, 'show'])
    ->name('book-chapters.show');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Payment
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/payment/package/{id}', [PaymentController::class, 'createPackage'])
        ->name('payment.package');

    Route::get('/payment/book/{id}', [PaymentController::class, 'createBook'])
        ->name('payment.book');

    Route::get('/payment/order/{order}', [PaymentController::class, 'createOrder'])
        ->name('payment.order');

    Route::get('/payment/book-chapter/{id}', [PaymentController::class, 'createBookChapter'])
        ->name('payment.book-chapter');

    Route::post('/payment', [PaymentController::class, 'store'])
        ->name('payment.store');

    Route::post('/payment/order/{order}', [PaymentController::class, 'storeOrder'])
        ->name('payment.store.order');

    Route::get('/payment-success', function () {
        return view('landing.payment-success');
    })->name('payment.success');

});



/*
|--------------------------------------------------------------------------
| User Checkout
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| User Cart
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Books
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/books', [BookController::class, 'index'])
        ->name('admin.books.index');

    Route::get('/admin/books/create', [BookController::class, 'create'])
        ->name('admin.books.create');

    Route::post('/admin/books', [BookController::class, 'store'])
        ->name('admin.books.store');

    Route::get('/admin/books/{id}/edit', [BookController::class, 'edit'])
        ->name('admin.books.edit');

    Route::put('/admin/books/{id}', [BookController::class, 'update'])
        ->name('admin.books.update');

    Route::delete('/admin/books/{id}', [BookController::class, 'destroy'])
        ->name('admin.books.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Packages
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/packages', [PackageController::class, 'index'])
        ->name('admin.packages.index');

    Route::get('/admin/packages/create', [PackageController::class, 'create'])
        ->name('admin.packages.create');

    Route::post('/admin/packages', [PackageController::class, 'store'])
        ->name('admin.packages.store');

    Route::get('/admin/packages/{id}/edit', [PackageController::class, 'edit'])
        ->name('admin.packages.edit');

    Route::put('/admin/packages/{id}', [PackageController::class, 'update'])
        ->name('admin.packages.update');

    Route::delete('/admin/packages/{id}', [PackageController::class, 'destroy'])
        ->name('admin.packages.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Book Chapter
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/book-chapters', [AdminBookChapterController::class, 'index'])
        ->name('admin.book-chapters.index');

    Route::get('/admin/book-chapters/create', [AdminBookChapterController::class, 'create'])
        ->name('admin.book-chapters.create');

    Route::post('/admin/book-chapters', [AdminBookChapterController::class, 'store'])
        ->name('admin.book-chapters.store');

    Route::get('/admin/book-chapters/{id}/edit', [AdminBookChapterController::class, 'edit'])
        ->name('admin.book-chapters.edit');

    Route::put('/admin/book-chapters/{id}', [AdminBookChapterController::class, 'update'])
        ->name('admin.book-chapters.update');

    Route::delete('/admin/book-chapters/{id}', [AdminBookChapterController::class, 'destroy'])
        ->name('admin.book-chapters.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Book Chapter Items / Bab
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/book-chapters/{bookChapterId}/items', [AdminBookChapterItemController::class, 'index'])
        ->name('admin.book-chapter-items.index');

    Route::post('/admin/book-chapters/{bookChapterId}/items', [AdminBookChapterItemController::class, 'store'])
        ->name('admin.book-chapter-items.store');

    Route::put('/admin/book-chapter-items/{id}', [AdminBookChapterItemController::class, 'update'])
        ->name('admin.book-chapter-items.update');

    Route::delete('/admin/book-chapter-items/{id}', [AdminBookChapterItemController::class, 'destroy'])
        ->name('admin.book-chapter-items.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Payments
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])
        ->name('admin.payments');

    Route::post('/admin/payments/{id}/approve', [AdminPaymentController::class, 'approve'])
        ->name('admin.payments.approve');

    Route::post('/admin/payments/{id}/reject', [AdminPaymentController::class, 'reject'])
        ->name('admin.payments.reject');

    Route::put('/admin/payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])
        ->name('admin.payments.status');

    Route::delete('/admin/payments/{id}', [AdminPaymentController::class, 'destroy'])
        ->name('admin.payments.destroy');
   
});

/*
|--------------------------------------------------------------------------
| Profile Breeze
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';