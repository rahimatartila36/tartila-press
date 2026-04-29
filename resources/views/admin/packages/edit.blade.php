@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Edit Paket Penerbitan
            </h5>

        </div>

        <div class="card-body">

            <form method="POST"
            action="/admin/packages/{{ $package->id }}"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Nama Paket</label>

                        <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ $package->name }}"
                        required>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Kategori</label>

                        <select name="category"
                        class="form-control">

                        <option value="Individu"
                        {{ $package->category=='Individu' ? 'selected':'' }}>
                        Individu
                        </option>

                        <option value="Bersama"
                        {{ $package->category=='Bersama' ? 'selected':'' }}>
                        Bersama
                        </option>

                        <option value="Book Chapter"
                        {{ $package->category=='Book Chapter' ? 'selected':'' }}>
                        Book Chapter
                        </option>

                        <option value="Konversi"
                        {{ $package->category=='Konversi' ? 'selected':'' }}>
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
                        value="{{ $package->price }}"
                        required>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">

                        <label>Diskon (%)</label>

                        <input type="number"
                        name="discount"
                        class="form-control"
                        value="{{ $package->discount }}">

                    </div>

                </div>

            </div>

            <div class="mb-3">

                <label>Deskripsi</label>

                <textarea
                name="description"
                class="form-control"
                rows="4">

{{ $package->description }}

                </textarea>

            </div>

            <div class="mb-3">

                <label>Gambar Saat Ini</label>

                <br>

                @if($package->image)

                <img
                src="/packages/{{ $package->image }}"
                width="120"
                class="rounded shadow-sm mb-2">

                @endif

                <input type="file"
                name="image"
                class="form-control">

            </div>

            <div class="mt-3">

                <button
                class="btn btn-success">

                Update Paket

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