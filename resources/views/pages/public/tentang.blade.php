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

body {
    background-color: #E7E7E7;
}

html, body {
    height: 100%;
    margin: 0;
}

.menu {
    letter-spacing: 1px;
}
</style>
<main>
    @include('layouts.public.nav')

    <!-- Tentang -->
    <?php if ($jT == 1) : ?>
    @foreach ($Tentang as $T)
    <div class="container">
        <div class="text-center pt-4">
            <h1><strong>Tentang Desa Kedungbanteng</strong></h1>
            <img src="{{  url('') }}/assets/foto/tentang/{{ $T->foto_tentang }}" class="img-thumbnail m-3" style="max-width: 70vw; border-radius: 25px;">
        </div>
        <div class="lead mt-2 mb-5" style="text-align: justify">
            <?= $T['detail_tentang']; ?>
        </div>
    </div>
    @endforeach
    <?php endif;?>

</main><!-- End #main -->
@include('layouts.public.footer')
@include('layouts.public.scriptberanda')
@endsection

<body>
    @yield('content')
</body>
</html>
