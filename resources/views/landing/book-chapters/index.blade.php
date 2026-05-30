@extends('layouts.app')

@section('content')

<style>
    .book-chapter-page {
        background: #f8fafc;
        padding: 36px 0 50px;
    }

    .page-title {
        color: #1D3557;
        font-size: 34px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 0;
    }

    .filter-box {
        max-width: 480px;
        margin: 24px auto 28px;
    }

    .chapter-card {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: .2s ease;
    }

    .chapter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0,0,0,.08);
    }

    .cover-wrapper {
    background: #f8fafc;
    padding: 10px;
    text-align: center;
}

.chapter-cover {
    width: 100%;
    height: 310px;
    object-fit: contain;
    border-radius: 6px;
    filter: drop-shadow(0 10px 14px rgba(0,0,0,.18));
}

    .field-badge {
    background: #d5dde2;
    color: #1D3557;
    font-size: 12px;
    font-weight: 700;
    border-radius: 999px;
    padding: 6px 12px;
    width: fit-content;
    margin: 0 auto;
}

    .chapter-title {
        color: #1D3557;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.35;
        margin-bottom: 8px;
    }

    .chapter-description {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        min-height: 45px;
    }

    .chapter-meta {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 14px;
        font-size: 14px;
    }

    .chapter-meta p {
        margin-bottom: 5px;
        color: #334155;
    }

    .chapter-meta p:last-child {
        margin-bottom: 0;
    }

    .btn-chapter {
        background: #1D3557;
        border-color: #1D3557;
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 14px;
    }

    .btn-chapter:hover {
        background: #14263f;
        border-color: #14263f;
    }
</style>

<section class="book-chapter-page">
    <div class="container">

        <div class="text-center">
            <h1 class="page-title">Paket Book Chapter</h1>
            <p class="page-subtitle">
                Pilih bidang keilmuan dan judul buku Book Chapter yang tersedia.
            </p>
        </div>

        <form method="GET" action="{{ url('index.php/book-chapters') }}" class="filter-box">
            <select name="field" class="form-select form-select-lg shadow-sm" onchange="this.form.submit()">
                <option value="">Semua Bidang Keilmuan</option>

                @foreach($fields as $field)
                    <option value="{{ $field }}" {{ request('field') == $field ? 'selected' : '' }}>
                        {{ $field }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="row g-4">

            @forelse($bookChapters as $bookChapter)

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="chapter-card h-100 d-flex flex-column">

                        <div class="cover-wrapper">
                            @if($bookChapter->cover)
                                <img src="{{ asset('book-chapters/' . $bookChapter->cover) }}"
                                     class="chapter-cover"
                                     alt="{{ $bookChapter->title }}">
                            @else
                                <div class="chapter-cover d-flex align-items-center justify-content-center bg-white text-muted">
                                    Tidak ada cover
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column p-3">

                            <span class="field-badge">
                                {{ $bookChapter->field ?? 'Book Chapter' }}
                            </span>

                            <h5 class="chapter-title">
                                {{ $bookChapter->title }}
                            </h5>

                            <p class="chapter-description">
                                {{ Str::limit($bookChapter->description, 90) }}
                            </p>

                            <div class="chapter-meta mt-auto">
                                <p>
                                    <strong>Terbit:</strong>
                                    {{ $bookChapter->estimated_publish ?? '-' }}
                                </p>

                                <p>
                                    <strong>Bab tersedia:</strong>
                                    {{ $bookChapter->items->where('status', 'available')->count() }}
                                </p>
                            </div>

                            <a href="{{ url('index.php/book-chapters/' . $bookChapter->id) }}"
                               class="btn btn-primary btn-chapter w-100">
                                Lihat Daftar Bab
                            </a>

                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="text-center bg-white rounded-4 shadow-sm p-5">
                        <h5 class="fw-bold text-muted">Belum ada Book Chapter</h5>
                        <p class="text-muted mb-0">
                            Paket Book Chapter akan tampil di halaman ini setelah ditambahkan oleh admin.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</section>

@endsection