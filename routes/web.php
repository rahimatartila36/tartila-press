<?php

use Illuminate\Support\Facades\Route;

use App\Models\Book;
use App\Models\Package;

use App\Http\Controllers\BookController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;


/* =========================
   LANDING PAGE
========================= */

Route::get('/', function () {

    $books = Book::latest()
                ->take(8)
                ->get();

    $packages = Package::where('is_active', true)
                ->latest()
                ->get();

    return view(
        'landing.home',
        compact('books','packages')
    );

});


/* =========================
   HALAMAN PEMBAYARAN
========================= */

Route::get('/payment/{id}', function ($id) {

    $package = Package::findOrFail($id);

    return view(
        'landing.payment',
        compact('package')
    );

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
   ADMIN (LOGIN WAJIB)
========================= */

Route::middleware(['auth'])->group(function () {

    /* =====================
       BOOKS
    ===================== */

    Route::get('/admin/books',
    [BookController::class,'index']);

    Route::get('/admin/books/create',
    [BookController::class,'create']);

    Route::post('/admin/books',
    [BookController::class,'store']);

    Route::get('/admin/books/{id}/edit',
    [BookController::class,'edit']);

    Route::put('/admin/books/{id}',
    [BookController::class,'update']);

    Route::delete('/admin/books/{id}',
    [BookController::class,'destroy']);


    /* =====================
       PACKAGES
    ===================== */

    Route::get('/admin/packages',
    [PackageController::class,'index']);

    Route::get('/admin/packages/create',
    [PackageController::class,'create']);

    Route::post('/admin/packages',
    [PackageController::class,'store']);

    Route::get('/admin/packages/{id}/edit',
    [PackageController::class,'edit']);

    Route::put('/admin/packages/{id}',
    [PackageController::class,'update']);

    Route::delete('/admin/packages/{id}',
    [PackageController::class,'destroy']);

});


/* =========================
   PROFILE (BREEZE)
========================= */

Route::middleware('auth')->group(function () {

    Route::get('/profile',
    [ProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::patch('/profile',
    [ProfileController::class, 'update'])
    ->name('profile.update');

    Route::delete('/profile',
    [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

});

use App\Http\Controllers\PaymentController;

Route::get('/payment/{id}',
[PaymentController::class,'create']);

Route::post('/payment',
[PaymentController::class,'store']);

Route::get('/payment-success', function () {

    return view('landing.payment-success');

});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('admin.payments');
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::post('/payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('admin.payments.reject');
});

Route::put('/admin/payments/{id}/status', [App\Http\Controllers\AdminPaymentController::class, 'updateStatus']);

use App\Http\Controllers\AdminPaymentController;

Route::delete('/admin/payments/{id}', [AdminPaymentController::class, 'destroy']);

require __DIR__.'/auth.php';