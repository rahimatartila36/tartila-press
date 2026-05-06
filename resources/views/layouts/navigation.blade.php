<nav x-data="{ open: false }"
     class="shadow-sm border-bottom"
     style="background:#1D3557;">

    <div class="container-fluid px-4">

        <div class="d-flex align-items-center justify-content-between"
             style="min-height:90px;">

            {{-- Logo + Brand --}}
            <a href="/" class="d-flex align-items-center text-decoration-none">

                <img src="{{ asset('images/logo.PNG') }}"
                     alt="Tartila Press"
                     style="
                        height:50px;
                        width:50px;
                        object-fit:cover;
                        border-radius:12px;
                        border:2px solid #D8E2DC;
                        padding:3px;
                        background:white;
                     ">

                <div class="ms-3">
                    <div style="color:white; font-size:22px; font-weight:700; line-height:1;">
                        Tartila Press
                    </div>

                    <small style="color:#D8E2DC; font-size:12px;">
                        Menata Ilmu, Menguatkan Peradaban
                    </small>
                </div>

            </a>

            {{-- Desktop Menu --}}
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="/" class="btn btn-sm" style="border:1px solid #D8E2DC; color:#D8E2DC;">Beranda</a>
                <a href="/#books" class="btn btn-sm" style="border:1px solid #D8E2DC; color:#D8E2DC;">Buku</a>
                <a href="/#paket" class="btn btn-sm" style="border:1px solid #D8E2DC; color:#D8E2DC;">Paket</a>
                <a href="/cart" class="btn btn-sm" style="background:#D8E2DC; color:#1D3557;">Keranjang</a>

                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle fw-semibold"
                            style="background:#D8E2DC; color:#1D3557;"
                            type="button"
                            data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Mobile Button --}}
            <div class="d-md-none">
                <button @click="open = ! open"
                        class="btn"
                        style="border:1px solid #D8E2DC; color:#D8E2DC;">
                    ☰
                </button>
            </div>

        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" class="pb-3 d-md-none">
            <a href="/" class="btn w-100 mb-2" style="border:1px solid #D8E2DC; color:#D8E2DC;">Beranda</a>
            <a href="/#books" class="btn w-100 mb-2" style="border:1px solid #D8E2DC; color:#D8E2DC;">Buku</a>
            <a href="/#paket" class="btn w-100 mb-2" style="border:1px solid #D8E2DC; color:#D8E2DC;">Paket</a>
            <a href="/cart" class="btn w-100 mb-2" style="background:#D8E2DC; color:#1D3557;">Keranjang</a>
            <a href="{{ route('profile.edit') }}" class="btn btn-light w-100 mb-2">Profile</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>