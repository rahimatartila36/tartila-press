@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">Edit Royalti Penulis</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.royalties.update', $royalty->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Penulis/User</label>
                <select name="user_id" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $royalty->user_id == $user->id ? 'selected' : '' }}>
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
                       value="{{ $royalty->book_title }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Buku Terjual</label>
                <input type="number"
                       name="sold_qty"
                       class="form-control"
                       value="{{ $royalty->sold_qty }}"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Penjualan</label>
                <input type="number"
                       name="total_sales"
                       class="form-control"
                       value="{{ $royalty->total_sales }}"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Persen Royalti</label>
                <input type="number"
                       name="royalty_percent"
                       class="form-control"
                       value="{{ $royalty->royalty_percent }}"
                       min="0"
                       max="100"
                       step="0.01"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Pembayaran Royalti</label>
                <select name="status" class="form-select" required>
                    <option value="belum_dibayar" {{ $royalty->status === 'belum_dibayar' ? 'selected' : '' }}>
                        Belum Dibayar
                    </option>
                    <option value="sudah_dibayar" {{ $royalty->status === 'sudah_dibayar' ? 'selected' : '' }}>
                        Sudah Dibayar
                    </option>
                </select>
            </div>

            <button class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('admin.royalties.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection