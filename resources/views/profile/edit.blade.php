@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color:#1D3557;">Profil Saya</h3>
        <p class="text-muted mb-0">Kelola akun, keranjang, pembelian, naskah, dan royalti Anda.</p>
    </div>

    <div class="row g-4">

        {{-- MENU KIRI --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">

                    <div class="text-center mb-4">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;background:#1D3557;color:white;font-size:26px;font-weight:bold;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="fw-bold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">{{ auth()->user()->email }}</div>
                    </div>

                    <div class="nav flex-column nav-pills gap-2" id="profileMenu" role="tablist">

                        <button class="nav-link active text-start"
                                data-bs-toggle="pill"
                                data-bs-target="#akun"
                                type="button">
                            Pengaturan Akun
                        </button>

                        <button class="nav-link text-start"
                                data-bs-toggle="pill"
                                data-bs-target="#keranjang"
                                type="button">
                            Keranjang
                        </button>

                        <button class="nav-link text-start"
                                data-bs-toggle="pill"
                                data-bs-target="#pembelian"
                                type="button">
                            Pembelian
                        </button>

                        @if(auth()->user()->role === 'penulis')
                            <button class="nav-link text-start"
                                    data-bs-toggle="pill"
                                    data-bs-target="#naskah"
                                    type="button">
                                Naskah Saya
                            </button>

                            <button class="nav-link text-start"
                                    data-bs-toggle="pill"
                                    data-bs-target="#royalti"
                                    type="button">
                                Royalti
                            </button>
                        @endif

                    </div>

                </div>
            </div>
        </div>

        {{-- KONTEN KANAN --}}
        <div class="col-lg-9">
            <div class="tab-content">

                {{-- AKUN --}}
                <div class="tab-pane fade show active" id="akun">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Pengaturan Akun</h5>

                            @include('profile.partials.update-profile-information-form')

                            <hr class="my-4">

                            @include('profile.partials.update-password-form')

                            <hr class="my-4">

                            <h5 class="fw-bold text-danger mb-3">Hapus Akun</h5>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

                {{-- KERANJANG --}}
                <div class="tab-pane fade" id="keranjang">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Keranjang Saya</h5>

                            @if(isset($carts) && $carts->count() > 0)

                                @foreach($carts as $item)
                                    <div class="border rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">
                                                    {{ $item->book->title ?? '-' }}
                                                </div>

                                                <div class="text-muted small">
                                                    Qty: {{ $item->qty }}
                                                </div>
                                            </div>

                                            <div class="fw-bold text-danger">
                                                Rp {{ number_format(($item->book->harga ?? 0) * $item->qty, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <a href="{{ route('cart.index') }}" class="btn btn-primary">
                                    Lihat Keranjang Lengkap
                                </a>

                            @else

                                <p class="text-muted">Keranjang masih kosong.</p>

                                <a href="/#books" class="btn btn-primary">
                                    Lihat Katalog Buku
                                </a>

                            @endif
                        </div>
                    </div>
                </div>

                {{-- PEMBELIAN --}}
                <div class="tab-pane fade" id="pembelian">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Pembelian Saya</h5>

                            @if(isset($orders) && $orders->count() > 0)

                                @foreach($orders as $order)
                                    <div class="border rounded-3 p-3 mb-3">

                                        <div class="d-flex justify-content-between mb-3">
                                            <div>
                                                <div class="fw-bold">
                                                    Order #{{ $order->id }}
                                                </div>

                                                <div class="text-muted small">
                                                    {{ $order->created_at->format('d M Y H:i') }}
                                                </div>
                                            </div>

                                            <span class="badge bg-primary">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>

                                        @foreach($order->items as $item)
                                            <div class="d-flex justify-content-between border-bottom py-2 small">
                                                <span>{{ $item->book_title }} x {{ $item->qty }}</span>
                                                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach

                                        <div class="d-flex justify-content-between mt-3">
                                            <strong>Total</strong>
                                            <strong class="text-danger">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </strong>
                                        </div>

                                    </div>
                                @endforeach

                            @else

                                <p class="text-muted">Belum ada pembelian buku.</p>

                            @endif
                        </div>
                    </div>
                </div>

                {{-- NASKAH --}}
                @if(auth()->user()->role === 'penulis')
                    <div class="tab-pane fade" id="naskah">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">

                                <h5 class="fw-bold mb-3">Naskah Saya</h5>

                                @forelse($submissions as $submission)

                                    <div class="border rounded-3 p-3 mb-3">

                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <div class="fw-bold">
                                                    {{ $submission->book_title ?? 'Belum mengisi judul buku' }}
                                                </div>

                                                <small class="text-muted">
                                                    Diajukan: {{ $submission->created_at->format('d M Y') }}
                                                </small>
                                            </div>

                                            <span class="badge bg-primary">
                                                {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                                            </span>
                                        </div>

                                        @if($submission->admin_note)
                                            <div class="alert alert-info py-2 small mb-2">
                                                <strong>Catatan Admin:</strong>
                                                {{ $submission->admin_note }}
                                            </div>
                                        @endif

                                        @if($submission->editor_note)
                                            <div class="alert alert-warning py-2 small mb-2">
                                                <strong>Catatan Editor:</strong>
                                                {{ $submission->editor_note }}
                                            </div>
                                        @endif

                                        <div class="mt-3 d-flex gap-2">

                                            @if($submission->status === 'menunggu_upload_naskah')
                                                <a href="{{ route('publishing-submissions.edit', $submission->id) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Upload Naskah
                                                </a>
                                            @else
                                                <a href="{{ route('publishing-submissions.edit', $submission->id) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    Lihat / Edit Data
                                                </a>
                                            @endif

                                        </div>

                                    </div>

                                @empty

                                    <p class="text-muted">
                                        Belum ada pengajuan penerbitan.
                                    </p>

                                    <a href="/#packages" class="btn btn-primary">
                                        Lihat Paket Penerbitan
                                    </a>

                                @endforelse

                            </div>
                        </div>
                    </div>
                @endif

                {{-- ROYALTI --}}
                @if(auth()->user()->role === 'penulis')
                    <div class="tab-pane fade" id="royalti">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">

                                <h5 class="fw-bold mb-3">Royalti Saya</h5>

                                @forelse($royalties as $royalty)

                                    <div class="border rounded-3 p-3 mb-3">

                                        <div class="fw-bold mb-2">
                                            {{ $royalty->book_title }}
                                        </div>

                                        <div class="row small">
                                            <div class="col-md-6 mb-2">
                                                Buku Terjual:
                                                <strong>{{ $royalty->sold_qty }}</strong>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                Royalti:
                                                <strong>{{ $royalty->royalty_percent }}%</strong>
                                            </div>

                                            <div class="col-md-6">
                                                Total Penjualan:
                                                <strong>
                                                    Rp {{ number_format($royalty->total_sales, 0, ',', '.') }}
                                                </strong>
                                            </div>

                                            <div class="col-md-6">
                                                Total Royalti:
                                                <strong class="text-success">
                                                    Rp {{ number_format($royalty->royalty_amount, 0, ',', '.') }}
                                                </strong>
                                            </div>
                                        </div>

                                        <span class="badge bg-secondary mt-3">
                                            {{ ucwords(str_replace('_', ' ', $royalty->status)) }}
                                        </span>

                                    </div>

                                @empty

                                    <p class="text-muted">
                                        Belum ada data royalti.
                                    </p>

                                @endforelse

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

@endsection