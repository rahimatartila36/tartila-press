<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $book->title }} - Tartila Press</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --primary:#003153;
    --secondary:#D0F0C0;
}

.book-cover {
    width: 100%;
    max-height: 560px;
    object-fit: cover;
    border-radius: 12px;
}
</style>

</head>

<body>

@include('components.navbar')

<section class="py-5">
<div class="container">

<a href="/" class="btn btn-outline-secondary mb-4">
    ← Kembali ke Beranda
</a>

<div class="row g-5">

<div class="col-md-5">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/400x600' }}"
class="book-cover shadow-sm">

</div>

<div class="col-md-7">

<h2 class="fw-bold mb-3">
{{ $book->title }}
</h2>

@if($book->harga)

    @if($book->diskon > 0)

        @php
            $hargaDiskon = $book->harga - ($book->harga * $book->diskon / 100);
        @endphp

        <div class="mb-3">
            <span class="text-muted text-decoration-line-through">
                Rp {{ number_format($book->harga, 0, ',', '.') }}
            </span>

            <span class="badge bg-success ms-2">
                Diskon {{ $book->diskon }}%
            </span>

            <h4 class="fw-bold text-primary mt-1">
                Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
            </h4>
        </div>

    @else

        <h4 class="fw-bold text-primary mb-3">
            Rp {{ number_format($book->harga, 0, ',', '.') }}
        </h4>

    @endif

@else

    <p class="text-muted">
        Harga belum tersedia
    </p>

@endif

<div class="card mb-4">
<div class="card-body">

<h5 class="fw-bold mb-3">
Detail Buku
</h5>

<table class="table table-borderless mb-0">

<tr>
    <td width="160">Judul</td>
    <td>: {{ $book->title }}</td>
</tr>

<tr>
    <td>Penulis</td>
    <td>: {{ $book->author ?? '-' }}</td>
</tr>

<tr>
    <td>ISBN</td>
    <td>: {{ $book->isbn ?? '-' }}</td>
</tr>

<tr>
    <td>Editor</td>
    <td>: {{ $book->editor ?? '-' }}</td>
</tr>

<tr>
    <td>Penyunting</td>
    <td>: {{ $book->penyunting ?? '-' }}</td>
</tr>

<tr>
    <td>Tahun Terbit</td>
    <td>: {{ $book->year ?? '-' }}</td>
</tr>

</table>

</div>
</div>

<div class="mb-4">

<h5 class="fw-bold mb-3">
Deskripsi Buku
</h5>

<p style="line-height: 1.8;">
{{ $book->description ?? 'Deskripsi buku belum tersedia.' }}
</p>

</div>

<div class="d-flex gap-2">

<a href="/payment/book/{{ $book->id }}"
   class="btn btn-primary btn-lg">
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

</div>
</section>

<footer style="background:#003153; color:white;">

    <div class="container py-5">

        <div class="row g-4">

            {{-- Brand --}}
            <div class="col-md-4">

                <h4 class="fw-bold mb-3">
                    Tartila Press
                </h4>

                <p style="color:#d6d6d6; line-height:1.8;">
                    Penerbit independen yang berfokus pada penerbitan buku
                    berkualitas, pengembangan literasi, dan distribusi karya
                    penulis Indonesia secara profesional.
                </p>

            </div>

            {{-- Kontak --}}
            <div class="col-md-4">

                <h5 class="fw-bold mb-3">
                    Kontak
                </h5>

                <p class="mb-2">
                    📧 Email:
                    <br>
                    tartilapress@gmail.com
                </p>

                <p class="mb-2">
                    📱 WhatsApp:
                    <br>
                    +62 812-7034-8598
                </p>

                <p class="mb-0">
                    📍 Indonesia
                </p>

            </div>

            {{-- Sosial Media --}}
            <div class="col-md-4">

                <h5 class="fw-bold mb-3">
                    Sosial Media
                </h5>

                <div class="d-flex flex-column gap-2">

                    <a href="https://instagram.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        Instagram
                    </a>

                    <a href="https://facebook.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        Facebook
                    </a>

                    <a href="https://tiktok.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        TikTok
                    </a>

                    <a href="https://youtube.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        YouTube
                    </a>

                </div>

            </div>

        </div>

        <hr style="border-color:rgba(255,255,255,0.2);" class="my-4">

        <div class="text-center">

            <small style="color:#d6d6d6;">
                © 2026 Tartila Press —
                Menata Ilmu, Menguatkan Peradaban.
            </small>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>