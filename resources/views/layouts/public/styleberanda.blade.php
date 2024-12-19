<style>
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
<style>
    .card {
        top: -7vh;
        left: 10%;
        right: 10%;
        width: 80%;
    }
    .gbr-atas img{
        width: 100%;
        height: 34vh;
        object-fit: cover;
    }
        @media screen and (max-width: 768px) {
            .maskot {
                width: 17%;
            }

            .card h5{
                font-size: 2.4vw;
            }

            .card {
                top: -4vh;
            }

            .banner-detail .img-top img {
                height: 133px;
            }
        }

</style>
<style>
    .item{
      opacity:0.4;
      transition:.4s ease all;
      margin:0 20px;
      transform:scale(.8);
      padding: 25px 0;
    }

    .item img {
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.30);
    border-radius: 20px;
    width: 100%;
    height: 100%;
    /* max-height: 410px; */
    }

    .active .item{
    opacity:1;
    transform:scale(1);
    }

    .owl-dots {
    padding-bottom: 15px
    }

    .owl-carousel .owl-wrapper {
    display: flex !important;
    flex-direction: column
    }

    .owl-carousel .owl-item {
    width:100%;
    }

    .owl-carousel .owl-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    max-width: initial;
    }

    .text-info {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 40px;
    text-align: center;
    }

    .text-info p {
    color: #fff
    }

    .text-info .red-text {
    background-color: rgba(234,104,82,.75);
    display: inline-block;
    font-size: 20px;
    padding: 5px;
    font-weight: 400;
    text-transform: uppercase;
    }

    .text-info .blue-text {
    background-color: rgba(25,31,98,.75);
    display: inline-block;
    font-size: 20px;
    padding: 5px;
    font-weight: 400
    }

</style>
<style>
    .owl-stage {
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;

        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }
    .owl-item{
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        height: auto !important;
    }
    .owl-item > * {
        width: 100%;
    }
    </style>

    <style>
    .owl-carousel.nav-style-1 .owl-nav .owl-next, .owl-carousel.nav-style-1 .owl-nav .owl-prev {
    color: #191F62 !important;
    }
</style>
<style>
    .leaflet-popup-content {
        margin: 0px;
        width: 300px;
    }

    .leaflet-popup-content-wrapper{
        padding: 0px;
        overflow: hidden;
    }
    .leaflet-popup-content-wrapper h6{
        color: white;
        font-size: 16px;
        padding: 12px;
        text-align: center;
    }
    .leaflet-popup-content-wrapper p{
        font-size: 14px;
        padding: 0 16px;
        margin-bottom: 14px;
    }
    .leaflet-popup-content-wrapper img{
        width: 300px;
        max-height: 300px;
        padding: 0 10px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    @media screen and (max-width: 768px) {
        .peta{
            padding-top: 5%;
            padding-bottom: 5%;
        }

        .peta-container {
            height: 70vh;
        }
    }

    .peta-container {
        width: 100%;
        height: 90vh;
        position: relative;
        outline-style: groove;
        outline-width: 5px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 2%;
        margin-bottom: 5%;
    }

    .dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
    }

    .aktif {
        background-color: green;
        animation: blink 1s infinite;
    }

    .nonaktif {
        background-color: red;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

</style>
