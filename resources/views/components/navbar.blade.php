<nav x-data="{ open: false }"
     class="navbar navbar-expand-lg fixed-top shadow-sm tartila-navbar">

    <div class="container-fluid px-4">

        {{-- Logo & Brand --}}
        <a href="/" class="navbar-brand d-flex align-items-center text-decoration-none">

            <img src="{{ asset('images/logo.png') }}"
                 alt="Tartila Press"
                 class="navbar-logo">

            <div class="ms-3 brand-text">
                <div class="brand-title">
                    Tartila Press
                </div>

                <small class="brand-subtitle">
                    Menata Ilmu, Menguatkan Peradaban
                </small>
            </div>

        </a>

        {{-- Toggle Mobile --}}
        <button class="navbar-toggler custom-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                <li class="nav-item">
                    <a class="nav-link" href="/#about">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#services">Layanan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#paket">Paket</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('books.catalog') }}" class="nav-link">
                        Katalog
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('book-chapters.index') }}" class="nav-link">
                        Book Chapter
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#contact">Kontak</a>
                </li>

                @guest

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-outline-light btn-navbar" href="/login">
                            Login
                        </a>
                    </li>

                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-light btn-navbar btn-register" href="/register">
                            Register
                        </a>
                    </li>

                @endguest

                @auth

                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a class="btn btn-outline-light btn-navbar" href="/dashboard">
                                Dashboard Admin
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a class="btn btn-outline-light btn-navbar" href="/profile">
                                Profil Saya
                            </a>
                        </li>
                    @endif

                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-outline-warning btn-navbar" href="/cart">
                            Keranjang
                        </a>
                    </li>

                    <li class="nav-item mt-2 mt-lg-0">
                        <form method="POST" action="/logout">
                            @csrf

                            <button type="submit" class="btn btn-danger btn-navbar">
                                Logout
                            </button>
                        </form>
                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>

<style>
    body{
        padding-top:82px;
    }

    .tartila-navbar{
        background:#003153;
        border-bottom:1px solid rgba(255,255,255,0.10);
        min-height:82px;
        z-index:9999;
    }

    .navbar-logo{
        height:50px;
        width:50px;
        object-fit:cover;
        border-radius:12px;
        border:2px solid #D8E2DC;
        padding:3px;
        background:white;
        flex-shrink:0;
    }

    .brand-title{
        color:white;
        font-size:21px;
        font-weight:700;
        line-height:1;
    }

    .brand-subtitle{
        color:#D8E2DC;
        font-size:12px;
    }

    .tartila-navbar .nav-link{
        color:#f8f9fa;
        font-weight:500;
        font-size:15px;
        padding:8px 12px;
    }

    .tartila-navbar .nav-link:hover{
        color:#D8E2DC;
    }

    .btn-navbar{
        border-radius:10px;
        padding:8px 15px;
        font-size:14px;
        font-weight:600;
        white-space:nowrap;
    }

    .btn-register{
        color:#003153;
    }

    .custom-toggler{
        border:1px solid rgba(255,255,255,0.35);
    }

    .custom-toggler:focus{
        box-shadow:none;
    }

    .navbar-toggler-icon{
        filter:invert(1);
    }

    @media(max-width:991px){
        body{
            padding-top:76px;
        }

        .tartila-navbar{
            min-height:76px;
        }

        .navbar-collapse{
            background:#003153;
            padding:18px 0 14px;
            border-top:1px solid rgba(255,255,255,0.10);
            margin-top:14px;
        }

        .navbar-nav{
            align-items:stretch !important;
        }

        .tartila-navbar .nav-link{
            padding:10px 0;
        }

        .btn-navbar{
            width:100%;
            text-align:center;
        }

        .brand-title{
            font-size:19px;
        }

        .brand-subtitle{
            font-size:11px;
        }

        .navbar-logo{
            height:46px;
            width:46px;
        }
    }
</style>