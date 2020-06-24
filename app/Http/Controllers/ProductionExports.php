<?php


namespace App\Http\Controllers;


use App\Centrale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;


class ProductionExports implements FromView, WithEvents, ShouldAutoSize
{

    /**
     * @inheritDoc
     */
    public function test2()
    {
        $data = array();
        $centrales = Centrale::where("type", '<>', "Interconnexion")->orderByRaw('FIELD(type, "Turbine a gaz", "Barrage", "Eolien","Thermique a charbon","Cycle Combine","Solaire","Interconnexion")')->get();
        $headers = array(); //'<th>#</th>';
//        $type = null;

        foreach ($centrales as $key => $centrale) {
//            if(isset($type) && strcmp($type,$centrale->type)!=0 ) array_push($headers, 'Total');
//            $type= $centrale->type;
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $data[$centrale->nom] = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $data[$centrale->nom][$index][$prod->horaire] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $data[$centrale->nom][$index + 1]['brut'] = $info->production_totale_brut;
                    $data[$centrale->nom][$index + 2]['net'] = $info->production_totale_net;
                }
            }
            $data[$centrale->nom] = array_merge(...$data[$centrale->nom]);
        }
        $contents = array(); //'';
        for ($i = 1; $i <= 24; $i++) {
            $rowContent = array(); //'';

            foreach ($data as $centraleNom => $value) {
                if (isset($value[$i . "H"])) {
                    $prod = $value[$i . "H"];
                    array_push($rowContent, $prod);
                } else {
                    array_push($rowContent, 0);
                }
            }
            $contents[$i . "H"] = $rowContent;
        }
        $brutProds = array();
        $netProds = array();
        foreach ($data as $centaleNom => $value) {
            if (isset($value["brut"]) && isset($value["net"])) {
                $brut = $value["brut"];
                $net = $value["net"];
                array_push($brutProds, $brut);
                array_push($netProds, $net);
            } else {
                array_push($brutProds, 0);
                array_push($netProds, 0);
            }
        }

        //test begin
        $inters = Centrale::whereType("Interconnexion")->get();
        foreach ($inters as $centrale) {
            array_push($headers, $centrale->nom . ' Recu');
            array_push($headers, $centrale->nom . ' Fourni');
            array_push($headers, $centrale->nom . ' R-F');
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $interData[$centrale->nom] = array();
            foreach ($infos as $index => $info) {
                foreach ($info->echanges as $indexProd => $prod) {
                    $interData[$centrale->nom][$index][$prod->horaire]["recu"] = $prod->recu;
                    $interData[$centrale->nom][$index][$prod->horaire]["fourni"] = $prod->fourni;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
//                    $interData[$centrale->nom][$index + 1]['recu'] = $info->production_totale_recu;
//                    $interData[$centrale->nom][$index + 2]['fourni'] = $info->production_totale_fourni;
                    array_push($brutProds, $info->production_totale_recu, $info->production_totale_fourni, ($info->production_totale_recu - $info->production_totale_fourni));
                }
            }
            $interData[$centrale->nom] = array_merge(...$interData[$centrale->nom]);
        }
        $contents['brut'] = $brutProds;
        $contents['net'] = $netProds;
        return view('excelTemplate', ['headers' => $headers, 'contents' => $contents, 'inters' => $interData]);
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->setCreator('Abdellah & Jawad');
            },
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }

    public function test()
    {
        $data = array();
        $headers = array();
        $turbines = Centrale::whereType("Turbine a gaz")->get();
        $barrages = Centrale::whereType("Barrage")->get();
        $eoliens = Centrale::whereType("Eolien")->get();
        $thermiques = Centrale::whereType("Thermique a charbon")->get();
        $cycleCombines = Centrale::whereType("Cycle Combine")->get();
        $solaires = Centrale::whereType("Solaire")->get();
        $inters = Centrale::whereType("Interconnexion")->get();
        $turbineData = array();
        $barrageData = array();
        $eolienData = array();
        $thermiqueData = array();
        $ccData = array();
        $solaireData = array();
        $interData = array();

        foreach ($turbines as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $turbineData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $turbineData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $turbineData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($turbineData);

//        array_push($headers, "Total");
        foreach ($barrages as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $barrageData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $barrageData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $barrageData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($barrageData);
        foreach ($eoliens as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $eolienData = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $eolienData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $eolienData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $eolienData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($eolienData);
        foreach ($thermiques as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $thermiqueData = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $thermiqueData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $thermiqueData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $thermiqueData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($thermiqueData);
        foreach ($cycleCombines as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $ccData = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $ccData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $ccData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $ccData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($ccData);
        foreach ($solaires as $centrale) {
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $solaireData = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $solaireData[$prod->horaire][$centrale->nom] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $solaireData['total'][$centrale->nom]['brut'] = $info->production_totale_brut;
                    $solaireData['total'][$centrale->nom]['net'] = $info->production_totale_net;
                }
            }
        }
//        dd($solaireData);
        foreach ($inters as $centrale) {
            array_push($headers, $centrale->nom . ' Recu');
            array_push($headers, $centrale->nom . ' Fourni');
            array_push($headers, $centrale->nom . ' R-F');
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            foreach ($infos as $index => $info) {
                foreach ($info->echanges as $indexProd => $values) {
                    $interData[$values->horaire][$centrale->nom]['recu'] = $values["recu"];
                    $interData[$values->horaire][$centrale->nom]['fourni'] = $values["fourni"];
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $interData['total'][$centrale->nom]['recu'] = $info->production_totale_recu;
                    $interData['total'][$centrale->nom]['fourni'] = $info->production_totale_fourni;
                }
            }
        }
//dd( $interData);

        $contents = array_merge_recursive($barrageData, $solaireData, $turbineData, $eolienData, $ccData, $thermiqueData, $interData);
//        dd($contents);
//        $contents = array(); //'';
//        for ($i = 1; $i <= 24; $i++) {
////            $rowContent = array(); //''; we should create a row content array for each row and make every centrale fill its own cell ( row['9H']['allafassi'] = ... ) rowContent
//
//            foreach ($contents as $hour => $value) {
//                if (isset($value[$i . "H"])) {
//                    $prod = $value[$i . "H"];
//                    array_push($rowContent, $prod);
//                }
//                else {
//                    array_push($rowContent, 0);
//                }
//            }
//            $contents[$i."H"] = $rowContent;
//        }
//        $brutProds = array();
//        $netProds = array();
//        foreach ($data as $centaleNom => $value){
//            if (isset($value["brut"])&&isset($value["net"])) {
//                $brut = $value["brut"];
//                $net = $value["net"];
//                array_push($brutProds, $brut);
//                array_push($netProds, $net);
//            }
//            else {
//                array_push($brutProds, 0);
//                array_push($netProds, 0);
//            }
//        }
//        $contents['brut']=$brutProds;
//        $contents['net']=$netProds;
//        dd(($barrageData['3H']["Lau t"]));
//      dd(  str_split("Test Recu"));

        return view('excel', ['headers' => $headers, 'barrages' => $barrageData, 'turbines' => $turbineData, "eoliens" => $eolienData, "thermiques" => $thermiqueData, "cycles" => $ccData, "solaires" => $solaireData, "inters" => $interData]);
        //'contents'=>$contents]);

    }

    public function view(): View
    {
        $data = array();
        $headers = array();
        $turbines = Centrale::whereType("Turbine a gaz")->get();
        $barrages = Centrale::whereType("Barrage")->get();
        $eoliens = Centrale::whereType("Eolien")->get();
        $thermiques = Centrale::whereType("Thermique a charbon")->get();
        $cycleCombines = Centrale::whereType("Cycle Combine")->get();
        $solaires = Centrale::whereType("Solaire")->get();
        $inters = Centrale::whereType("Interconnexion")->get();
        foreach ($turbines as $c) {
            array_push($headers, $c->nom);
        }
        array_push($headers, "Total");

        foreach ($barrages as $c) {
            array_push($headers, $c->nom);
        }
        array_push($headers, "Total");

        foreach ($eoliens as $c) {
            array_push($headers, $c->nom);
        }
        array_push($headers, "Total");

        foreach ($thermiques as $c) {
            array_push($headers, $c->nom);
        }
        foreach ($cycleCombines as $c) {
            array_push($headers, $c->nom);
        }
        foreach ($solaires as $c) {
            array_push($headers, $c->nom);
        }
        array_push($headers, "Tiers");
        foreach ($inters as $c) {
            array_push($headers, $c->nom.' Recu');
            array_push($headers, $c->nom.' Fourni');
            array_push($headers, $c->nom.' R-F');
        }
//        dd($headers);
        $barrageData = $this->formatData($barrages);
        $turbineData = $this->formatData($turbines);
        $eolienData = $this->formatData($eoliens);
        $thermiqueData = $this->formatData($thermiques);
        $ccData = $this->formatData($cycleCombines);
        $solaireData = $this->formatData($solaires);
//        $barrageData = $this->formatData($barrages);
//        $turbineData = array();

        $interData = array();
        foreach ($inters as $c) {
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $c->infos->where('date', '=', $yesterday);
            $interData[$c->nom] = array();

            foreach ($infos as $info) {
                $echanges = $info->echanges;
                foreach ($echanges as $echange) {
                    $interData[$c->nom][$echange->horaire]["recu"] = $echange->recu;
                    $interData[$c->nom][$echange->horaire]["fourni"] = $echange->fourni;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $interData[$c->nom]['total']['recu'] = $info->production_totale_recu;
                    $interData[$c->nom]['total']['fourni'] = $info->production_totale_fourni;
                }
            }
        }
        return view('excel', ['headers' => $headers, 'barrages' => $barrageData, 'turbines' => $turbineData, 'eoliens' => $eolienData, 'thermiques' => $thermiqueData, 'cycles' => $ccData, "solaires" => $solaireData, 'inters' => $interData]);
    }

    public function formatData($centrales)
    {
        $data = array();
        foreach ($centrales as $c) {
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $c->infos->where('date', '=', $yesterday);
            $data[$c->nom] = array();

            foreach ($infos as $info) {
                $productions = $info->productions;
                foreach ($productions as $prod) {
                    $data[$c->nom][$prod->horaire] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $data[$c->nom]['Brut'] = $info->production_totale_brut;
                    $data[$c->nom]['Net'] = $info->production_totale_net;
                }
            }
        }
        return $data;
    }

    public function traitement($centrales)
    {
        $data = array();
        $headers = array(); //'<th>#</th>';
//        $type = null;

        foreach ($centrales as $key => $centrale) {
//            if(isset($type) && strcmp($type,$centrale->type)!=0 ) array_push($headers, 'Total');
//            $type= $centrale->type;
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $data[$centrale->nom] = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $data[$centrale->nom][$index][$prod->horaire] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24") == 0) {
                    $data[$centrale->nom][$index + 1]['brut'] = $info->production_totale_brut;
                    $data[$centrale->nom][$index + 2]['net'] = $info->production_totale_net;
                }
            }
            $data[$centrale->nom] = array_merge(...$data[$centrale->nom]);
        }
        $contents = array(); //'';
        for ($i = 1; $i <= 24; $i++) {
            $rowContent = array(); //'';

            foreach ($data as $centraleNom => $value) {
                if (isset($value[$i . "H"])) {
                    $prod = $value[$i . "H"];
                    array_push($rowContent, $prod);
                } else {
                    array_push($rowContent, 0);
                }
            }
            $contents[$i . "H"] = $rowContent;
        }
        $brutProds = array();
        $netProds = array();
        foreach ($data as $centraleNom => $value) {
            if (isset($value["brut"]) && isset($value["net"])) {
                $brut = $value["brut"];
                $net = $value["net"];
                array_push($brutProds, $brut);
                array_push($netProds, $net);
            } else {
                array_push($brutProds, 0);
                array_push($netProds, 0);
            }
        }

        return ["data" => $data, "headers" => $headers];
    }
}
