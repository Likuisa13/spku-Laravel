<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class IspuController extends Controller
{
	public function dampak()
    {
        return view('dampak');
    }	
	
	public function dampakIspu()
    {
        return view('admin.dampak');
    }	


	public function jalan(){
		date_default_timezone_set('Asia/Jakarta');
		$day = /*date('Y-m-d')*/"2019-05-16"." 15:00:00";
		$yesterday = /*date("Y-m-j", strtotime( '-1 days' ))*/"2019-05-11"." 15:00:00";

		$nilai = DB::table('polusis')
				->select(DB::raw('kode, round(avg(co),2) as co, round(avg(debu),2) as debu, round(avg(no),2) as no2'))
				->where('suhu', '>', '25')
				->whereBetween('waktu', array($yesterday, $day))
				->groupBy('kode')
				->get();
		 //dd($nilai);
		foreach ($nilai as $value) {
			//echo $value->debu."<br>";
			$kode = $value->kode;
			$Ico = IspuController::hitungIspu($value->co,"co");
			$Idebu = IspuController::hitungIspu($value->debu,"pm10");
			$Ino2 = IspuController::hitungIspu($value->no2,"no2");

			$Kco = IspuController::kategori($Ico);
			$Kdebu = IspuController::kategori($Idebu);
			$Kno2 = IspuController::kategori($Ino2);
			//echo $Ico." ".$Kco." ".$Idebu." ".$Kdebu." ".$Ino2." ".$Kno2."<br>";
			IspuController::store($kode, $Ico, $Idebu, $Ino2, $Kco, $Kdebu, $Kno2);
		}
		
	}

	static function hitungIspu($Xx,$partikulat){
		$ambien;
		$batas = [0,50,100,200,300,400,500];
		$indeks = 0;
		$n=5;
		$Ia = 0;
		$Ib = 0; 
		$Xa = 0; 
		$Xb = 0;
		if ($partikulat == "co")
			$ambien = [0,5,10,17,34,46,57.5];
		elseif ($partikulat == "pm10")
			$ambien = [0,50,150,350,420,500,600];
		elseif ($partikulat == "no2"){
			$ambien = [0,1130,2260,3000,3750];
			$batas = [0,200,300,400,500,600];
			$n =4;
		}
		elseif ($partikulat == "so2")
			$ambien = [0,80,365,800,1600,2100,2620];
		else
			$ambien = [0,120,253,400,800,1000,1200];

		for ($i=0; $i < $n ; $i++) { 
			if ($Xx > $ambien[$i] && $Xx <= $ambien[$i+1]) {
				$Ia = $batas[$i+1];
				$Ib = $batas[$i];
				$Xa = $ambien[$i+1];
				$Xb = $ambien[$i];
			}   
		}

		$indeks = ($Ia - $Ib) / ($Xa - $Xb) * ($Xx - $Xb) + $Ib;
		$indeks = floor($indeks);
		return $indeks;
	}

	static function kategori($nilai){
		$kelas;
		if ($nilai >= 300)
			$kelas = "Berbahaya";
		elseif ($nilai >= 200)
			$kelas = "Sangat Tidak Sehat";
		elseif ($nilai >= 101)
			$kelas = "Tidak Sehat";
		elseif ($nilai >= 51)
			$kelas = "Sedang";
		else
			$kelas = "Baik";
		return $kelas;
	}

	static function store($kode,$Ico, $Idebu, $Ino2, $Kco, $Kdebu, $Kno2)
	{
		DB::table('ispus')->insert([
			'kode' => $kode,
			'Ico' => $Ico,
			'Idebu' => $Idebu,
			'Ino2' => $Ino2,
			'Kco' => $Kco,
			'Kdebu' => $Kdebu,
			'Kno2' => $Kno2
		]);
	}
}
