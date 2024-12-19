<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.public.head')
</head>

@section('content')
<div id="preloader"></div>
<style>
#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  overflow: hidden;
  background: #fff;
}
#preloader:before {
  content: "";
  position: fixed;
  top: calc(50% - 30px);
  left: calc(50% - 30px);
  border: 6px solid #FF8E00;
  border-top-color: #e7e4fe;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: animate-preloader 1s linear infinite;
}
@keyframes animate-preloader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
<?php if ($jE > 0) : ?>
body {
    background-color: #E7E7E7;
}
<?php endif;?>
html, body {
    height: 100%;
    margin: 0;
}

.menu {
    letter-spacing: 1px;
}

.card-img-overlay {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.card:hover .card-img-overlay {
    opacity: 1;
}
.card-title, .card-text, .tbl {
    color: white;
    text-align: center;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.card:hover .card-title,
.card:hover .card-text,
.card:hover .tbl {
    opacity: 1;
    transform: translateY(0);
}
.card-img {
    transition: filter 0.3s ease;
}
.card:hover .card-img {
    filter: blur(1.5px);
}
</style>
<main>
    @include('layouts.public.nav')

    <!-- Edukasi -->
    <div class="container">
        <div class="text-center pt-4">
            <h1><strong>Edukasi Bencana</strong></h1>
            <?php if ($jE == 0) : ?>
            <img src="{{  url('') }}/img/comingsoon.png" class="img-thumbnail" style="max-width: 70%; border-width: 0px">
            <?php endif;?>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 pt-3">
            <?php if ($jE > 0) : ?>
            @foreach ($Edukasi as $E)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="card text-white shadow mb-4">
                    <img src="{{ url('') }}/assets/foto/edukasi/{{ $E->foto_edukasi }}" class="card-img" alt="...">
                    <div class="card-img-overlay text-center">
                    <h5 class="card-title">{{ $E->judul_edukasi }}</h5>
                    <p class="card-text"><small>Penulis : <b>{{ $E->penulis_edukasi }}</b> <br> {{ $E->format_tgl }}</small></p>
                    <a href="{{ route('edukasi.detail', $E->id_detail) }}" class="btn btn-outline-light tbl">Baca Artikel</a>
                    </div>
                </div>
            </div>
            @endforeach
            <?php endif;?>
        </div>
    </div>

</main><!-- End #main -->
@include('layouts.public.footer')
@include('layouts.public.scriptberanda')
@endsection

<body>
    @yield('content')
</body>
</html>
