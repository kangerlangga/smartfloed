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
</style>
<main>
    @include('layouts.public.styleberanda')
    @include('layouts.public.nav')
    <content>
        <!--Banner-->
        <div class="banner-detail">
            <div class="img-top gbr-atas" >
                <img src="{{ asset('assets/img/bpbd.jpg') }}">
            </div>
            <div class="container">
                <div class="row mb-2">
                    <div class="col-md">
                        <div class="card shadow animate__animated animate__fadeInUp">
                            <h5 class="card-header text-white text-center text-uppercase" style="background-color: #FF8E00;">Selamat Datang di Smart Flood Early Detection</h5>
                            <div class="row g-0">
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: justify; margin-right: 3px">Smart Flood Early Detection adalah suatu sistem yang dirancang untuk mendeteksi secara dini potensi banjir dan memberikan peringatan kepada masyarakat sekitar. Sistem ini terintegrasi dengan sebuah alat pintar untuk pemantauan secara real-time agar dapat meningkatkan kesiapsiagaan dan respons masyarakat terhadap ancaman banjir, sehingga dapat meminimalisir dampak yang ditimbulkan.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($jI > 0) : ?>
        <div class="owlone owl-carousel mb-0">
            @foreach ($Infografis as $I)
            <div class="item">
                <img src="{{ url('') }}/assets/foto/infografis/{{ $I->foto_infografis }}"/>
            </div>
            @endforeach
        </div>
        <?php endif;?>

        <!-- Peta -->
        <?php if ($jL > 0) : ?>
        <section class="pb-2 text-white" style="background-color: #FF8E00;">
        <div class="container">
            <div class="text-center pt-4">
                <h1><strong>Peta Interaktif</strong></h1>
            </div>
            <div class="peta">
                <div id="petaSebaran" class="peta-container"></div>
            </div>
        </div>
        </section>
        <?php endif;?>

        <!-- Kontak -->
        <?php if ($jK > 0) : ?>
        @foreach ($Kontak as $K)
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 mt-3">
                <div class="col">
                    <div class="m-0 pb-5 pb-lg-0">
                        <div class="d-flex justify-content-start mb-1">
                            <div>
                                <h2 class="fw-bold mb-3">Kontak Kami</h2>
                                <div class="underbar ms-0"></div>
                            </div>
                        </div>
                        <p class="mb-2 fw-bold">Email :</p>
                        <p class="mb-3">{{ $K->email_kontak }}</p>
                        <p class="mb-2 fw-bold">Kontak :</p>
                        <p class="mb-1">Telepon : +62 {{ $K->telp_kontak }}
                            {{ $K->wa_kontak == 'Tersedia' ? '(Whatsapp)' : '' }}
                        </p>
                        <?php if ($K->wa_kontak == 'Tersedia') : ?>
                        <a href="https://api.whatsapp.com/send/?phone=62{{ $K->telp_kontak }}" target="_blank" class="btn btn-success">Chat Sekarang!</a>
                        <?php endif;?>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <div class="d-flex justify-content-start mb-1">
                            <div>
                                <h2 class="fw-bold mb-3">Alamat</h2>
                                <div class="underbar ms-0"></div>
                            </div>
                        </div>
                        <p class="mb-2"><b>Kantor Kepala Desa Kedungbanteng</b><br>{{ $K->alamat_kontak }}</p>
                    </div>
                    <section class="rounded google-map overflow-hidden shadow-sm p-0" style="min-height: 350px; height: calc(100% - 372px);">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.601908553132!2d112.737122374116!3d-7.509122074079525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e76002b822f3%3A0x547bbc80e0d2581d!2sKantor%20Kepala%20Desa%20Kedungbanteng!5e0!3m2!1sid!2sid!4v1720089303988!5m2!1sid!2sid" width="500" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </section>
                </div>
            </div>
        </div>
        @endforeach
        <?php endif;?>

    </content>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ensure the element is available
            function checkElements() {
                var ketinggianAirElement = document.getElementById("ketinggian-air");
                var statusElement = document.getElementById("status");
                var sensorElement = document.getElementById("sensor");
                var sensorDotElement = document.getElementById("sensor-dot");

                if (ketinggianAirElement === null || statusElement === null || sensorElement === null) {
                    console.error("Required elements not found!");
                    return false;
                }
                return { ketinggianAirElement, statusElement, sensorElement, sensorDotElement };
            }

            let lastMessageTime = new Date();

            // Wait for Paho MQTT library to be fully loaded
            function checkPahoLoaded() {
                if (typeof Paho !== "undefined") {
                    initializeMQTT();
                } else {
                    console.error("Paho MQTT library not loaded yet. Retrying...");
                    setTimeout(checkPahoLoaded, 100);
                }
            }

            function initializeMQTT() {
                // Create a client instance
                var client = new Paho.Client("test.mosquitto.org", Number(8081), "SMARTFLOED_" + parseInt(Math.random() * 100, 10));

                // Set callback handlers
                client.onConnectionLost = onConnectionLost;
                client.onMessageArrived = onMessageArrived;

                // Connect the client
                client.connect({
                    onSuccess: onConnect,
                    onFailure: onFailure,
                    useSSL: true
                });

                // Called when the client connects
                function onConnect() {
                    console.log("onConnect");
                    client.subscribe("mqtt/smartfloed/water-height/Lokasi9fcvJUYNQoQNKmVPY5szW0DYY3ncFZ");

                    var message = new Paho.Message("OK");
                    message.destinationName = "mqtt/web";
                    client.send(message);
                    console.log("Message sent to mqtt/web");
                }

                // Called when the client fails to connect
                function onFailure(responseObject) {
                    console.log("onFailure: " + responseObject.errorMessage);
                }

                // Called when the client loses its connection
                function onConnectionLost(responseObject) {
                    if (responseObject.errorCode !== 0) {
                        console.log("onConnectionLost:" + responseObject.errorMessage);
                    }
                }

                // Called when a message arrives
                function onMessageArrived(message) {
                    if (message.destinationName == "mqtt/smartfloed/water-height/Lokasi9fcvJUYNQoQNKmVPY5szW0DYY3ncFZ") {
                        // console.log("Message received: " + message.payloadString);
                        let ketinggianAirRaw = Math.round(message.payloadString);
                        let ketinggianAir = 0;
                        var elements = checkElements();
                        if (!elements) return;

                        if (ketinggianAirRaw >= 0) {
                            ketinggianAir = ketinggianAirRaw;
                        }else{
                            ketinggianAir = 0;
                        }

                        elements.ketinggianAirElement.textContent = ketinggianAir;

                        lastMessageTime = new Date();

                        // Update the status based on the water level
                        if (ketinggianAir >= 140) {
                            elements.statusElement.textContent = "Awas";
                            elements.statusElement.style.color = "red";
                        } else if (ketinggianAir >= 120) {
                            elements.statusElement.textContent = "Siaga";
                            elements.statusElement.style.color = "orange";
                        } else if (ketinggianAir >= 100) {
                            elements.statusElement.textContent = "Waspada";
                            elements.statusElement.style.color = "yellow";
                        } else {
                            elements.statusElement.textContent = "Normal";
                            elements.statusElement.style.color = "green";
                        }

                        // Mark the sensor as aktif
                        elements.sensorElement.textContent = "Aktif";
                        elements.sensorElement.style.color = "green";
                        elements.sensorDotElement.classList.remove("nonaktif");
                        elements.sensorDotElement.classList.add("aktif");
                    }
                }
            }

            // Start checking if Paho is loaded
            checkPahoLoaded();

            // Check if the sensor is aktif
            setInterval(function() {
                let currentTime = new Date();
                let timeDiff = currentTime - lastMessageTime;

                var elements = checkElements();
                if (!elements) return;

                // If no data received for more than 10 seconds, mark sensor as nonaktif
                if (timeDiff > 10000) {
                    elements.sensorElement.textContent = "Nonaktif";
                    elements.sensorElement.style.color = "red";
                    elements.sensorDotElement.classList.remove("aktif");
                    elements.sensorDotElement.classList.add("nonaktif");

                    // Update the status based on the water level
                    @foreach ($Lokasi as $L)
                    let ketinggianAir = {{ $L->ketinggian_lokasi }};
                    if (ketinggianAir >= 140) {
                        elements.statusElement.textContent = "Awas";
                        elements.statusElement.style.color = "red";
                    } else if (ketinggianAir >= 120) {
                        elements.statusElement.textContent = "Siaga";
                        elements.statusElement.style.color = "orange";
                    } else if (ketinggianAir >= 100) {
                        elements.statusElement.textContent = "Waspada";
                        elements.statusElement.style.color = "yellow";
                    } else {
                        elements.statusElement.textContent = "Normal";
                        elements.statusElement.style.color = "green";
                    }
                    @endforeach
                }
            }, 5000);

            // Handle popup events
            map.on('popupopen', function() {
                var elements = checkElements();
                if (!elements) return;

                // Recheck sensor status on popup open
                let currentTime = new Date();
                let timeDiff = currentTime - lastMessageTime;

                if (timeDiff > 10000) {
                    elements.sensorElement.textContent = "Nonaktif";
                    elements.sensorElement.style.color = "red";
                    elements.sensorDotElement.classList.remove("aktif");
                    elements.sensorDotElement.classList.add("nonaktif");

                    // Update the status based on the water level
                    @foreach ($Lokasi as $L)
                    let ketinggianAir = {{ $L->ketinggian_lokasi }};
                    if (ketinggianAir >= 140) {
                        elements.statusElement.textContent = "Awas";
                        elements.statusElement.style.color = "red";
                    } else if (ketinggianAir >= 120) {
                        elements.statusElement.textContent = "Siaga";
                        elements.statusElement.style.color = "orange";
                    } else if (ketinggianAir >= 100) {
                        elements.statusElement.textContent = "Waspada";
                        elements.statusElement.style.color = "yellow";
                    } else {
                        elements.statusElement.textContent = "Normal";
                        elements.statusElement.style.color = "green";
                    }
                    @endforeach
                } else {
                    elements.sensorElement.textContent = "Aktif";
                    elements.sensorElement.style.color = "green";
                    elements.sensorDotElement.classList.remove("nonaktif");
                    elements.sensorDotElement.classList.add("aktif");
                }
            });
        });
    </script>
    <script src="{{ asset('js/boundary.js') }}"></script>
    <script type="text/javascript">

        var redHome = L.icon({
            iconUrl: '{{ asset('assets/img/home-red.png') }}',

            iconSize:     [25, 38], // size of the icon
            shadowSize:   [0, 0], // size of the shadow
            iconAnchor:   [12, 39], // point of the icon which will correspond to marker's location
            shadowAnchor: [0, 0],  // the same for the shadow
            popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
        });

        var yellowHome = L.icon({
            iconUrl: '{{ asset('assets/img/home-yellow.png') }}',

            iconSize:     [25, 38], // size of the icon
            shadowSize:   [0, 0], // size of the shadow
            iconAnchor:   [12, 39], // point of the icon which will correspond to marker's location
            shadowAnchor: [0, 0],  // the same for the shadow
            popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
        });

        var greenHome = L.icon({
            iconUrl: '{{ asset('assets/img/home-green.png') }}',

            iconSize:     [25, 38], // size of the icon
            shadowSize:   [0, 0], // size of the shadow
            iconAnchor:   [12, 39], // point of the icon which will correspond to marker's location
            shadowAnchor: [0, 0],  // the same for the shadow
            popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
        });

        var blueHome = L.icon({
            iconUrl: '{{ asset('assets/img/home-blue.png') }}',

            iconSize:     [25, 38], // size of the icon
            shadowSize:   [0, 0], // size of the shadow
            iconAnchor:   [12, 39], // point of the icon which will correspond to marker's location
            shadowAnchor: [0, 0],  // the same for the shadow
            popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
        });

        //Google Street
        googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        //Hybrid
        googleHybrid = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        //Google Satelite
        googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        //Terrain
        googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        //Define Maps
        const map = L.map('petaSebaran', {
            center: [-7.509317525716186, 112.73983945187702],
            zoom: 17,
            layers: [googleStreets],
            attributionControl: false
        });

        const baseLayers = {
            'Google Street': googleStreets,
            'Google Hybrid': googleHybrid,
            'Google Satelite': googleSat,
            'Google Terrain': googleTerrain,
        };

        const layerControl = L.control.layers(baseLayers).addTo(map);

        var options = {
            flyTo : true,
        };
        L.control.locate(options).addTo(map);

        const correctedBoundary = boundary.map(coord => [coord[1], coord[0]]);
        const polygon = L.polygon(correctedBoundary, {color: 'orange'}).addTo(map);

        <?php if ($jL <= 0) : ?>
        map.fitBounds(polygon.getBounds());
        <?php endif;?>

        <?php if ($jL > 0) : ?>
        @foreach ($Lokasi as $L)
        L.marker([{{ $L->latlng_lokasi }}], {icon: redHome})
        .bindPopup('<h6 style="background-color: red;"><b>{{ $L->nama_lokasi }}</b></h6>' +
                '<img src="{{ url('') }}/assets/foto/lokasi/{{ $L->foto_lokasi }}" width="150px">'+
                '<p>Ketinggian Air : <b><span id="ketinggian-air">{{ $L->ketinggian_lokasi }}</span> CM</b><br>' +
                'Status : <b><span id="status" style="color: green">{{ $L->status_lokasi }}</span></b><br>' +
                'Sensor : <b><span id="sensor" style="color: green">{{ $L->sensor_lokasi }}</span>   <span class="dot aktif" id="sensor-dot"></span></b></p>')
        .addTo(map)
        .openPopup();

        var status = document.getElementById('status').textContent.trim();
        var color;
        switch (status) {
            case 'Awas':
                color = 'red';
                break;
            case 'Siaga':
                color = 'orange';
                break;
            case 'Waspada':
                color = 'yellow';
                break;
            default:
                color = 'green';
        }
        document.getElementById('status').style.color = color;
        @endforeach
        <?php endif;?>

    </script>
</main><!-- End #main -->
@include('layouts.public.footer')
@include('layouts.public.scriptberanda')
@endsection

<body>
    @yield('content')
</body>
</html>
