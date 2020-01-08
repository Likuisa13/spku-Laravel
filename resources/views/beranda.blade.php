<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sistem Pemantau Kualitas Udara</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet"> <!--UBAH-->
  <link rel="stylesheet" href="assets/leaflet.css"/>

  <style>
  #mapid { min-height: 500px; }
</style>
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <a class="navbar-brand" href="/"> <!--UBAH-->
          <b>SPKU</b> - Sistem Pemantau Kualitas Udara
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('index') }}">Beranda</a> <!--UBAH-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/stasiun">Daftar Stasiun</a> <!--UBAH-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/dampak">Dampak ISPU</a> <!--UBAH-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/login">Log In</a> <!--UBAH-->
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4 container">
      <div class="card">
        <div class="card-body" id="mapid"></div>
      </div>
    </main>
  </div>
  <!-- Scripts -->
  <script src="assets/js/app.js"></script> <!--UBAH-->
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="assets/leaflet.js"></script>

  <script>

    function init(list) {
      var map = new L.Map('mapid');                       

      L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18
      }).addTo(map);
         map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.

         var jogja = new L.LatLng(-7.788446,110.373387); 
         map.setView(jogja, 12);
         
         var markers = list;

         for (var i=0; i<markers.length; i++) {

          var lat = parseFloat(markers[i][0]);
          var lon = parseFloat(markers[i][1]);
          var popupText = markers[i][2];

          var markerLocation = new L.LatLng(lat, lon);
          var marker = new L.Marker(markerLocation);
          map.addLayer(marker);

          marker.bindPopup(popupText);

        }

      }
    </script>
    <script>init({!! $list_stasiun !!})</script>
  </body>
  </html>
