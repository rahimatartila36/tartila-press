@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">Detail Submission Naskah</h3>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Data Buku</h5>

        <p><strong>User:</strong> {{ $submission->user->name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $submission->user->email ?? '-' }}</p>
        <p><strong>Paket:</strong> {{ $submission->package->name ?? '-' }}</p>
        <p><strong>Judul Buku:</strong> {{ $submission->book_title ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $submission->status }}</p>

        <p>
            <strong>Naskah:</strong>
            @if($submission->manuscript_file)
                <a href="{{ asset('storage/' . $submission->manuscript_file) }}"
                    target="_blank"
                    class="btn btn-sm btn-primary">
                        Download / Lihat Naskah
                    </a>
            @else
                <span class="text-muted">Belum upload</span>
            @endif
        </p>

    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Data Penulis</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>Alamat Lengkap</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($submission->authors as $author)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $author->name ?? '-' }}</td>
                            <td>{{ $author->phone ?? '-' }}</td>
                            <td>{{ $author->nik ?? '-' }}</td>
                            <td>{{ $author->email ?? '-' }}</td>
                            <td>{{ $author->address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data penulis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.submissions.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>

    </div>
</div>

@endsection