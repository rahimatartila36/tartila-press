@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Tambah Book Chapter</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="/admin/book-chapters" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cover Buku</label>
                    <input type="file" name="cover" class="form-control">
                    <small class="text-muted">
                        Format: jpg, jpeg, png, webp. Maksimal 2MB.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Paket Book Chapter</label>
                    <select name="package_id" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>

                        @foreach($packages as $package)
                            <option value="{{ $package->id }}"
                                {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                                - Rp {{ number_format($package->price, 0, ',', '.') }}
                                @if($package->discount)
                                    - Diskon {{ $package->discount }}%
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <small class="text-muted">
                        Harga dan diskon bab akan mengikuti paket yang dipilih, kecuali jika nanti diatur manual pada kelola bab.
                    </small>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text"
                               name="category"
                               class="form-control"
                               value="{{ old('category', 'Book Chapter') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bidang Keilmuan</label>
                        <input type="text"
                               name="field"
                               class="form-control"
                               value="{{ old('field') }}"
                               placeholder="Contoh: Pendidikan, Ekonomi, Teknologi">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Perkiraan Terbit</label>
                    <input type="text"
                           name="estimated_publish"
                           class="form-control"
                           value="{{ old('estimated_publish') }}"
                           placeholder="Contoh: Juli 2026">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Buku</label>
                    <textarea name="description"
                              class="form-control"
                              rows="5"
                              placeholder="Tulis deskripsi umum buku Book Chapter ini">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="/admin/book-chapters" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection