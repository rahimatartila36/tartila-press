@extends('layouts.app')

@section('content')

<style>
    .chapter-detail-page {
        background: #f8fafc;
        padding: 34px 0 55px;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .cover-box {
        background: linear-gradient(180deg, #f8fafc, #eef2f7);
        border-radius: 18px;
        padding: 22px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .book-cover {
        width: 100%;
        max-width: 245px;
        aspect-ratio: 14.8 / 21;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 14px 28px rgba(0,0,0,.18);
    }

    .package-info {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 18px;
        margin-top: 18px;
    }

    .package-info h6 {
        color: #1D3557;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px dashed #e5e7eb;
        padding: 8px 0;
        font-size: 14px;
    }

    .info-row:last-child {
        border-bottom: 0;
    }

    .info-row span:first-child {
        color: #64748b;
    }

    .info-row span:last-child {
        color: #0f172a;
        font-weight: 700;
        text-align: right;
    }

    .field-badge{
    background:#D8E2DC;
    color:#1D3557;
    font-size:11px;
    font-weight:700;
    border-radius:999px;
    padding:4px 10px;
    white-space:nowrap;
    margin:0;
}

.detail-title{
    color:#1D3557;
    font-size:28px;
    font-weight:800;
    line-height:1.3;
    margin:0;
}

    .detail-description {
        color: #475569;
        font-size: 15px;
        line-height: 1.75;
        margin-bottom: 18px;
    }

    .chapter-table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .06);
    }

    .chapter-table-header {
        background: #1D3557;
        color: #fff;
        padding: 16px 20px;
    }

    .chapter-table-header h5 {
        margin: 0;
        font-weight: 800;
        font-size: 18px;
    }

    .modern-table {
        margin-bottom: 0;
    }

    .modern-table thead th {
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px;
        white-space: nowrap;
    }

    .modern-table tbody td {
        padding: 15px 14px;
        vertical-align: middle;
        border-color: #eef2f7;
        font-size: 14px;
    }

    .chapter-name {
        color: #1D3557;
        font-weight: 800;
        min-width: 190px;
    }

    .price-final {
        color: #1D3557;
        font-weight: 850;
        white-space: nowrap;
    }

    .status-pill {
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

.book-description{
    line-height: 1.9;
    color:#555;
    text-align: justify;
    white-space: normal;
}

.book-description p{
    margin-bottom:16px;
}

.chapter-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.chapter-table th{
    font-size:13px;
    font-weight:700;
    color:#1D3557;
    padding:18px 14px;
    white-space:nowrap;
    border-bottom:1px solid #E5E7EB;
}

.chapter-table td{
    padding:22px 14px;
    vertical-align:middle;
    border-bottom:1px solid #F1F3F5;
}

.chapter-title-cell{
    min-width:320px;
    max-width:450px;
    line-height:1.8;
    font-weight:600;
    color:#222;
    word-break:break-word;
}

.chapter-nowrap{
    white-space:nowrap;
}

.price-final{
    font-weight:700;
    color:#1D3557;
}

.chapter-price,
.chapter-discount,
.chapter-final,
.chapter-status,
.chapter-action{
    white-space:nowrap;
}

    .btn-buy {
        background: #1D3557;
        border-color: #1D3557;
        border-radius: 10px;
        font-weight: 800;
        padding: 8px 14px;
        white-space: nowrap;
    }

    .btn-buy:hover {
        background: #14263f;
        border-color: #14263f;
    }

    .btn-back {
        border-radius: 10px;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        .detail-title {
            font-size: 24px;
        }

        .book-cover {
            max-width: 210px;
        }
    }
</style>

<section class="chapter-detail-page">
    <div class="container">

        <div class="mb-3">
            <a href="{{ url('index.php/book-chapters') }}" class="btn btn-outline-secondary btn-sm btn-back">
                ← Kembali ke Book Chapter
            </a>
        </div>

        <div class="row g-4 align-items-start">

            <div class="col-lg-4">
                <div class="cover-box">
                    @if($bookChapter->cover)
                        <img src="{{ asset('book-chapters/' . $bookChapter->cover) }}"
                             class="book-cover"
                             alt="{{ $bookChapter->title }}">
                    @else
                        <div class="book-cover bg-white d-flex align-items-center justify-content-center text-muted mx-auto">
                            Tidak ada cover
                        </div>
                    @endif
                </div>

                <div class="package-info">
                    <h6>Informasi Paket Buku</h6>

                    <div class="info-row">
                        <span>Bidang</span>
                        <span>{{ $bookChapter->field ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span>Kategori</span>
                        <span>{{ $bookChapter->category ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span>Perkiraan Terbit</span>
                        <span>{{ $bookChapter->estimated_publish ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span>Bab Tersedia</span>
                        <span>{{ $bookChapter->items->where('status', 'available')->count() }}</span>
                    </div>
                    <div class="card shadow-sm border-0 rounded-4 mt-4">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">
                            Deskripsi Buku
                        </h5>

                        <div class="book-description">
                            {!! nl2br(e($bookChapter->description)) !!}
                        </div>

                    </div>
                </div>

                    @if($bookChapter->package)
                        <div class="info-row">
                            <span>Harga Default Bab</span>
                            <span>Rp {{ number_format($bookChapter->package->price, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-8">

                <div class="detail-card p-4 mb-4">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <h1 class="detail-title mb-0">
                        {{ $bookChapter->title }}
                    </h1>

                    <span class="field-badge">
                        {{ $bookChapter->field ?? 'Book Chapter' }}
                    </span>

                </div>

            </div>

                <div class="chapter-table-card">
                    <div class="chapter-table-header">
                        <h5>Daftar Bab Tersedia</h5>
                    </div>

                    <div class="table-responsive">

                <table class="table chapter-table align-middle">

                    <thead>
                        <tr>
                            <th width="45%">JUDUL BAB</th>
                            <th>HARGA</th>
                            <th>DISKON</th>
                            <th>HARGA AKHIR</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($bookChapter->items as $item)

                        @php
                            $hargaDasar = $item->price ?: optional($bookChapter->package)->price ?: 0;

                            $diskon = $item->discount > 0
                                ? $item->discount
                                : (optional($bookChapter->package)->discount ?: 0);

                            $hargaAkhir = $hargaDasar - ($hargaDasar * $diskon / 100);
                        @endphp

                        <tr>

                            <td class="chapter-title-cell">
                                {{ $item->chapter_title }}
                            </td>

                            <td class="chapter-nowrap">
                                Rp {{ number_format($hargaDasar, 0, ',', '.') }}
                            </td>

                            <td class="chapter-nowrap">
                                {{ $diskon }}%
                            </td>

                            <td class="chapter-nowrap price-final">
                                Rp {{ number_format($hargaAkhir, 0, ',', '.') }}
                            </td>

                            <td class="chapter-nowrap">

                                @if($item->status == 'available')

                                    <span class="badge bg-success status-pill">
                                        Tersedia
                                    </span>

                                @elseif($item->status == 'pending')

                                    <span class="badge bg-warning text-dark status-pill">
                                        Menunggu
                                    </span>

                                @else

                                    <span class="badge bg-danger status-pill">
                                        Terjual
                                    </span>

                                @endif

                            </td>

                            <td class="chapter-nowrap">

                                @if($item->status == 'available')

                                    <a href="{{ route('payment.book-chapter', $item->id) }}"
                                        class="btn btn-primary btn-sm btn-buy">
                                            Beli Bab
                                    </a>

                                @else

                                    <button class="btn btn-secondary btn-sm btn-buy" disabled>
                                        Tidak Tersedia
                                    </button>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                Belum ada bab untuk buku ini.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>
                </div>

            </div>

        </div>

    </div>
</section>


@endsection