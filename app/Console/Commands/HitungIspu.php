<?php

namespace App\Console\Commands;
// namespace App\Http\Controller;

use Illuminate\Console\Command;
use App\Http\Controllers\IspuController;
use DB;

class HitungIspu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hitung:ispu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $ispu = new IspuController();
        $ispu->jalan();
    }
}
