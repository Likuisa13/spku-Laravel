<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Pemantau Kualitas Udara</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet"> <!--UBAH-->
    <link rel="stylesheet" href="{{ URL::asset('assets/leaflet.css') }}"/>

    <style>
    #mapid { min-height: 330px; }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    SPKU - Sistem Pemantauan Kualitas Udara
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a> <!--UBAH-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dampakispu">Dampak ISPU</a> <!--UBAH-->
                        </li>
                        <!-- Authentication Links -->
                        @if(Auth::user())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tambah Stasiun Baru</div>
                    <form method="POST" action="{{ route('tambah') }}" accept-charset="UTF-8">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kode" class="control-label">Kode Stasiun</label>
                                <input id="kode" type="text" class="form-control" name="kode" value="" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="nama" class="control-label">Nama Stasiun</label>
                                <input id="nama" type="text" class="form-control" name="nama" value="" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="alaamt" class="control-label">Alamat Stasiun</label>
                                <textarea id="alamat" class="form-control" name="alamat" rows="4"></textarea>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude" class="control-label">Latitude</label>
                                        <input id="latitude" type="text" class="form-control" name="latitude" value="" required>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude" class="control-label">Longitude</label>
                                        <input id="longitude" type="text" class="form-control" name="longitude" value="" required>
                                        
                                    </div>
                                </div>
                            </div>
                            <div id="mapid"></div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" value="Tambah Stasiun Baru" class="btn btn-success">
                            <a href="{{ route('home') }}" class="btn btn-link">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('assets/js/app.js') }}"></script> <!--UBAH-->
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{ asset('assets/leaflet.js') }}"></script>
<script>
    var mapCenter = [-7.788446, 110.373387];
    var map = L.map('mapid').setView(mapCenter, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
</script>
</body>
</html>
