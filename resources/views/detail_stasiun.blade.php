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
    <link rel="stylesheet" href="{{ URL::asset('assets/leaflet.css')}}"/>

    <style>
    #mapid { min-height: 720px; }
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
                        <li class="nav-item">
                            <a class="nav-link" href="/">Beranda</a> <!--UBAH-->
                        </li>
                        <li class="nav-item active">
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Detail Stasiun</div>
                    <div class="card-body">
                        <table class="table table">
                            <tbody>
                                <tr><td>Nama Stasiun</td><td colspan="2">{{ $stasiun['nama'] }}</td></tr>
                                <tr><td>Alamat Stasiun</td><td colspan="2">{{ $stasiun['alamat'] }}</td><td></td></tr>
                                <tr><td>Lat, Long</td><td>{{ $stasiun['latitude'] }}, {{ $stasiun['longitude'] }}</td><td>Status : 
                                    @if($delay->delay >= 1)
                                        <strong>OFF</strong>
                                    @else
                                        <strong>ON</strong>
                                    @endif
                                </td></tr>
                                @if($last)
                                <tr><td> </td><td> </td><td></td></tr>
                                <tr><td><b>Parameter</b></td><td><b>Nilai</b><br>Update :<br> {{ $last->waktuPolusi }}</td><td><b>Kategori</b><br>Update : <br>{{ $last->waktuIspu }}</td></tr>
                                <tr><td>Suhu</td><td>{{ $last->suhu }} <sup>0</sup>C</td><td><center>-</center></td></tr>
                                <tr><td>Kelembaban</td><td>{{ $last->kelembaban }} %</td><td><center>-</center></td></tr>
                                <tr><td>CO</td><td>{{ $last->co }} &mu;g/m<sup>3</sup></td><td>{{ $last->Kco }}</td></tr>
                                <tr><td>Debu</td><td>{{ $last->debu }} &mu;g/m<sup>3</sup></td><td>{{ $last->Kdebu }}</td></tr>
                                <tr><td>NO2</td><td>{{ $last->no }} &mu;g/m<sup>3</sup></td><td>{{ $last->Kno2 }}</td></tr>
                                @else                     
                                <tr><td>Suhu</td><td>0 <sup>0</sup>C</td></tr>
                                <tr><td>Kelembaban</td><td>0 %</td></tr>
                                <tr><td>CO</td><td>0 &mu;g/m<sup>3</sup></td></tr>
                                <tr><td>Debu</td><td>0 &mu;g/m<sup>3</sup></td></tr>
                                <tr><td>NO2</td><td>0 &mu;g/m<sup>3</sup></td></tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="/stasiun" class="btn btn-link">Kembali ke Daftar Stasiun</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Lokasi</div>
                    <div class="card-body" id="mapid"></div>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ URL::asset('assets/js/app.js') }}"></script> <!--UBAH-->
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{ URL::asset('assets/leaflet.js') }}"></script>
<script>
    function show(lat,long,nama,suhu,kelembaban,co,debu,no,timePolusi, timeIspu, Kco, Kdebu, Kno2) {
        var map = L.map('mapid').setView([lat, long], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([lat, long]).addTo(map)
        .bindPopup('<div class="my-2"><center><strong>Nama Stasiun</strong><br>'+nama+'</center></div><div class="my-2"><center><strong>Koordinat:</strong><br>'+lat+', '+long+'</center></div><div class="my-2"><table border = "1"><tr><td><strong>Parameter</strong></td><td><center><strong>Nilai</strong></center>Update : <br> '+timePolusi+'</div><div class="my-2"></td><td><center><strong>Kategori</strong></center>Update : <br> '+timeIspu+'</div><div class="my-2"></td></tr><tr><td>Suhu</td><td> '+suhu+'<sup>0</sup>C</td><td><center>-</center></td></div><div class="my-2"></tr><tr><td>Kelembaban</td><td> '+kelembaban+' %</td><td><center>-</center></td></div><div class="my-2"></tr><tr><td>CO</td><td> '+co+' &mu;g/m<sup>3</sup></td><td>'+Kco+'</td></div><div class="my-2"></tr><tr><td>PM10</td><td> '+debu+' &mu;g/m<sup>3</sup></td><td>'+Kdebu+'</td></div><div class="my-2"></tr><tr><td>NO2</td><td> '+no+' &mu;g/m<sup>3</sup></td><td>'+Kno2+'</td></div><div class="my-2"><tr></table></div>');
    }
</script>
@if($last)
<script>show({{ $stasiun->latitude }},{{ $stasiun->longitude }},'{{ $stasiun->nama }}','{{ $last->suhu }}','{{ $last->kelembaban }}','{{ $last->co }}','{{ $last->debu }}','{{ $last->no }}','{{ $last->waktuPolusi }}','{{ $last->waktuIspu }}','{{ $last->Kco }}','{{ $last->Kdebu }}','{{ $last->Kno2 }}')</script>
@else
<script>show({{ $stasiun->latitude }},{{ $stasiun->longitude }},'{{ $stasiun->nama }}','0','0','0','0','0','-','-','0','0','0')</script>
@endif
</body>
</html>
