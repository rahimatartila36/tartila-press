@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Book Chapter</h3>

        <a href="/admin/book-chapters/create" class="btn btn-primary">
            + Tambah Book Chapter
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cover</th>
                        <th>Judul Buku</th>
                        <th>Bidang</th>
                        <th>Kategori</th>
                        <th>Perkiraan Terbit</th>
                        <th>Jumlah Bab</th>
                        <th width="230">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookChapters as $item)
                        <tr>
                            <td>
                                @if($item->cover)
                                    <img src="{{ asset('book-chapters/' . $item->cover) }}"
                                         style="width:70px; height:90px; object-fit:cover; border-radius:6px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            <td>{{ $item->title }}</td>

                            <td>{{ $item->field ?? '-' }}</td>

                            <td>{{ $item->category ?? '-' }}</td>

                            <td>{{ $item->estimated_publish ?? '-' }}</td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $item->items_count }} Bab
                                </span>
                            </td>

                            <td>
                                <a href="/admin/book-chapters/{{ $item->id }}/items"
                                   class="btn btn-sm btn-info text-white mb-1">
                                    Kelola Bab
                                </a>

                                <a href="/admin/book-chapters/{{ $item->id }}/edit"
                                   class="btn btn-sm btn-warning mb-1">
                                    Edit
                                </a>

                                <form action="/admin/book-chapters/{{ $item->id }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini? Semua bab di dalamnya juga akan terhapus.')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger mb-1">
                                        Hapus
                                    </button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada data Book Chapter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection