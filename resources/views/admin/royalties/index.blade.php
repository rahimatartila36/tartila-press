@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Data Royalti Penulis</h3>

    <a href="{{ route('admin.royalties.create') }}" class="btn btn-primary">
        + Tambah Royalti
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Penulis/User</th>
                    <th>Judul Buku</th>
                    <th>Terjual</th>
                    <th>Total Penjualan</th>
                    <th>Persen Royalti</th>
                    <th>Jumlah Royalti</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($royalties as $royalty)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $royalty->user->name ?? '-' }} <br>
                            <small class="text-muted">
                                {{ $royalty->user->email ?? '-' }}
                            </small>
                        </td>

                        <td>{{ $royalty->book_title }}</td>

                        <td>{{ $royalty->sold_qty }}</td>

                        <td>
                            Rp {{ number_format($royalty->total_sales, 0, ',', '.') }}
                        </td>

                        <td>{{ $royalty->royalty_percent }}%</td>

                        <td>
                            <strong>
                                Rp {{ number_format($royalty->royalty_amount, 0, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            @if($royalty->status === 'sudah_dibayar')
                                <span class="badge bg-success">Sudah Dibayar</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Dibayar</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.royalties.edit', $royalty->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            <form action="{{ route('admin.royalties.destroy', $royalty->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data royalti ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Belum ada data royalti.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection