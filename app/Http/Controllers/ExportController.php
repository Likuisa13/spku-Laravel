<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\IspuExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;


class ExportController extends Controller
{
     public function export() 
     {
         return Excel::download(new IspuExport, 'ispu.xlsx');
    }
	
}
