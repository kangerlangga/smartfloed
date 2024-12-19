@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
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
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-uppercase mb-0 font-weight-bold text-gray-800">
                            <span class="text-success text-lg text-capitalize">Infografis</span>
                        </div>
                        <div class="text-lg font-weight-bold text-dark mb-1">
                            <i class="fas fa-fw fa-solid fa-eye"></i> {{ $jIs }} Item
                            <?php if ($jIh > 0) : ?>
                            | <i class="fas fa-fw fa-solid fa-eye-slash"></i> {{ $jIh }} Item
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-images fa-2x text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-uppercase mb-0 font-weight-bold text-gray-800">
                        <span class="text-info text-lg text-capitalize">Lokasi</span>
                        </div>
                        <div class="text-lg font-weight-bold text-dark mb-1">
                            <i class="fas fa-fw fa-solid fa-eye"></i> {{ $jLs }} Tempat
                            <?php if ($jLh > 0) : ?>
                            | <i class="fas fa-fw fa-solid fa-eye-slash"></i> {{ $jLh }} Tempat
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-location-dot fa-2x text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-uppercase mb-0 font-weight-bold text-gray-800">
                        <span class="text-danger text-lg text-capitalize">Edukasi</span>
                        </div>
                        <div class="text-lg font-weight-bold text-dark mb-1">
                            <i class="fas fa-fw fa-solid fa-eye"></i> {{ $jEs }} Item
                            <?php if ($jEh > 0) : ?>
                            | <i class="fas fa-fw fa-solid fa-eye-slash"></i> {{ $jEh }} Item
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-6 mb-4">
        <div class="peta">
            <div id="petaSebaran" class="peta-container"></div>
        </div>
    </div>

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Ketinggian Air</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>


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

        const polygon = L.polygon(boundary, {color: 'orange'}).addTo(map);

        <?php if ($jL <= 0) : ?>
        map.fitBounds(polygon.getBounds());
        <?php endif;?>

        <?php if ($jL > 0) : ?>
        @foreach ($Lokasi as $L)
        L.marker([{{ $L->latlng_lokasi }}], {icon: redHome})
        .bindPopup('<h6 style="background-color: red;"><b>{{ $L->nama_lokasi }}</b></h6>' +
                '<video width="300" height="auto" controls autoplay><source src="{{ url('') }}/assets/video/lokasi/video.mp4" type="video/mp4">Your browser does not support the video tag.</video>' +
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        // Set default font family and font color
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["", "", "", "", "", "", "", "", "", "", "", "", ],
                datasets: [{
                    label: "Ketinggian",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.3)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [0],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 10,
                            padding: 10,
                            callback: function(value, index, values) {
                                return value.toFixed(2);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            var value = tooltipItem.yLabel.toFixed(2);
                            return datasetLabel + ': ' + value + ' CM';
                        }
                    }

                }
            }
        });

        // MQTT Client setup
        var mqttClient = new Paho.Client("test.mosquitto.org", Number(8081), "SMARTFLOED_" + parseInt(Math.random() * 100, 10));

        mqttClient.onMessageArrived = function (message) {
            // console.log("Message arrived: " + message.payloadString);
            var distanceRaw = parseFloat(message.payloadString);
            var distance = 0;
            if (distanceRaw >= 0) {
                distance = distanceRaw;
            }else{
                distance = 0;
            }

            // Update the chart data
            var newData = myLineChart.data.datasets[0].data;
            newData.push(distance);
            if (newData.length > 12) {
                newData.shift(); // Maintain only last 12 points
            }
            myLineChart.data.datasets[0].data = newData;
            myLineChart.update();
        };


        mqttClient.onConnectionLost = function (responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("Connection lost: " + responseObject.errorMessage);
            }
        };

        mqttClient.connect({
            onSuccess: function () {
                console.log("Connected to MQTT broker");
                mqttClient.subscribe("mqtt/smartfloed/water-height/Lokasi9fcvJUYNQoQNKmVPY5szW0DYY3ncFZ");
            },
            onFailure: function (message) {
                console.log("Connection failed: " + message.errorMessage);
            }
        });


    </script>
</div>
<script>
    //message with sweetalert
    @if(session('successprof'))
        Swal.fire({
            icon: "success",
            title: "{{ session('successprof') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @elseif(session('successlog'))
        Swal.fire({
            icon: "success",
            title: "{{ session('successlog') }}",
            text: 'Disarankan Membuka Halaman Administrasi Dengan Komputer atau Laptop!',
        });
    @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="{{  url('') }}/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

@endsection
