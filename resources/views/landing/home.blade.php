<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tartila Press</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root {
    --primary:#003153;
    --secondary:#D0F0C0;
}

.hero {
    background:var(--primary);
    color:white;
    padding:120px 20px;
}

</style>

</head>

<body>

@include('components.navbar')

@include('components.hero')

@include('components.about')

@include('components.services')

@include('components.packages', ['packages' => $packages])

@include('components.books', ['books' => $books])
@include('components.book-chapters')

<footer style="background:#003153; color:white;">

    <div class="container py-5">

        <div class="row g-4">

            {{-- Brand --}}
            <div class="col-md-4">

                <h4 class="fw-bold mb-3">
                    Tartila Press
                </h4>

                <p style="color:#d6d6d6; line-height:1.8;">
                    Penerbit independen yang berfokus pada penerbitan buku
                    berkualitas, pengembangan literasi, dan distribusi karya
                    penulis Indonesia secara profesional.
                </p>

            </div>

            {{-- Kontak --}}
            <div class="col-md-4">

                <h5 class="fw-bold mb-3">
                    Kontak
                </h5>

                <p class="mb-2">
                    📧 Email:
                    <br>
                    tartilapress@gmail.com
                </p>

                <p class="mb-2">
                    📱 WhatsApp:
                    <br>
                    +62 812-7034-8598
                </p>

                <p class="mb-0">
                    📍 Indonesia
                </p>

            </div>

            {{-- Sosial Media --}}
            <div class="col-md-4">

                <h5 class="fw-bold mb-3">
                    Sosial Media
                </h5>

                <div class="d-flex flex-column gap-2">

                    <a href="https://instagram.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        Instagram
                    </a>

                    <a href="https://facebook.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        Facebook
                    </a>

                    <a href="https://tiktok.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        TikTok
                    </a>

                    <a href="https://youtube.com"
                       target="_blank"
                       style="color:white; text-decoration:none;">
                        YouTube
                    </a>

                </div>

            </div>

        </div>

        <hr style="border-color:rgba(255,255,255,0.2);" class="my-4">

        <div class="text-center">

            <small style="color:#d6d6d6;">
                © 2026 Tartila Press —
                Menata Ilmu, Menguatkan Peradaban.
            </small>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>