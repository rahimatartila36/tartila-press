@extends('layouts.admin')

@section('content')

<h2 class="mb-4">
    Dashboard Admin — Tartila Press
</h2>

<div class="row g-4 mb-5">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Total Buku</h5>
                <h3>{{ \App\Models\Book::count() }}</h3>

                <a href="/admin/books" class="btn btn-primary btn-sm mt-2">
                    Kelola Buku
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Paket Penerbitan</h5>
                    <h3>{{ \App\Models\Package::count() }}</h3>

                    <a href="/admin/packages" class="btn btn-primary btn-sm mt-2">
                        Kelola Paket
                    </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Pembayaran</h5>
            <h3>{{ \App\Models\Payment::count() }}</h3>

            <a href="/admin/payments" class="btn btn-primary btn-sm mt-2">
                Cek Pembayaran
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Book Chapter</h5>
            <h3>{{ \App\Models\BookChapter::count() }}</h3>

            <a href="/admin/book-chapters" class="btn btn-primary btn-sm mt-2">
                Kelola Book Chapter
            </a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Naskah</h5>

            <a href="{{ route('admin.submissions.index') }}" class="btn btn-primary">
                Cek Naskah
            </a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
         
            <a href="{{ route('admin.users.index') }}" class="btn btn-success">
                List User
            </a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
         
            <a href="{{ route('admin.royalties.index') }}" class="btn btn-warning">
                Royalti Penulis
            </a>
        </div>
    </div>
</div>
</div>



<h4 class="mb-3">
    Verifikasi Pembayaran
</h4>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Paket</th>
                    <th>No HP</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>

            <tbody>
    @forelse(\App\Models\Payment::with(['package', 'book'])->latest()->take(5)->get() as $payment)
        <tr>
            <td>{{ $payment->name }}</td>

            <td>
                @if($payment->type == 'book' || $payment->type == 'buku')
                    {{ $payment->book->title ?? 'Buku Fisik / Ebook' }}
                @else
                    {{ $payment->package->name ?? 'Paket Penerbitan' }}
                @endif
            </td>

            <td>{{ $payment->phone }}</td>

            <td>
                @if($payment->proof)
                    <img src="{{ asset('payments/' . $payment->proof) }}" 
                        width="80"
                        style="cursor:pointer"
                        data-bs-toggle="modal" 
                        data-bs-target="#proofModal{{ $payment->id }}">
                @else
                    -
                @endif
            </td>

            <td>
                <form action="/admin/payments/{{ $payment->id }}/status" method="POST">
                    @csrf
                    @method('PUT')

                    <select name="status" class="form-select form-select-sm mb-2">
                        <option value="belum bayar" {{ $payment->status == 'belum bayar' ? 'selected' : '' }}>
                            Belum Bayar
                        </option>

                        <option value="sudah bayar" {{ $payment->status == 'sudah bayar' ? 'selected' : '' }}>
                            Sudah Bayar
                        </option>
                    </select>

                    <button type="submit" class="btn btn-success btn-sm w-100">
                        Update
                    </button>
                </form>
            </td>

            <td>
                <form action="/admin/payments/{{ $payment->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin hapus data pembayaran ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

            <div class="modal fade" id="proofModal{{ $payment->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Bukti Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">
                           <img src="{{ asset('payments/' . $payment->proof) }}" class="img-fluid">
                        </div>

                    </div>
                </div>
            </div>
    @empty
        <tr>
            <td colspan="6" class="text-center">
                Belum ada data pembayaran.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>

    </div>
</div>

@endsection