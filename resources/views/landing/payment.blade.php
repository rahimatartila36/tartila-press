<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f8f9fa;">

@include('components.navbar')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow border-0">
                <div class="card-header text-center bg-white">
                    <h4 class="mb-0">
                        @if($type == 'package')
                            Pembayaran Paket
                        @elseif($type == 'book')
                            Pembayaran Buku
                        @elseif($type == 'order')
                            Pembayaran Pesanan
                        @elseif($type == 'book_chapter')
                            Pembayaran Bab Buku
                        @endif
                    </h4>
                </div>

                <div class="card-body text-center">

                    {{-- ERROR VALIDASI --}}
                    @if ($errors->any())
                        <div class="alert alert-danger text-start">
                            <strong>Data belum berhasil dikirim:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success text-start">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($type == 'package')

                        @if($package && $package->image)
                            <img src="/packages/{{ $package->image }}"
                                 width="150"
                                 class="mb-3 rounded shadow-sm">
                        @endif

                        <h5 class="fw-bold">{{ $package->name }}</h5>

                        <p class="text-muted">
                            Kategori: {{ $package->category }}
                        </p>

                        @php
                            $discount = $package->discount ?? 0;
                            $finalPrice = $package->price - ($package->price * $discount / 100);
                        @endphp

                    @elseif($type == 'book')

                        @if($book && $book->cover)
                            <img src="{{ asset('storage/'.$book->cover) }}"
                                 width="150"
                                 class="mb-3 rounded shadow-sm">
                        @endif

                        <h5 class="fw-bold">{{ $book->title }}</h5>

                        <p class="text-muted">
                            Penulis: {{ $book->author }}
                        </p>

                        @php
                            $discount = $book->diskon ?? 0;
                            $finalPrice = $discount > 0
                                ? $book->harga - ($book->harga * $discount / 100)
                                : $book->harga;
                        @endphp

                    @elseif($type == 'book_chapter')

                        <h5 class="fw-bold">
                            {{ $chapterItem->chapter_title }}
                        </h5>

                        <p class="text-muted mb-1">
                            Buku: {{ $chapterItem->bookChapter->title ?? '-' }}
                        </p>

                        <p class="text-muted mb-1">
                            Bidang: {{ $chapterItem->bookChapter->field ?? '-' }}
                        </p>

                       @php
                            $hargaDasar = $chapterItem->price ?: optional($chapterItem->bookChapter->package)->price ?: 0;

                            $discount = $chapterItem->discount > 0
                                ? $chapterItem->discount
                                : (optional($chapterItem->bookChapter->package)->discount ?: 0);

                            $finalPrice = $hargaDasar - ($hargaDasar * $discount / 100);
                        @endphp

                        <div class="alert alert-light border text-start mt-3">
                            <div class="d-flex justify-content-between">
                                <span>Harga Bab</span>
                                <strong>Rp {{ number_format($hargaDasar, 0, ',', '.') }}</strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Diskon</span>
                                <strong>{{ $discount }}%</strong>
                            </div>
                        </div>

                    @elseif($type == 'order')

                        <h5 class="fw-bold">Pesanan Buku</h5>

                        <p class="text-muted">
                            Order #{{ $order->id }}
                        </p>

                        <div class="text-start mb-3">
                            @foreach($order->items as $item)
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->book && $item->book->cover)
                                            <img src="{{ asset('storage/'.$item->book->cover) }}"
                                                 style="width:60px; height:80px; object-fit:cover; border-radius:8px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="width:60px; height:80px; border-radius:8px;">
                                                <small class="text-muted">No Cover</small>
                                            </div>
                                        @endif

                                        <div>
                                            <strong>{{ $item->book->title ?? '-' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="fw-semibold">
                                        Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        @php
                            $finalPrice = $order->total_price;
                        @endphp

                    @endif

                    <h3 class="text-success fw-bold mt-3">
                        Rp {{ number_format($finalPrice, 0, ',', '.') }}
                    </h3>

                    <hr>

                    <h5 class="fw-bold">Transfer ke Rekening:</h5>

                    <div class="alert alert-info">
                        <strong>Bank Mandiri</strong>
                        <br>
                        1090023952914
                        <br>
                        a.n. Rahima Tartila
                    </div>

                    <form method="POST"
                          action="{{ route('payment.store') }}"
                          enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="type" value="{{ $type }}">

                        @if($type == 'package' && $package)
                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                        @endif

                        @if($type == 'book' && $book)
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                        @endif

                        @if($type == 'order' && $order)
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                        @endif

                        @if($type == 'book_chapter' && $chapterItem)
                            <input type="hidden" name="book_chapter_item_id" value="{{ $chapterItem->id }}">
                        @endif

                        <div class="alert alert-light border text-start">
                            <strong>Pembayar:</strong> {{ auth()->user()->name ?? '-' }} <br>
                            <small class="text-muted">
                                {{ auth()->user()->email ?? '-' }}
                            </small>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file"
                                   name="proof"
                                   class="form-control"
                                   accept="image/*"
                                   required>
                            <small class="text-muted">
                                Format: JPG, JPEG, PNG, atau WEBP. Maksimal 2MB.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            Kirim Bukti Pembayaran
                        </button>

                    </form>

                    @if($type == 'package')
                        <a href="https://wa.me/6281270348598?text=Saya sudah transfer paket {{ $package->name }}"
                           target="_blank"
                           class="btn btn-success w-100">
                            Konfirmasi Pembayaran via WhatsApp
                        </a>

                    @elseif($type == 'book')
                        <a href="https://wa.me/6281270348598?text=Saya sudah transfer pembelian buku {{ $book->title }}"
                           target="_blank"
                           class="btn btn-success w-100">
                            Konfirmasi Pembayaran via WhatsApp
                        </a>

                    @elseif($type == 'book_chapter')
                        <a href="https://wa.me/6281270348598?text=Saya sudah transfer pembelian bab {{ $chapterItem->chapter_title }} dari buku {{ $chapterItem->bookChapter->title ?? '-' }}"
                           target="_blank"
                           class="btn btn-success w-100">
                            Konfirmasi Pembayaran via WhatsApp
                        </a>

                    @elseif($type == 'order')
                        <a href="https://wa.me/6281270348598?text=Saya sudah transfer pesanan buku Order #{{ $order->id }}"
                           target="_blank"
                           class="btn btn-success w-100">
                            Konfirmasi Pembayaran via WhatsApp
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>