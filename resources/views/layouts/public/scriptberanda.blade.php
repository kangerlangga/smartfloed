<script>
    $('.owlone').owlCarousel({
        stagePadding: 200,
        items:1,
        lazyLoad: true,
        nav:true,
        navText: false,
        loop: true,
        autoplay: true,
        responsive:{
            0:{
                items:1,
                stagePadding: 0
            },
            600:{
                items:1,
                stagePadding: 0
            },
            900:{
                items:1,
                stagePadding: 100
            },
            1200:{
                items:1,
                stagePadding: 250
            },
            1400:{
                items:1,
                stagePadding: 300
            },
            1600:{
                items:1,
                stagePadding: 350
            },
            1800:{
                items:1,
                stagePadding: 400
            }
        }
    })
</script>

<!-- Template Main JS File -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="{{  url('') }}/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
