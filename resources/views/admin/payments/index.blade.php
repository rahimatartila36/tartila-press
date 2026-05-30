@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    <h2>Data Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

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
                    @forelse($payments as $payment)

                        @php
                            $jenis = '-';
                            $itemName = '-';
                            $harga = 0;
                            $diskon = 0;

                            if ($payment->type === 'package') {
                                $jenis = 'Paket Penerbitan';
                                $itemName = $payment->package->name ?? '-';
                                $harga = $payment->package->price ?? 0;
                                $diskon = $payment->package->discount ?? 0;

                            } elseif ($payment->type === 'book') {
                                $jenis = 'Buku';
                                $itemName = $payment->book->title ?? '-';
                                $harga = $payment->book->harga ?? 0;
                                $diskon = $payment->book->diskon ?? 0;

                            } elseif ($payment->type === 'order') {
                                $jenis = 'Checkout Buku';
                                $itemName = 'Order #' . ($payment->order_id ?? '-');
                                $harga = $payment->order->total_price ?? 0;
                                $diskon = 0;

                            } elseif ($payment->type === 'book_chapter') {
                                $jenis = 'Book Chapter';

                                $chapter = $payment->bookChapterItem;
                                $bookChapter = $chapter ? $chapter->bookChapter : null;
                                $package = $bookChapter ? $bookChapter->package : null;

                                $itemName = ($chapter->chapter_title ?? '-') . ' - ' . ($bookChapter->title ?? '-');

                                $harga = ($chapter && $chapter->price)
                                    ? $chapter->price
                                    : ($package ? $package->price : 0);

                                $diskon = ($chapter && $chapter->discount > 0)
                                    ? $chapter->discount
                                    : ($package ? $package->discount : 0);
                            }

                            $total = $harga - ($harga * $diskon / 100);
                        @endphp

                        <tr>
                            <td>{{ $payment->name }}</td>

                            <td>
                                @if($payment->type === 'package')
                                    <span class="badge bg-primary">{{ $jenis }}</span>
                                @elseif($payment->type === 'book')
                                    <span class="badge bg-success">{{ $jenis }}</span>
                                @elseif($payment->type === 'order')
                                    <span class="badge bg-info text-dark">{{ $jenis }}</span>
                                @elseif($payment->type === 'book_chapter')
                                    <span class="badge bg-warning text-dark">{{ $jenis }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $jenis }}</span>
                                @endif
                            </td>

                            <td>{{ $itemName }}</td>

                            <td>{{ $payment->phone }}</td>

                            <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>

                            <td>{{ $diskon }}%</td>

                            <td>
                                <strong>
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </strong>
                            </td>

                            <td>
                                @if($payment->proof)
                                    <img src="{{ asset('payments/' . $payment->proof) }}"
                                         width="80"
                                         style="cursor:pointer; border-radius:6px;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#proofModal{{ $payment->id }}">

                                    <div class="modal fade" id="proofModal{{ $payment->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Bukti Pembayaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('payments/' . $payment->proof) }}"
                                                         style="max-width:100%; max-height:80vh; object-fit:contain;">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <form action="/admin/payments/{{ $payment->id }}/status" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status" class="form-select mb-2">
                                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="belum bayar" {{ $payment->status == 'belum bayar' ? 'selected' : '' }}>
                                            Belum Bayar
                                        </option>

                                        <option value="sudah bayar" {{ $payment->status == 'sudah bayar' ? 'selected' : '' }}>
                                            Sudah Bayar
                                        </option>

                                        <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>
                                            Ditolak
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

                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection