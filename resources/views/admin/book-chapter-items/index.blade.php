@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Kelola Bab</h3>
            <p class="text-muted mb-0">
                Buku: <strong>{{ $bookChapter->title }}</strong>
            </p>
        </div>

        <a href="/admin/book-chapters" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <strong>Tambah Bab Baru</strong>
        </div>

        <div class="card-body">
            <form action="/admin/book-chapters/{{ $bookChapter->id }}/items" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Judul Bab</label>
                        <input type="text" name="chapter_title" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Diskon (%)</label>
                        <input type="number" name="discount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="available">Tersedia</option>
                            <option value="pending">Pending</option>
                            <option value="sold">Terjual</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary">
                    Simpan Bab
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Daftar Bab</strong>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Bab</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Harga Akhir</th>
                        <th>Status</th>
                        <th width="260">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookChapter->items as $item)
                        <tr>
                            <form action="/admin/book-chapter-items/{{ $item->id }}" method="POST">
                                @csrf
                                @method('PUT')

                                <td>
                                    <input type="text"
                                           name="chapter_title"
                                           class="form-control"
                                           value="{{ $item->chapter_title }}"
                                           required>
                                </td>

                                <td>
                                    <input type="number"
                                           name="price"
                                           class="form-control"
                                           value="{{ $item->price }}"
                                           >
                                </td>

                                <td>
                                    <input type="number"
                                           name="discount"
                                           class="form-control"
                                           value="{{ $item->discount }}">
                                </td>

                                <td>
                                    Rp {{ number_format($item->final_price, 0, ',', '.') }}
                                </td>

                                <td>
                                    <select name="status" class="form-select">
                                        <option value="available" {{ $item->status == 'available' ? 'selected' : '' }}>
                                            Tersedia
                                        </option>

                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="sold" {{ $item->status == 'sold' ? 'selected' : '' }}>
                                            Terjual
                                        </option>
                                    </select>
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        Update
                                    </button>
                            </form>

                                    <form action="/admin/book-chapter-items/{{ $item->id }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus bab ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada bab untuk buku ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection