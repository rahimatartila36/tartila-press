<section id="books" class="py-5 bg-light">

<div class="container">

<h2 class="text-center mb-5">

Katalog Buku

</h2>

<div class="row">

@forelse($books as $book)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
class="card-img-top">

<div class="card-body">

<h6>{{ $book->title }}</h6>

<p class="text-muted">
{{ $book->author }}
</p>

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