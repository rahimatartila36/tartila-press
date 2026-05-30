<section id="book-chapters" class="py-5 bg-white">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">
                    Book Chapter
                </h2>

                <p class="text-muted mb-0">
                    Pilih bab yang tersedia dan terbitkan karya Anda bersama penulis lain.
                </p>
            </div>

            <a href="{{ route('book-chapters.index') }}" class="btn btn-outline-primary">
                Lihat Semua
            </a>
        </div>

        <div class="row g-4">

            @forelse($bookChapters as $bookChapter)

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">

                        @if($bookChapter->cover)
                            <img src="{{ asset('book-chapters/' . $bookChapter->cover) }}"
                                 class="card-img-top"
                                 style="height:250px; object-fit:cover;">
                        @endif

                        <div class="card-body d-flex flex-column">

                            <span class="badge bg-primary mb-2 align-self-start">
                                {{ $bookChapter->field ?? 'Book Chapter' }}
                            </span>

                            <h5 class="fw-bold">
                                {{ $bookChapter->title }}
                            </h5>

                            <p class="text-muted small">
                                {{ Str::limit($bookChapter->description, 100) }}
                            </p>

                            <div class="mt-auto">

                                <p class="mb-1 small">
                                    <strong>Bab Tersedia:</strong>
                                    {{ $bookChapter->items->where('status', 'available')->count() }}
                                </p>

                                <p class="mb-3 small">
                                    <strong>Perkiraan Terbit:</strong>
                                    {{ $bookChapter->estimated_publish ?? '-' }}
                                </p>

                                <a href="{{ route('book-chapters.show', $bookChapter->id) }}"
                                    class="btn btn-primary w-100">
                                        Lihat Daftar Bab
                                </a>

                            </div>

                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12 text-center">
                    <p class="text-muted">
                        Belum ada Book Chapter yang tersedia.
                    </p>
                </div>

            @endforelse

        </div>

    </div>

</section>