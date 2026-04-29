@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Edit Buku</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="/admin/books/{{ $book->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Penulis</label>
                            <textarea name="author" class="form-control" rows="3">{{ $book->author }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}">
                        </div>

                        <div class="mb-3">
                            <label>Editor</label>
                            <textarea name="editor" class="form-control" rows="2">{{ $book->editor }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Penyunting</label>
                            <input type="text" name="penyunting" class="form-control" value="{{ $book->penyunting }}">
                        </div>

                        <div class="mb-3">
                            <label>Desain Sampul & Tata Letak</label>
                            <input type="text" name="desain" class="form-control" value="{{ $book->desain }}">
                        </div>

                        <div class="mb-3">
                            <label>Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="{{ $book->penerbit }}">
                        </div>

                        <div class="mb-3">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="{{ $book->kategori }}">
                        </div>

                        <div class="mb-3">
                            <label>Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" value="{{ $book->tahun_terbit }}">
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="{{ $book->harga }}">
                        </div>

                        <div class="mb-3">
                            <label>Diskon (%)</label>
                            <input type="number" name="diskon" class="form-control" value="{{ $book->diskon }}">
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ $book->description }}</textarea>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">
                            <label>Cover Saat Ini</label><br>

                            @if($book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}"
                                     class="img-fluid rounded shadow-sm mb-2">
                            @else
                                <p class="text-muted">Tidak ada cover</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label>Ganti Cover</label>
                            <input type="file" name="cover" class="form-control">
                        </div>

                    </div>

                </div>

                <div class="mt-3">
                    <button class="btn btn-success">
                        Update
                    </button>

                    <a href="/admin/books" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection