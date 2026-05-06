@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    <h2>Data Pembayaran</h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Item</th>
                        <th>No HP</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th>Bukti Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payments as $payment)
                        @php
                            if ($payment->type == 'book' || $payment->type == 'buku') {
                                $item = $payment->book;
                                $jenis = 'Buku Fisik / Ebook';
                            } else {
                                $item = $payment->package;
                                $jenis = 'Paket Penerbitan';
                            }

                            $harga = $item->price ?? 0;
                            $diskon = $item->discount ?? 0;
                            $total = $harga - ($harga * $diskon / 100);
                        @endphp

                        <tr>
                            <div class="modal fade" id="proofModal{{ $payment->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            <img src="{{ asset('payments/' . $payment->proof) }}"
                                                style="max-width: 100%; max-height: 80vh; object-fit: contain;">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <td>{{ $payment->name }}</td>
                            <td>{{ $jenis }}</td>
                            <td>{{ $item->title ?? $item->name ?? '-' }}</td>
                            <td>{{ $payment->phone }}</td>

                            <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td>{{ $diskon }}%</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>

                            <td>
                                @if($payment->proof)
                                     <img src="{{ asset('payments/' . $payment->proof) }}"
                                        width="80"
                                        style="cursor:pointer; border-radius:6px;"
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

                                    <select name="status" class="form-select mb-2">
                                        <option value="belum bayar" {{ $payment->status == 'belum bayar' ? 'selected' : '' }}>
                                            Belum Bayar
                                        </option>
                                        <option value="sudah bayar" {{ $payment->status == 'sudah bayar' ? 'selected' : '' }}>
                                            Sudah Bayar
                                        </option>
                                    </select>

                                    <button class="btn btn-success btn-sm w-100">
                                        Update
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form action="/admin/payments/{{ $payment->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus data pembayaran ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection