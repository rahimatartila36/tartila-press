<section class="hero">

    <div class="hero-overlay"></div>

    <div class="container text-center position-relative">

        <h1 class="hero-title">
            Terbitkan Buku Berkualitas
            Bersama Tartila Press
        </h1>

        <p class="hero-subtitle">
            Membantu penulis menerbitkan karya ber-ISBN
            secara profesional dengan sistem modern,
            transparan, dan terpercaya.
        </p>

        <div class="d-flex justify-content-center flex-wrap gap-3 mt-5">

            <a href="#packages"
               class="btn btn-light hero-btn">
                Lihat Paket
            </a>

            <a href="https://wa.me/6281270348598"
               target="_blank"
               class="btn btn-success hero-btn">
                Konsultasi WhatsApp
            </a>

        </div>

    </div>

</section>

<style>

.hero{
    position:relative;

    padding:70px 0 60px;

    background:
        linear-gradient(
            rgba(0,49,83,0.90),
            rgba(0,49,83,0.94)
        ),
        url('{{ asset('images/buku.png') }}');

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    overflow:hidden;
}

.hero-overlay{
    position:absolute;
    inset:0;

    background:
        radial-gradient(
            circle at top right,
            rgba(216,226,220,0.06),
            transparent 30%
        );
}

.hero-title{
    color:white;

    font-weight:700;

    font-size:clamp(28px, 3vw, 46px);

    line-height:1.35;

    letter-spacing:-1px;

    max-width:780px;

    margin:auto auto 20px;
}

.hero-subtitle{
    color:#dbe4ea;

    font-size:17px;

    font-weight:400;

    max-width:700px;

    margin:auto;

    line-height:1.9;
}

.hero-badge{
    display:inline-block;

    background:rgba(216,226,220,0.10);

    color:#D8E2DC;

    border:1px solid rgba(255,255,255,0.10);

    backdrop-filter:blur(10px);

    padding:9px 16px;

    border-radius:999px;

    font-size:12px;

    font-weight:500;

    margin-bottom:24px;
}

.hero-btn{
    border-radius:12px !important;

    padding:12px 24px !important;

    font-weight:600 !important;

    font-size:14px !important;

    transition:.3s;
}

.hero .btn-light{
    background:white;
    border:none;
    color:#003153;
}

.hero .btn-success{
    background:#2E8B57;
    border:none;
}

.hero-btn:hover{
    transform:translateY(-2px);
}

@media(max-width:768px){

    .hero{
        padding:85px 0 65px;
    }

    .hero-title{
        font-size:30px;
        line-height:1.45;
    }

    .hero-subtitle{
        font-size:15px;
        line-height:1.8;
    }

    .hero-btn{
        width:100%;
    }

}

</style>