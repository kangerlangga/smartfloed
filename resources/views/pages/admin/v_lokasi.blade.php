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
<div class="container">
    <?php if ($jL == 1) : ?>
    @foreach ($Lokasi as $L)
    <p class="font-italic text-danger mt-3">Terakhir Diperbarui : <b>{{ $L->update_tgl }} </b>
        @if (Auth::user()->level == 'Super Admin')
        <b>({{ $L->modified_by }})</b>
        @endif
    </p>
    @if ($L->visib_lokasi == 'Tampilkan')
        <p class="font-italic text-success"><i class="fas fa-fw fa-solid fa-eye"></i> Published</p>
    @elseif ($L->visib_lokasi == 'Sembunyikan')
        <p class="font-italic text-warning"><i class="fas fa-fw fa-solid fa-eye-slash"></i> Unpublished</p>
    @endif
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="peta">
                <div id="petaSebaran" class="peta-container"></div>
            </div>
        </div>

        <div class="col-xl-12 col-md-6 mb-4 table-responsive">
            <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                    <tr>
                        <td class="text-uppercase font-weight-bold w-25">Deskripsi</td>
                        <td>:</td>
                        <td>{{ $L->nama_lokasi }}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase font-weight-bold">Ketinggian Air</td>
                        <td>:</td>
                        <td>{{ $L->ketinggian_lokasi }}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase font-weight-bold">Status</td>
                        <td>:</td>
                        <td>{{ $L->status_lokasi }}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase font-weight-bold">Sensor</td>
                        <td>:</td>
                        <td>{{ $L->sensor_lokasi }}</td>
                    </tr>                                                                                                      </tbody>
            </table>
        </div>
        <form action="{{ route('lokasi.edit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="id" value="{{ $L->id_lokasi }}">
            <button type="submit" class="btn btn-warning">Perbarui Detail Lokasi</button>
        </form>
        @endforeach
        <?php endif;?>
    </div>
</div>
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

</script>
<script>
    //message with sweetalert
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endsection
