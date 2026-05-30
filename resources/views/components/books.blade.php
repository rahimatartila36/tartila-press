<section id="books" class="py-5 bg-light">

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Katalog Buku
            </h2>

            <p class="text-muted mb-0">
                Pilihan buku terbaru dari Tartila Press
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">

            <a href="{{ route('books.catalog') }}"
               class="btn btn-outline-primary btn-sm px-3">
                Lihat Semua
            </a>

            <button class="btn btn-light border rounded-circle shadow-sm"
                    onclick="slideBooks(-1)"
                    style="width:40px; height:40px;">
                ‹
            </button>

            <button class="btn btn-primary rounded-circle shadow-sm"
                    onclick="slideBooks(1)"
                    style="width:40px; height:40px;">
                ›
            </button>

        </div>

    </div>

    <div class="book-slider" id="bookSlider">

        @forelse($books as $book)

        <div class="book-slide-item">

            <div class="card h-100 shadow-sm border-0">

                <a href="/books/{{ $book->id }}" class="text-decoration-none text-dark">

                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                         class="card-img-top"
                         style="height:320px; object-fit:cover;">

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

                        <button type="submit" class="btn btn-outline-secondary w-100">
                            + Keranjang
                        </button>
                    </form>

                </div>

            </div>

        </div>

        @empty

        <p class="text-center w-100">
            Belum ada buku
        </p>

        @endforelse

    </div>

</div>

<style>
.book-slider{
    display:flex;
    gap:24px;
    overflow:hidden;
    scroll-behavior:smooth;
    padding-bottom:10px;
}

.book-slide-item{
    min-width:260px;
    max-width:260px;
    flex-shrink:0;
}

.book-slide-item .card{
    height:100%;
}
</style>

<script>
function slideBooks(direction){
    const slider = document.getElementById('bookSlider');
    const scrollAmount = 300;

    slider.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>

</section>