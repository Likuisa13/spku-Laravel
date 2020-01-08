<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class IspuExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	// $ispus = ["No","Lokasi","Waktu","Ispu CO","Kategori CO","Ispu NO2","Kategori NO2","Ispu PM10","Kategori PM10"];
    	$ispus = DB::table('stasiuns')
        ->join('ispus','stasiuns.kode','=','ispus.kode')
        ->select('ispus.id', 'stasiuns.nama', 'waktu', 'Ico', 'Kco', 'Ino2', 'Kno2', 'Idebu', 'Kdebu')
        ->get();
        return $ispus;
    }

    public function headings(): array
    {
        return [
            'No',
            'Lokasi',
            'Waktu',
            'Ispu CO',
            'Kategori CO',
            'Ispu NO2',
            'Kategori NO2',
            'Ispu PM10',
            'Kategori PM10'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                //$cell = 'A2:I10000';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setName('Tahoma')->setBold(true);
                //$event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(11)->setName('Tahoma');
            },
        ];
    }
}
