@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h3 class="fw-bold mb-4" style="color:#1D3557;">
        Upload Naskah Penerbitan
    </h3>

    <form action="{{ route('publishing-submissions.update', $submission->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Data Buku</h5>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text"
                           name="book_title"
                           class="form-control"
                           value="{{ old('book_title', $submission->book_title) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Naskah</label>
                    <input type="file"
                           name="manuscript_file"
                           class="form-control"
                           accept=".pdf,.doc,.docx">

                    @if($submission->manuscript_file)
                        <small class="text-muted">
                            File sebelumnya sudah diupload.
                        </small>
                    @endif
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Data Penulis</h5>
                        <p class="text-muted small mb-0">
                            Isi penulis pertama. Jika penulis lebih dari satu, klik tombol tambah penulis.
                        </p>
                    </div>

                    <button type="button"
                            class="btn btn-sm btn-success"
                            onclick="addAuthor()">
                        + Tambah Penulis
                    </button>
                </div>

                <div id="authors-wrapper">

                    @forelse($submission->authors as $i => $author)

                        <div class="author-card border rounded-3 p-3 mb-3">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">
                                    Penulis {{ $i + 1 }}
                                </h6>

                                @if($i > 0)
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="this.closest('.author-card').remove()">
                                        Hapus
                                    </button>
                                @endif
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text"
                                           name="authors[{{ $i }}][name]"
                                           class="form-control"
                                           value="{{ old("authors.$i.name", $author->name ?? '') }}"
                                           {{ $i === 0 ? 'required' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No HP</label>
                                    <input type="text"
                                           name="authors[{{ $i }}][phone]"
                                           class="form-control"
                                           value="{{ old("authors.$i.phone", $author->phone ?? '') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text"
                                           name="authors[{{ $i }}][nik]"
                                           class="form-control"
                                           value="{{ old("authors.$i.nik", $author->nik ?? '') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           name="authors[{{ $i }}][email]"
                                           class="form-control"
                                           value="{{ old("authors.$i.email", $author->email ?? '') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="authors[{{ $i }}][address]"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Negara, Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan, Jalan, RT/RW, Kode Pos">{{ old("authors.$i.address", $author->address ?? '') }}</textarea>
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="author-card border rounded-3 p-3 mb-3">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">
                                    Penulis 1
                                </h6>
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text"
                                           name="authors[0][name]"
                                           class="form-control"
                                           value="{{ old('authors.0.name') }}"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No HP</label>
                                    <input type="text"
                                           name="authors[0][phone]"
                                           class="form-control"
                                           value="{{ old('authors.0.phone') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text"
                                           name="authors[0][nik]"
                                           class="form-control"
                                           value="{{ old('authors.0.nik') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           name="authors[0][email]"
                                           class="form-control"
                                           value="{{ old('authors.0.email') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="authors[0][address]"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Negara, Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan, Jalan, RT/RW, Kode Pos">{{ old('authors.0.address') }}</textarea>
                                </div>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary px-4">
            Kirim Naskah
        </button>

        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
            Kembali
        </a>

    </form>

</div>

<script>
    let authorIndex = {{ max($submission->authors->count(), 1) }};

    function addAuthor() {
        let html = `
            <div class="author-card border rounded-3 p-3 mb-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        Penulis ${authorIndex + 1}
                    </h6>

                    <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="this.closest('.author-card').remove()">
                        Hapus
                    </button>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text"
                               name="authors[${authorIndex}][name]"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <input type="text"
                               name="authors[${authorIndex}][phone]"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text"
                               name="authors[${authorIndex}][nik]"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="authors[${authorIndex}][email]"
                               class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="authors[${authorIndex}][address]"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Negara, Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan, Jalan, RT/RW, Kode Pos"></textarea>
                    </div>

                </div>

            </div>
        `;

        document.getElementById('authors-wrapper').insertAdjacentHTML('beforeend', html);

        authorIndex++;
    }
</script>

@endsection