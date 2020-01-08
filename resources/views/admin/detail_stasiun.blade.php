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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet"> <!--UBAH-->
    <link rel="stylesheet" href="{{ URL::asset('assets/leaflet.css') }}"/>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var visitor = <?php echo $visitor; ?>;
      console.log(visitor);
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(visitor);
        var options = {
          title: 'ISPU Line Chart',
          curveType: 'function',
          legend: { position: 'bottom' }
      };
      var chart = new google.visualization.LineChart(document.getElementById('linechart'));
      chart.draw(data, options);
  }
</script>
<style> 
#mapid { min-height: 420px; }
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
                    <div class="card-header">Detail Stasiun</div>
                    <div class="card-body">
                        <table class="table table">
                            <tbody>
                                <tr><td>Nama Stasiun</td><td>{{ $stasiun->nama }}</td></tr>
                                <tr><td>Alamat Stasiun</td><td>{{ $stasiun->alamat }}</td></tr>
                                <tr><td>Latitude, longitude</td><td>{{ $stasiun->latitude }}, {{ $stasiun->longitude }}</td></tr>
                                <tr><td>Status Stasiun</td><td>
                                    @if($delay->delay >= 1)
                                        <strong>OFF</strong> Selama {{ $delay->delay }} Jam.
                                    @else
                                        <strong>ON</strong>
                                    @endif
                                </td></tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="/stasiun/ubah/{{ $stasiun->id }}" id="edit-outlet-1" class="btn btn-warning">Ubah Stasiun</a>
                        <a href="{{ route('home') }}" class="btn btn-link">Kembali ke Daftar Stasiun</a>
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
    <main class="py-4 container">
        <div class="card">
            <div class="card-header">Grafik ISPU</div>
            <div id="linechart" style="min-height: 330px"></div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <center><h3>DATA HASIL DARI SENSOR</h3></center>
                <table id="tabel-polusi" class="table table-striped table-bordered mt-1" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Waktu</th>
                            <th>Suhu</th>
                            <th>Kelembaban</th>
                            <th>CO</th>
                            <th>Debu (PM10)</th>
                            <th>NO2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($polusis)
                        @foreach($polusis as $polusi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $polusi->waktu }}</a></td>
                            <td>{{ $polusi->suhu }} <sup>0</sup>C</td>
                            <td>{{ $polusi->kelembaban }} %</td>
                            <td>{{ $polusi->co }} &mu;g/m<sup>3</sup></td>
                            <td>{{ $polusi->debu }} &mu;g/m<sup>3</sup> </td>
                            <td>{{ $polusi->no }} &mu;g/m<sup>3</sup> </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('assets/js/app.js') }}"></script> <!--UBAH--> 
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{ asset('assets/leaflet.js') }}"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

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
<script>show({{ $stasiun->latitude }},{{ $stasiun->longitude }},'{{ $stasiun->nama }}','0','0','0','0','0','0','0','0','0','0')</script>
@endif

<script>
    $(document).ready(function() {
        $('#tabel-polusi').DataTable();
    } );
</script>
</body>
</html>
