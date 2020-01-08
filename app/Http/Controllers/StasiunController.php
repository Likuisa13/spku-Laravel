<?php

namespace App\Http\Controllers; 

use App\Stasiun;
use Illuminate\Http\Request;
use DB;

class StasiunController extends Controller
{
    public function all_stasiun()
    {
        $waktu = DB::table('polusis')->select(DB::raw('max(waktu) as waktu'))->groupBy('kode')->pluck('waktu');
        $ispus = DB::table('ispus')->select(DB::raw('max(waktu) as waktu'))->groupBy('kode')->pluck('waktu');

        $stasiuns = DB::table('stasiuns')
        ->join('polusis','stasiuns.kode','=','polusis.kode')
        ->join('ispus','stasiuns.kode','=','ispus.kode')
        ->select('stasiuns.*','polusis.*','ispus.*','ispus.waktu as waktuIspu','polusis.waktu as waktuPolusi')
        ->whereIn('polusis.waktu',$waktu)
        ->whereIn('ispus.waktu',$ispus)
        ->get();
        // dd($stasiuns);
        $list_stasiun = collect([]);
        foreach ($stasiuns as $stasiun) {

            $list_stasiun->push([$stasiun->latitude,$stasiun->longitude,
                "<div class=\"my-2\">
                <center><strong>Nama Stasiun:</strong><br>".$stasiun->nama."</center></div><div class=\"my-2\">
                <center><strong>Koordinat:</strong><br>".$stasiun->latitude.", ".$stasiun->longitude."</center></div><div class=\"my-2\">
                <table border = '1'>
                <tr>
                <td><strong>Parameter</strong></td>
                <td><center><strong>Nilai</strong></center>Update : <br> ".$stasiun->waktuPolusi."</div><div class=\"my-2\"></td>
                <td><center><strong>Kategori</strong></center>Update : <br> ".$stasiun->waktuIspu."</div><div class=\"my-2\"></td>
                </tr>
                <tr><td>Suhu</td><td> ".$stasiun->suhu." <sup>0</sup>C</td><td><center> - </center></td></div><div class=\"my-2\"></tr>
                <tr><td>Kelembaban</td><td> ".$stasiun->kelembaban." %</td><td><center> - </center></td></div><div class=\"my-2\"></tr>
                <tr><td>CO</td><td> ".$stasiun->co." &mu;g/m<sup>3</sup></td><td>".$stasiun->Kco."</td></div><div class=\"my-2\"></tr>
                <tr><td>PM10</td><td> ".$stasiun->debu." &mu;g/m<sup>3</sup></td><td>".$stasiun->Kdebu."</td></div><div class=\"my-2\"></tr>
                <tr><td>NO2</td><td> ".$stasiun->no." &mu;g/m<sup>3</sup></td><td>".$stasiun->Kno2."</td></div><div class=\"my-2\">
                <tr></table>
                "]);
            
        }
        $list_stasiun = collect($list_stasiun);
        // dd($list_stasiun);

        return view('beranda',compact('stasiuns','list_stasiun'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stasiuns = Stasiun::all();
        $jumlah = DB::table('stasiuns')->select(DB::raw('count(*) as jumlah'))->first();

        return view('daftar_stasiun',compact('stasiuns','jumlah'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stasiun  $stasiun
     * @return \Illuminate\Http\Response
     */
    public function show(Stasiun $stasiun)
    {
        $polusis = DB::table('polusis')->where('kode',$stasiun->kode)->orderBy('waktu','desc')->get();
        $waktu = DB::table('polusis')->select(DB::raw('max(waktu) as waktu'))->groupBy('kode')->pluck('waktu');
        $ispus = DB::table('ispus')->select(DB::raw('max(waktu) as waktu'))->groupBy('kode')->pluck('waktu');

        $last = DB::table('stasiuns')
            ->join('polusis','stasiuns.kode','=','polusis.kode')
            ->join('ispus','stasiuns.kode','=','ispus.kode')
            ->select('stasiuns.*','polusis.*','ispus.*','ispus.waktu as waktuIspu','polusis.waktu as waktuPolusi')
            ->whereIn('polusis.waktu',$waktu)
            ->whereIn('ispus.waktu',$ispus)
            ->where('stasiuns.kode',$stasiun->kode)
            ->first();

        $delay = DB::table('polusis')
            ->select(DB::raw('TIMESTAMPDIFF(HOUR, max(waktu), now()) as delay'))
            ->where('kode', $stasiun->kode)
            ->first();
        // dd($last);
        return view('detail_stasiun',compact('stasiun','polusis','last','delay'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stasiun  $stasiun
     * @return \Illuminate\Http\Response
     */
    public function edit(Stasiun $stasiun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stasiun  $stasiun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stasiun $stasiun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stasiun  $stasiun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stasiun $stasiun)
    {
        //
    }
}
