@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">Tambah Royalti Penulis</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.royalties.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Penulis/User</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} - {{ $user->email }} - {{ $user->role ?? 'user' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text"
                       name="book_title"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Buku Terjual</label>
                <input type="number"
                       name="sold_qty"
                       class="form-control"
                       value="0"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Penjualan</label>
                <input type="number"
                       name="total_sales"
                       class="form-control"
                       value="0"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Persen Royalti</label>
                <input type="number"
                       name="royalty_percent"
                       class="form-control"
                       value="30"
                       min="0"
                       max="100"
                       step="0.01"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Pembayaran Royalti</label>
                <select name="status" class="form-select" required>
                    <option value="belum_dibayar">Belum Dibayar</option>
                    <option value="sudah_dibayar">Sudah Dibayar</option>
                </select>
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('admin.royalties.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection