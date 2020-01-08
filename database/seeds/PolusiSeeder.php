<?php

use Illuminate\Database\Seeder;

class PolusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('polusis')->insert([
        	'kode' => "JGJSLM03",
            'suhu' => 40,
            'kelembaban' => 40,
            'co' => 40,
            'debu' => 40
        ]);
    }
}
