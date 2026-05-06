@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="mb-4">Checkout</h3>

    <form method="POST" action="/checkout">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat Pengiriman</label>
            <textarea name="shipping_address" class="form-control" required></textarea>
        </div>

        <hr>

        <h5>Ringkasan</h5>

        @foreach($carts as $item)
            <div class="d-flex justify-content-between">
                <span>{{ $item->book->title }} x {{ $item->qty }}</span>
                <span>Rp {{ number_format($item->book->price * $item->qty, 0, ',', '.') }}</span>
            </div>
        @endforeach

        <hr>

        <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>

        <button class="btn btn-primary mt-3">
            Buat Pesanan
        </button>

    </form>

</div>

@endsection