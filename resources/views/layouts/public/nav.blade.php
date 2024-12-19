<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #FF8E00; padding: 3px 3% 3px 3%;">
        <a class="navbar-brand" href="#">Smart Floed
            {{-- <img src="{{  url('') }}/assets/img/logo.png" height="50"> --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('/') ? 'active fw-bold' : '' }}" aria-current="page" href="{{ route('beranda.publik') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('tentang*') ? 'active fw-bold' : '' }}" href="{{ route('tentang.publik') }}">Tentang Desa Kedungbanteng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('infografis*') ? 'active fw-bold' : '' }}" href="{{ route('infografis.publik') }}">Infografis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('edukasi*') ? 'active fw-bold' : '' }}" href="{{ route('edukasi.publik') }}">Edukasi Bencana</a>
                </li>
            </ul>
        </div>
    </nav>

@if(app()->environment('local') || config('app.debug'))
    <div class="bg-danger text-white pt-1">
        <marquee behavior="scroll" direction="left" class="fw-bolder">Saat ini Situs sedang dalam proses peningkatan sistem untuk memberikan layanan yang lebih baik kepada Anda. Kami mohon maaf atas ketidaknyamanan yang ditimbulkan selama proses ini berlangsung. Terima kasih atas pengertian Anda.</marquee>
    </div>
@endif
