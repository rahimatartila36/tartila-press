<x-app-layout>

<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Keranjang Saya</h2>
        <p class="text-muted">Pilih buku yang ingin kamu checkout.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->count() > 0)

        <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="row g-4">

                <div class="col-lg-8">

                    @foreach($carts as $cart)
                        @php
                            $price = $cart->book->harga ?? 0;
                            $subtotal = $price * $cart->qty;
                        @endphp

                        <div class="card shadow-sm border-0 mb-3 cart-item"
                             data-price="{{ $cart->book->harga ?? 0 }}"
                             data-qty="{{ $cart->qty }}">

                            <div class="card-body">
                                <div class="row align-items-center g-3">

                                    <div class="col-auto">
                                        <input type="checkbox"
                                               name="cart_ids[]"
                                               value="{{ $cart->id }}"
                                               class="form-check-input cart-check"
                                               checked>
                                    </div>

                                    <div class="col-auto">
                                        @if($cart->book && $cart->book->cover)
                                            <img src="{{ asset('storage/' . $cart->book->cover) }}"
                                                 style="width: 90px; height: 120px; object-fit: cover; border-radius: 10px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 90px; height: 120px; border-radius: 10px;">
                                                <span class="text-muted small">No Cover</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col">
                                        <h5 class="fw-bold mb-1">
                                            {{ $cart->book->title ?? '-' }}
                                        </h5>

                                        <p class="text-muted mb-2">
                                            {{ $cart->book->author ?? 'Penulis tidak diketahui' }}
                                        </p>

                                        <div class="fw-semibold text-danger">
                                            Rp {{ number_format($price, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="small text-muted mb-1">
                                            Jumlah:
                                        </div>

                                        <input type="number"
                                               value="{{ $cart->qty }}"
                                               class="form-control form-control-sm text-center"
                                               readonly>

                                        <div class="small text-muted mt-2">
                                            Subtotal:
                                            <strong>
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit"
                                                form="delete-cart-{{ $cart->id }}"
                                                class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 90px;">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Item Dipilih</span>
                                <strong id="selectedCount">0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Harga</span>
                                <strong class="text-danger fs-5" id="selectedTotal">
                                    Rp 0
                                </strong>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                Checkout Sekarang
                            </button>

                            <a href="/" class="btn btn-outline-secondary w-100 mt-2">
                                Lanjut Belanja
                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </form>

        @foreach($carts as $cart)
            <form id="delete-cart-{{ $cart->id }}"
                  action="{{ route('cart.destroy', $cart->id) }}"
                  method="POST"
                  style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

    @else

        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h5 class="fw-bold">Keranjang masih kosong</h5>
                <p class="text-muted">Silakan pilih buku terlebih dahulu.</p>

                <a href="/" class="btn btn-primary">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    @endif

</div>

<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function updateTotal() {
        let total = 0;
        let count = 0;

        document.querySelectorAll('.cart-item').forEach(function(item) {

            const checkbox = item.querySelector('.cart-check');

            if (checkbox && checkbox.checked) {

                const price = parseInt(item.getAttribute('data-price')) || 0;
                const qty = parseInt(item.getAttribute('data-qty')) || 1;

                total += price * qty;
                count++;
            }
        });

        document.getElementById('selectedTotal').innerText =
            'Rp ' + formatRupiah(total);

        document.getElementById('selectedCount').innerText = count;
    }

    document.querySelectorAll('.cart-check').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateTotal);
    });

    // jalan pertama kali
    updateTotal();
</script>

</x-app-layout>