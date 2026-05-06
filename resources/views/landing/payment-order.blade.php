<x-app-layout>

<div class="container py-5">

    <h3 class="fw-bold mb-4">Pembayaran Order</h3>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold">Ringkasan Pesanan</h5>

            @foreach($order->items as $item)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>{{ $item->book->title ?? '-' }} x {{ $item->qty }}</span>
                    <strong>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</strong>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-3">
                <h5>Total</h5>
                <h5 class="text-danger">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </h5>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold">Upload Bukti Pembayaran</h5>

            <form action="{{ route('payment.store.order', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Nama Pengirim</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Bukti Pembayaran</label>
                    <input type="file" name="proof" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>
    </div>

</div>

</x-app-layout>