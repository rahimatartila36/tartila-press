<section id="books" class="py-5 bg-light">

<div class="container">

<h2 class="text-center mb-5">
Katalog Buku
</h2>

<div class="row">

@forelse($books as $book)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm">

<a href="/books/{{ $book->id }}" class="text-decoration-none text-dark">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
class="card-img-top"
style="height: 320px; object-fit: cover;">

<div class="card-body d-flex flex-column">

<h6 class="fw-bold">
{{ $book->title }}
</h6>

<p class="text-muted mb-2">
{{ $book->author }}
</p>

<div class="mt-2 mb-3">

@if($book->harga)

    @if($book->diskon > 0)

        @php
            $hargaDiskon = $book->harga - ($book->harga * $book->diskon / 100);
        @endphp

        <div class="mb-1">
            <span class="text-muted text-decoration-line-through small">
                Rp {{ number_format($book->harga, 0, ',', '.') }}
            </span>

            <span class="badge bg-success ms-1">
                {{ $book->diskon }}%
            </span>
        </div>

        <div class="fw-bold text-primary">
            Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
        </div>

    @else

        <div class="fw-bold text-primary">
            Rp {{ number_format($book->harga, 0, ',', '.') }}
        </div>

    @endif

@else

    <small class="text-muted">
        Harga belum tersedia
    </small>

@endif

</div>

</div>

</a>

<div class="card-body pt-0">

<a href="/payment/book/{{ $book->id }}"
   class="btn btn-primary w-100 mb-2">
    Beli Sekarang
</a>

<form action="{{ route('cart.add') }}" method="POST">
    @csrf

    <input type="hidden" name="book_id" value="{{ $book->id }}">
    <input type="hidden" name="quantity" value="1">

    <button type="submit" class="btn btn-outline-secondary btn-lg">
        + Keranjang
    </button>
</form>

</div>

</div>

</div>

@empty

<p class="text-center">
Belum ada buku
</p>

@endforelse

</div>

</div>

</section>