@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="mb-4">Keranjang Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->count() == 0)

        <div class="alert alert-info">
            Keranjang masih kosong.
        </div>

        <a href="/" class="btn btn-primary">
            Lihat Katalog Buku
        </a>

    @else

        @foreach($carts as $item)

            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">{{ $item->book->title }}</h5>

                        <small>
                            Qty: {{ $item->qty }}
                        </small>

                        <br>

                        <strong>
                            Rp {{ number_format($item->book->harga * $item->qty, 0, ',', '.') }}
                        </strong>
                    </div>

                    <a href="/cart/delete/{{ $item->id }}" class="btn btn-danger btn-sm">
                        Hapus
                    </a>

                </div>
            </div>

        @endforeach

        <div class="text-end mt-4">
            <a href="/checkout" class="btn btn-primary">
                Checkout
            </a>
        </div>

    @endif

</div>

@endsection