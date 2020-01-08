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
    <link href="{{ URL::asset('assets/css/app.css') }}" rel="stylesheet"> <!--UBAH-->

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
                            <a class="nav-link" href="{{ route('index') }}">Beranda</a> <!--UBAH-->
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
        <div class="mb-3">
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
                                <td><a href="/stasiun/{{ $stasiun['id']}}">{{ $stasiun['nama'] }}</a></td>
                                <td>{{ $stasiun['alamat'] }}</td>
                                <td>{{ $stasiun['latitude'] }}</td>
                                <td>{{ $stasiun['longitude']}}</td>
                                <td class="text-center">
                                    <a href="/stasiun/{{ $stasiun['id']}}" id="show-outlet-1">Lihat Detail</a>
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
<!-- Scripts -->
<script src="{{ URL::asset('assets/js/app.js') }}"></script> <!--UBAH-->
</body>
</html>
