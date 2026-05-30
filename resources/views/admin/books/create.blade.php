@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Tambah Buku</h2>
            <p class="text-muted mb-0">Lengkapi data buku yang akan ditampilkan.</p>
        </div>

        <a href="/admin/books" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>

    <form action="/admin/books" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>Informasi Buku</strong>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <textarea name="author" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ISBN</label>
                                <input type="text" name="isbn" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>

                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white">
                        <strong>Detail Produksi</strong>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Editor</label>
                                <textarea name="editor" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Penyunting</label>
                                <input type="text" name="penyunting" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Desain Sampul & Tata Letak</label>
                                <input type="text" name="desain" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Kategori Buku</label>

                                <input type="text"
                                    name="kategori"
                                    class="form-control"
                                    placeholder="Contoh: Buku Ajar, Novel, Referensi">
                            </div>

                            <div class="mb-3">
                                <label>Kategori Keilmuan</label>

                                <input type="text"
                                    name="keilmuan"
                                    class="form-control"
                                    placeholder="Contoh: Pendidikan Matematika, PGSD">
</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>Harga & Cover</strong>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Harga Buku</label>
                            <input type="number" name="harga" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diskon (%)</label>
                            <input type="number" name="diskon" class="form-control" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover</label>
                            <input type="file" name="cover" class="form-control">
                        </div>

                        <button class="btn btn-success w-100">
                            Simpan Buku
                        </button>

                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

@endsection