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
                            <a class="nav-link active" href="/dampakispu">Dampak ISPU</a> <!--UBAH-->
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

    <div><br><h3><center>PENGARUH INDEKS STANDAR PENCEMAR UDARA<br>UNTUK SETIAP PARAMETER PENCEMAR</center></h3><br></div>
    <div class="container">
        <table class="table table-bordered">
            <thead class="btn-primary disabled">
                <tr>
                    <td width="64">
                        <strong>Kategori</strong>
                    </td>
                    <td style="text-align: center;" width="65">
                        <strong>Rentang</strong>
                    </td>
                    <td style="text-align: center;" width="169">
                        <p><strong>Carbon Monoksida (CO)</strong></p>
                    </td>
                    <td style="text-align: center;" width="110">
                        <strong>Nitrogen (NO2)</strong>
                    </td>
                    <td style="text-align: center;" width="116">
                        <strong>Ozon O3</strong>
                    </td>
                    <td style="text-align: center;" width="97">
                        <p><strong>Sulfur Dioksida (SO2)</strong>
                        </td>
                        <td style="text-align: center;" width="85">
                            <strong>Partikulat</strong>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="64">
                            <p>Baik</p>
                        </td>
                        <td style="text-align: center;" width="65">
                            <p>0-50</p>
                        </td>
                        <td style="text-align: justify;" width="169">
                            <p>Tidak ada efek</p>
                        </td>
                        <td style="text-align: justify;" width="110">
                            <p>Sedikit berbau</p>
                        </td>
                        <td style="text-align: justify;" width="116">
                            <p>Luka pada Beberapa spesies tumbuhan akibat Kombinasi dengan SO2</p>
                            <p>(Selama 4 Jam)</p>
                        </td>
                        <td style="text-align: justify;" width="97">
                            <p>Luka pada Beberapa spesies tumbuhan akibat kombinasi dengan O3 (Selama 4 Jam)</p>
                        </td>
                        <td style="text-align: justify;" width="85">
                            <p>Tidak ada efek</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="64">
                            <p>Sedang</p>
                        </td>
                        <td style="text-align: center;" width="65">
                            <p>51 - 100</p>
                        </td>
                        <td style="text-align: justify;" width="169">
                            <p>Perubahan kimia darah tapi tidak terdeteksi</p>
                        </td>
                        <td style="text-align: justify;" width="110">
                            <p>Berbau</p>
                        </td>
                        <td style="text-align: justify;" width="116">
                            <p>Luka pada Babarapa spesies tumbuhan</p>
                        </td>
                        <td style="text-align: justify;" width="97">
                            <p>Luka pada Beberapa spesies lumbuhan</p>
                        </td>
                        <td style="text-align: justify;" width="85">
                            <p>Terjadi penurunan pada jarak pandang</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="64">
                            <p>Tidak Sehat</p>
                        </td>
                        <td style="text-align: center;" width="65">
                            <p>101 - 199</p>
                        </td>
                        <td style="text-align: justify;" width="169">
                            <p>Peningkatan pada kardiovaskularpada perokok yang sakit jantung</p>
                        </td>
                        <td style="text-align: justify;" width="110">
                            <p>Bau dan kehilangan warna. Peningkatan reaktivitas pembuluh tenggorokan pada penderita asma</p>
                        </td>
                        <td style="text-align: justify;" width="116">
                            <p>Penurunan kemampuan pada atlit yang berlatih keras</p>
                        </td>
                        <td style="text-align: justify;" width="97">
                            <p>Bau, Meningkatnya kerusakan tanaman</p>
                        </td>
                        <td style="text-align: justify;" width="85">
                            <p>Jarak pandang turun dan terjadi pengotoran debu di mana- mana</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="64">
                            <p>Sangat Tidak Sehat</p>
                        </td>
                        <td style="text-align: center;" width="65">
                            <p>200-299</p>
                        </td>
                        <td style="text-align: justify;" width="169">
                            <p>Maningkatnya kardiovaskular pada orang bukan perokok yang berpanyakit Jantung, dan akan tampak beberapa kalemahan yang terlihat secara nyata</p>
                        </td>
                        <td style="text-align: justify;" width="110">
                            <p>Meningkatnya sensitivitas pasien yang berpenyaklt asma dan bronhitis</p>
                        </td>
                        <td style="text-align: justify;" width="116">
                            <p>Olah raga ringan mangakibatkan pengaruh parnafasan pada pasien yang berpenyaklt paru- paru kronis</p>
                        </td>
                        <td style="text-align: justify;" width="97">
                            <p>Meningkatnya sensitivitas pada pasien berpenyakit asthma dan bronhitis</p>
                        </td>
                        <td style="text-align: justify;" width="85">
                            <p>Meningkatnya sensitivitas pada pasien berpenyakit asthma dan bronhitis</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="64">
                            <p>Berbahaya</p>
                        </td>
                        <td style="text-align: center;" width="65">
                            <p>300 - lebih</p>
                        </td>
                        <td style="text-align: justify;" colspan="5" width="576">
                            <p>Tingkat yang berbahaya bagi semua populasi yang terpapar</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script> <!--UBAH-->
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="{{ asset('assets/leaflet.js') }}"></script>
    </html>
