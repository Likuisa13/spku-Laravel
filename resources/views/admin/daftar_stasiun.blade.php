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
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
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
        <div class="mb-3">
            <div class="float-right">
                <a href="{{ route('tambah-stasiun') }}" class="btn btn-success">Tambah Stasiun Baru</a>
                <a href="{{ route('export') }}" class="btn btn-secondary">Export Data Ispu</a>
            </div>
            <h1 class="page-title">Daftar Stasiun <small>Total : {{ $jumlah->jumlah }} Stasiun</small></h1> <!--UBAH-->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-sm table-responsive-sm">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Stasiun</th>
                                <th>Alamat Stasiun</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stasiuns as $stasiun)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><a href="/stasiun/detail/{{ $stasiun['id']}}">{{ $stasiun['nama'] }}</a></td>
                                <td>{{ $stasiun['alamat'] }}</td>
                                <td>{{ $stasiun['latitude'] }}</td>
                                <td>{{ $stasiun['longitude']}}</td>
                                <td class="text-center">
                                    <a href="/stasiun/detail/{{ $stasiun['id']}}" id="show-outlet-1">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-body">
                        <ul class="pagination" role="navigation">
                            <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous">
                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="" rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
<!-- Scripts -->
<script src="{{ asset('assets/js/app.js') }}"></script> <!--UBAH-->
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{ asset('assets/leaflet.js') }}"></script>
</html>