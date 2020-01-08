<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stasiun;

use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stasiuns = Stasiun::all(); 
        $jumlah = DB::table('stasiuns')->select(DB::raw('count(*) as jumlah'))->first();
        // dd($jumlah);
        return view('admin.daftar_stasiun',compact('stasiuns','jumlah'));
    }

    public function tambah()
    {
        return view('admin.tambah_stasiun');
    }

    public function store(Request $request)
    {
        DB::table('stasiuns')->insert([
            'kode' => $request->get('kode'),
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
        ]);

        return redirect('home');
    }

    public function detail($id)
    {
        $stasiun = DB::table('stasiuns')->where('id',$id)->first();
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

        $visit = DB::table('ispus')
            ->select(DB::raw('DAY(waktu) as tgl, Ico, Ino2, Idebu'))
            ->where('kode',$stasiun->kode)
            ->limit(7)
            ->orderBy('tgl','asc')
            ->get();

        $visitors[] = ['Tgl','CO','NO2', 'Debu (PM10)'];
        foreach ($visit as $key => $value) {
            $visitors[++$key] = [$value->tgl, (int)$value->Ico, (int)$value->Ino2, (int)$value->Idebu];
        }
        $visitor = json_encode($visitors);

        $delay = DB::table('polusis')
            ->select(DB::raw('TIMESTAMPDIFF(HOUR, max(waktu), now()) as delay'))
            ->where('kode', $stasiun->kode)
            ->first();
            //dd($delay);
        return view('admin.detail_stasiun',compact('stasiun','polusis','last','visitor','delay'));
    }

    public function ubah($id)
    {
        $stasiun = DB::table('stasiuns')->where('id',$id)->first();
        return view('admin.ubah_stasiun',compact('stasiun','polusis','last'));
    }

    public function update(Request $request)
    {
        DB::table('stasiuns')
        ->where('id',$request->get('id'))
        ->update([
            'kode' => $request->get('kode'),
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
        ]);

        return redirect('home'); 
    }

    public function hapus($id)
    {
        DB::table('stasiuns')->where('id',$id)->delete();
        return redirect('home');   
    }

    // public function statusAlat(){
    //     $selisih = DB::table('polusis')
    //         ->select(DB::raw('TIMESTAMPDIFF(HOUR, max(waktu), now()) as delay'))
    //          ->where('kode', 'JGJSLM04')
    //         ->get();
    //     dd($selisih);
    // }

}
