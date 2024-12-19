@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
<div id="preloader"></div>
<style>
    .form-group {
        margin-top: 17px;
    }
    .form-group input, select{
        margin-top: 3px;
    }
    .btn {
        width: 100px;
        margin-right: 5px;
    }
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
<form method="POST" action="{{ route('lokasi.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{ $EditLokasi->id_lokasi }}">

        <div class="col-sm-12">
            <div class="form-group">
                <label for="Foto">Foto Lokasi Peletakan Alat (PNG, JPG, JPEG) <b>Maksimal 3 MB</b> Ukuran Standar 800px x 450px</label>
                <input class="form-control-file @error('Foto') is-invalid @enderror" name="Foto" id="Foto" type="file" accept=".png, .jpg, .jpeg" @error('Foto') aria-describedby="FotoFeedback" @enderror>
                @error('Foto')
                <div id="FotoFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Nama">Deskripsi Letak Alat</label>
                <input class="form-control @error('Nama') is-invalid @enderror" name="Nama" value="{{ old('Nama', $EditLokasi->nama_lokasi) }}" id="Nama" type="Nama" @error('Nama') aria-describedby="NamaFeedback" @enderror required>
                @error('Nama')
                <div id="NamaFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Ketinggian">Ketinggian Air (0 - 150)</label>
                <div class="input-group mb-3">
                    <input class="form-control @error('Ketinggian') is-invalid @enderror" type="number" min="0" max="150" name="Ketinggian" value="{{ old('Ketinggian', $EditLokasi->ketinggian_lokasi) }}" id="Ketinggian" @error('Ketinggian') aria-describedby="KetinggianFeedback" @enderror required>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="Ketinggianon">CM</span>
                    </div>
                    @error('Ketinggian')
                    <div id="KetinggianFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Sensor">Sensor Ketinggian Air</label>
                <br>
                <select name='Sensor' id='Sensor' class="form-control">
                    <option name='Sensor' value='Aktif' {{ $EditLokasi->sensor_lokasi == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option name='Sensor' value='Nonaktif' {{ $EditLokasi->sensor_lokasi == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Status">Status Peringatan</label>
                <input class="form-control @error('Status') is-invalid @enderror" name="Status" value="{{ old('Status', $EditLokasi->status_lokasi) }}" id="Status" @error('Status') aria-describedby="StatusFeedback" @enderror readonly style="cursor: not-allowed;">
                @error('Status')
                <div id="StatusFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Visibilitas">Visibilitas Titik Alat</label>
                <br>
                <select name='visibilitas' id='Visibilitas' class="form-control">
                    <option name='visibilitas' value='Tampilkan' {{ $EditLokasi->visib_lokasi == 'Tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    <option name='visibilitas' value='Sembunyikan' {{ $EditLokasi->visib_lokasi == 'Sembunyikan' ? 'selected' : '' }}>Sembunyikan</option>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Latlng">Latitude & Longitude <b>(Klik Pada Peta)</b></label>
                <input class="form-control @error('Latlng') is-invalid @enderror" name="Latlng" value="{{ old('Latlng', $EditLokasi->latlng_lokasi) }}" id="Latlng" @error('Latlng') aria-describedby="LatlngFeedback" @enderror readonly style="cursor: not-allowed;">
                @error('Latlng')
                <div id="LatlngFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-xl-12 col-md-6 mb-4">
            <div class="peta">
                <div id="petaSebaran" class="peta-container"></div>
            </div>
        </div>

    </div>
    <br>
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    <a href="{{ route('lokasi.data') }}" class="btn btn-success tbl-kembali">KEMBALI</a>
</form>
<hr>
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

    var marker = new L.marker([{{ $EditLokasi->latlng_lokasi }}], {icon: redHome, draggable: false})
    .bindPopup('<h6 style="background-color: red;"><b>{{ $EditLokasi->nama_lokasi }}</b></h6>' +
            '<img src="{{ url('') }}/assets/foto/lokasi/{{ $EditLokasi->foto_lokasi }}" width="150px">'+
            '<p>Ketinggian Air : <b><span id="ketinggian-air">{{ $EditLokasi->ketinggian_lokasi }}</span> CM</b><br>' +
            'Status : <b><span id="status" style="color: green">{{ $EditLokasi->status_lokasi }}</span></b><br>' +
            'Sensor : <b><span id="sensor" style="color: green">{{ $EditLokasi->sensor_lokasi }}</span>   <span class="dot aktif" id="sensor-dot"></span></b></p>')
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

    var latlngInput = document.querySelector("[name=Latlng]");
    var curLocation = [{{ $EditLokasi->latlng_lokasi }}];
    map.attributionControl.setPrefix(false);

    //get coordinates when map click
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if(!marker){
            marker = L.marker(e.latlng).addTo(map);
        }else{
            marker.setLatLng(e.latlng);
        }
        latlngInput.value = lat + ', ' + lng;
    });

    map.addLayer(marker);

</script>
<script type="text/javascript">

    $(document).ready(function() {
        $('#Ketinggian').on('input', function() {
            var ketinggian = $(this).val();
            if (ketinggian >= 140) {
                $('#Status').val('Awas');
            } else if (ketinggian >= 120) {
                $('#Status').val('Siaga');
            } else if (ketinggian >= 100) {
                $('#Status').val('Waspada');
            } else {
                $('#Status').val('Normal');
            }
        });
    });

    $(document).on('click','.tbl-kembali',function(e) {

    //Hentikan aksi default
    e.preventDefault();
    const href1 = $(this).attr('href');

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Perubahan Tidak Akan Disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#fd7e14',
            confirmButtonText: 'KEMBALI',
            cancelButtonText: 'BATAL'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href1;
            }
        })
    })
</script>

@endsection
