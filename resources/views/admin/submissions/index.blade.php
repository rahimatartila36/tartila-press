@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">Cek Naskah Penerbitan</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Paket</th>
                    <th>Judul Buku</th>
                    <th>Naskah</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th width="260">Update Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $submission->user->name ?? '-' }} <br>
                            <small class="text-muted">
                                {{ $submission->user->email ?? '-' }}
                            </small>
                        </td>

                        <td>{{ $submission->package->name ?? '-' }}</td>

                        <td>{{ $submission->book_title ?? '-' }}</td>

                        <td>
                            @if($submission->manuscript_file)
                                <a href="{{ asset('storage/' . $submission->manuscript_file) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                        Lihat Naskah
                                    </a>
                            @else
                                <span class="badge bg-secondary">Belum upload</span>
                            @endif
                        </td>

                        <td>
                            {{ $submission->authors->count() }} Penulis
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ $submission->status }}
                            </span>
                        </td>

                        <td>
                            <form action="{{ route('admin.submissions.update-status', $submission->id) }}"
                                  method="POST"
                                  class="d-flex gap-2">
                                @csrf
                                @method('PUT')

                                <select name="status" class="form-select form-select-sm">
                                    <option value="menunggu_upload_naskah" {{ $submission->status == 'menunggu_upload_naskah' ? 'selected' : '' }}>
                                        Menunggu Upload Naskah
                                    </option>
                                    <option value="naskah_diterima" {{ $submission->status == 'naskah_diterima' ? 'selected' : '' }}>
                                        Naskah Diterima
                                    </option>
                                    <option value="proses_editing" {{ $submission->status == 'proses_editing' ? 'selected' : '' }}>
                                        Proses Editing
                                    </option>
                                    <option value="pengajuan_isbn" {{ $submission->status == 'pengajuan_isbn' ? 'selected' : '' }}>
                                        Pengajuan ISBN
                                    </option>
                                    <option value="isbn_terbit" {{ $submission->status == 'isbn_terbit' ? 'selected' : '' }}>
                                        ISBN Terbit
                                    </option>
                                    <option value="proses_cetak" {{ $submission->status == 'proses_cetak' ? 'selected' : '' }}>
                                        Proses Cetak
                                    </option>
                                    <option value="selesai" {{ $submission->status == 'selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                </select>

                                <button class="btn btn-sm btn-primary">
                                    Simpan
                                </button>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('admin.submissions.show', $submission->id) }}"
                               class="btn btn-sm btn-outline-dark">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Belum ada submission naskah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection