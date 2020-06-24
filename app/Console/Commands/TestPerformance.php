<?php

namespace App\Console\Commands;

use App\Centrale;
use App\Http\Controllers\ProductionExports;
use Illuminate\Console\Command;

class TestPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:exec';

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
        //place this before any script you want to calculate time
        $time_start1 = microtime(true);
//            $barrage = Centrale::whereType("Barrage");
//            $eoliens = Centrale::whereType("Eolien");
//            $solaires =Centrale::whereType("Solaire");
//            $thermiques = Centrale::whereType("Thermique a charbon");
//            $cycleCombines = Centrale::whereType("Cycle Combine");
//            $turbines = Centrale::whereType("Turbine a gaz");
//            $inters = Centrale::whereType("Interconnexion");
//        (new ProductionExports)->view();
       $data = (new ProductionExports)->test2();
//        dd($data);
        $time_end1 = microtime(true);

//dividing with 60 will give the execution time in minutes otherwise seconds
        $execution_time1 = ($time_end1 - $time_start1);


        $time_start2 = microtime(true);
//        $barrages = array();
//        $eolien = array();
//        $solaire = array();
//        $thermique = array();
//        $cycleCombine = array();
//        $turbine = array();
//        $inter = array();
//
//        foreach ($centrales as $key => $centrale) {
//            switch ($centrale->type) {
//                case "Barrage":
//                {
//                    array_push($barrages, $centrale);
//                    break;
//                }
//                case "Eolien":
//                    array_push($eolien, $centrale);
//                    break;
//                case "Solaire":
//                    array_push($solaire, $centrale);
//                    break;
//                case "Thermique a charbon":
//                {
//                    array_push($thermique, $centrale);
//                    break;
//                }
//                case "Cycle Combine":
//                {
//                    array_push($cycleCombine, $centrale);
//                    break;
//                }
//                case "Turbine a gaz":
//                {
//                    array_push($turbine, $centrale);
//                    break;
//                }
//                case "Interconnexion":
//                {
//                    array_push($inter, $centrale);
//                    break;
//                }
//            }
//        }

        $time_end2 = microtime(true);
//
        $execution_time2 = ($time_end2 - $time_start2);

//execution time of the script
        $this->info('Total Execution Time 1: ' . $execution_time1 . ' sec');
        $this->info('Total Execution Time 2: ' . $execution_time2 . ' sec');
// if you get weird results, use number_format((float) $execution_time, 10)
    }
}
