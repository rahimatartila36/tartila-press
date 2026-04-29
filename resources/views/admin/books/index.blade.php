@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Daftar Buku</h2>
            <p class="text-muted mb-0">Kelola data buku Tartila Press</p>
        </div>

        <a href="/admin/books/create" class="btn btn-primary">
            + Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="90">Cover</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>
                                    @if($book->cover)
                                        <img src="{{ asset('storage/'.$book->cover) }}"
                                             width="55"
                                             height="75"
                                             style="object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $book->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        ISBN: {{ $book->isbn ?? '-' }}
                                    </small>
                                </td>

                                <td style="white-space: pre-line;">
                                    {{ $book->author }}
                                </td>

                                <td>
                                    {{ $book->tahun_terbit ?? $book->year ?? '-' }}
                                </td>

                                <td>
                                    @if($book->harga)
                                        Rp {{ number_format($book->harga, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($book->diskon > 0)
                                        <span class="badge bg-success">
                                            {{ $book->diskon }}%
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="/admin/books/{{ $book->id }}/edit"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="/admin/books/{{ $book->id }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus buku ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection