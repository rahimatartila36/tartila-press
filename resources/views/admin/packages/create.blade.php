@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Paket Penerbitan
            </h5>

        </div>

        <div class="card-body">

            <form method="POST"
            action="/admin/packages"
            enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Nama Paket</label>

                        <input type="text"
                        name="name"
                        class="form-control"
                        required>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Kategori</label>

                        <select name="category"
                        class="form-control">

                        <option value="Individu">
                        Individu
                        </option>

                        <option value="Bersama">
                        Bersama
                        </option>

                        <option value="Book Chapter">
                        Book Chapter
                        </option>

                        <option value="Konversi">
                        Konversi
                        </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Harga</label>

                        <input type="number"
                        name="price"
                        class="form-control"
                        required>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Diskon (%)</label>

                        <input type="number"
                        name="discount"
                        class="form-control"
                        value="0">

                    </div>

                </div>

            </div>

            <div class="mb-3">

                <label>Deskripsi</label>

                <textarea
                name="description"
                class="form-control"
                rows="4"></textarea>

            </div>

            <div class="mb-3">

                <label>Gambar Paket</label>

                <input type="file"
                name="image"
                class="form-control">

            </div>

            <div class="mt-3">

                <button
                class="btn btn-success">

                Simpan Paket

                </button>

                <a href="/admin/packages"
                class="btn btn-secondary">

                Kembali

                </a>

            </div>

            </form>

        </div>

    </div>

</div>

@endsection