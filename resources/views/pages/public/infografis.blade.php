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
<?php if ($jI > 0) : ?>
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

.download-icon {
    display: inline-block;
    padding: 3px 7px;
    border: 2px solid #FF8E00;
    /* border-radius: 50%; */
    background-color: #FF8E00;
    color: white;
    text-decoration: none;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<main>
    @include('layouts.public.nav')

    <!-- Infografis -->
    <div class="container">
        <div class="text-center pt-4">
            <h1><strong>Infografis</strong></h1>
            <?php if ($jI == 0) : ?>
            <img src="{{  url('') }}/img/comingsoon.png" class="img-thumbnail" style="max-width: 70%; border-width: 0px">
            <?php endif;?>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 pt-3">
            <?php if ($jI > 0) : ?>
            @foreach ($Infografis as $I)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="card shadow mb-4 text-center" style="border-color: #FF8E00; border-radius: 25px; border-width: 3px;">
                    <img src="{{ url('') }}/assets/foto/infografis/{{ $I->foto_infografis }}" class="card-img-top" alt="..." style="border-radius: 25px; margin: 17px 17px 0px 17px; width: auto; height: auto;">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize" style="text-decoration-color: #FF8E00;">{{ $I->sumber_infografis }}</h5>
                        <p class="card-text text-center text-uppercase">{{ $I->judul_infografis }}</p>
                        <div class="text-center">
                            <a target="_blank" href="{{ url('') }}/assets/foto/infografis/{{ $I->foto_infografis }}" class="download-icon">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
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
