<?php

use Illuminate\Database\Seeder;

class StasiunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stasiuns')->insert([
        	'kode' => "JGJSLM02",
        	'nama' => "UTY",
        	'alamat' => "Jl. Padjajaran, Manggung, Caturtunggal, Depok, Sleman",
        	'latitude' => -3.265251,
        	'longitude' => 114.588582,
        ]);
    }
}
