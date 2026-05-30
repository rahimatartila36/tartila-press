<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Katalog Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<style>

:root {
    --primary:#003153;
    --secondary:#D0F0C0;
}

body{
    background:#f8f9fa;
}

.catalog-header{
    background:linear-gradient(135deg, #f8fff4, #ffffff);
    color:#003153;
    padding:10px 20px 15px;
    border-bottom:1px solid #e5e5e5;
}

.catalog-header h1{
    color:#003153;
}

.catalog-header p{
    color:#5f6f7a;
}

.book-card{
    transition:0.3s;
    border:none;
    overflow:hidden;
}

.book-card:hover{
    transform:translateY(-5px);
}

.book-cover{
    height:320px;
    object-fit:cover;
}

</style>

</head>

<body>

@include('components.navbar')

{{-- HEADER --}}
<section class="catalog-header">

<div class="container text-center">

<h1 class="fw-bold mb-3">
Katalog Buku
</h1>

<p class="mb-0" style="max-width:700px; margin:auto;">

Temukan berbagai buku berkualitas berdasarkan
judul, penulis, kategori, dan keilmuan.

</p>

</div>

</section>

{{-- FILTER --}}
<section class="pt-2 pb-5">

<div class="container">

<form method="GET"
      action="{{ route('books.catalog') }}"
      class="card shadow-sm border-0 mb-5">

<div class="card-body">

<div class="row g-3">

{{-- pencarian --}}
<div class="col-md-4">

<input type="text"
       name="search"
       class="form-control"
       placeholder="Cari judul atau penulis..."
       value="{{ request('search') }}">

</div>

{{-- kategori --}}
<div class="col-md-3">

<select name="kategori"
        class="form-select">

<option value="">
Semua Kategori
</option>

@foreach($kategoris as $kategori)

<option value="{{ $kategori }}"
{{ request('kategori') == $kategori ? 'selected' : '' }}>

{{ $kategori }}

</option>

@endforeach

</select>

</div>

{{-- keilmuan --}}
<div class="col-md-3">

<select name="keilmuan"
        class="form-select">

<option value="">
Semua Keilmuan
</option>

@foreach($keilmuans as $keilmuan)

<option value="{{ $keilmuan }}"
{{ request('keilmuan') == $keilmuan ? 'selected' : '' }}>

{{ $keilmuan }}

</option>

@endforeach

</select>

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">
Cari
</button>

</div>

</div>

</div>

</form>

{{-- LIST BUKU --}}
<div class="row">

@forelse($books as $book)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm book-card">

<a href="/books/{{ $book->id }}"
   class="text-decoration-none text-dark">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
class="card-img-top book-cover">

<div class="card-body d-flex flex-column">

<h6 class="fw-bold">
{{ $book->title }}
</h6>

<p class="text-muted mb-2">
{{ $book->author }}
</p>

<div class="mb-2">

@if($book->kategori)

<span class="badge bg-primary">
{{ $book->kategori }}
</span>

@endif

@if($book->keilmuan)

<span class="badge bg-success">
{{ $book->keilmuan }}
</span>

@endif

</div>

<div class="mt-auto">

@if($book->harga)

    @if($book->diskon > 0)

        @php
            $hargaDiskon =
            $book->harga -
            ($book->harga * $book->diskon / 100);
        @endphp

        <div class="mb-1">

            <small class="text-muted text-decoration-line-through">

                Rp {{ number_format($book->harga,0,',','.') }}

            </small>

            <span class="badge bg-danger">

                -{{ $book->diskon }}%

            </span>

        </div>

        <div class="fw-bold text-primary">

            Rp {{ number_format($hargaDiskon,0,',','.') }}

        </div>

    @else

        <div class="fw-bold text-primary">

            Rp {{ number_format($book->harga,0,',','.') }}

        </div>

    @endif

@endif

</div>

</div>

</a>

<div class="card-body pt-0">

<a href="/payment/book/{{ $book->id }}"
   class="btn btn-primary w-100 mb-2">

Beli Sekarang

</a>

<form action="{{ route('cart.add') }}"
      method="POST">

@csrf

<input type="hidden"
       name="book_id"
       value="{{ $book->id }}">

<input type="hidden"
       name="quantity"
       value="1">

<button type="submit"
        class="btn btn-outline-secondary w-100">

+ Keranjang

</button>

</form>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning text-center">

Buku tidak ditemukan

</div>

</div>

@endforelse

</div>

{{-- PAGINATION --}}
<div class="mt-4 d-flex justify-content-center">

{{ $books->links() }}

</div>

</div>

</section>

{{-- FOOTER --}}
<footer style="background:#003153; color:white;">

<div class="container py-4 text-center">

<small>
© 2026 Tartila Press —
Menata Ilmu, Menguatkan Peradaban.
</small>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>