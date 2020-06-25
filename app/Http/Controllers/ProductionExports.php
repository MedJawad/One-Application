<?php


namespace App\Http\Controllers;


use App\Centrale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;


class ProductionExports implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
//                $event->writer->setCreator('Oneep');
            },
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
//                $event->sheet->mergeCells("B34:J34");
//                $event->sheet->setCellValue()
            },
        ];
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
            array_push($headers, $c->nom . ' Recu');
            array_push($headers, $c->nom . ' Fourni');
            array_push($headers, $c->nom . ' R-F');
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

        //Situation Combustible
        $combustibles = array();
        foreach ($turbines as $t) {
            $combustibles[$t->nom] = array();
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $info = $t->infos->where('date', '=', $yesterday)->where("horaire", "=", "24")->first();
            if (isset($info)) {

                $combustibles[$t->nom]['stock'] = 0;
                $combustibles[$t->nom]['livraison_fioul'] = $info->livraison_fioul;
                $combustibles[$t->nom]['consommation_fioul'] = $info->consommation_fioul;
                $combustibles[$t->nom]['transfert_fioul'] = $info->transfert_fioul;

                if (strcmp($t->subtype, "+gazoil") === 0) {
                    $combustibles[$t->nom]['production_gazoil'] = $info->production_gazoil;
                    $combustibles[$t->nom]['livraison_gazoil'] = $info->livraison_gazoil;
                    $combustibles[$t->nom]['consommation_gazoil'] = $info->consommation_gazoil;
                    $combustibles[$t->nom]['transfert_gazoil'] = $info->transfert_gazoil;
                }
                if (strcmp($t->subtype, "+charbon") === 0) {
                    $combustibles[$t->nom]['livraison_charbon'] = $info->livraison_charbon;
                    $combustibles[$t->nom]['consommation_charbon'] = $info->consommation_charbon;
                    $combustibles[$t->nom]['transfert_charbon'] = $info->transfert_charbon;
                }
            } else {
                $combustibles[$t->nom]['livraison_fioul'] = 0;
                $combustibles[$t->nom]['consommation_fioul'] = 0;
                $combustibles[$t->nom]['transfert_fioul'] = 0;

                if (strcmp($t->subtype, "+gazoil") === 0) {
                    $combustibles[$t->nom]['production_gazoil'] = 0;
                    $combustibles[$t->nom]['livraison_gazoil'] = 0;
                    $combustibles[$t->nom]['consommation_gazoil'] = 0;
                    $combustibles[$t->nom]['transfert_gazoil'] = 0;
                }
                if (strcmp($t->subtype, "+charbon") === 0) {
                    $combustibles[$t->nom]['livraison_charbon'] = 0;
                    $combustibles[$t->nom]['consommation_charbon'] = 0;
                    $combustibles[$t->nom]['transfert_charbon'] = 0;
                }
            }
        }
        $barInfos = array();
        foreach ($barrages as $b) {
            $barInfos[$b->nom] = array();
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $info = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "24")->first();
            if (!isset($info)) continue;
            switch ($b->subtype) {
                case "normal" :
                {
                    $barInfos[$b->nom]['cote'] = $info->cote;
                    $barInfos[$b->nom]['turbine'] = $info->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info->irrigation;
                    $barInfos[$b->nom]['lache'] = $info->lache;
                    break;
                }
                case "+cote":
                {
                    $barInfos[$b->nom]['cote'] = $info->cote;
                    $barInfos[$b->nom]['cote2'] = $info->cote2;
                    $barInfos[$b->nom]['turbine'] = $info->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info->irrigation;
                    $barInfos[$b->nom]['lache'] = $info->lache;
                    break;
                }
                case "-cote":
                {
                    $barInfos[$b->nom]['turbine'] = $info->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info->irrigation;
                    $barInfos[$b->nom]['lache'] = $info->lache;
                    break;
                }
                case "onlyVolumePompe":
                {
                    $barInfos[$b->nom]['volume_pompe'] = $info->volume_pompe;
                    break;
                }
                case "onlyProductionCote":
                {
                    $barInfos[$b->nom]['cote'] = $info->cote;
                    break;
                }
            }

        }
        $thermiqueInfos = array();
        foreach ($thermiques as $b) {
            $thermiqueInfos[$b->nom] = array();
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $oldInfo = $b->infos->where('date', '<', $yesterday)->where("horaire", "=", "24")->last();
            $info = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "24")->first();
            if (!isset($info)) continue;
            switch ($b->subtype) {
                case "normal" :
                    $thermiqueInfos[$b->nom]['autonomie_charbon'] = $info->autonomie_charbon;
                case "-autonomie":
                {
                    $thermiqueInfos[$b->nom]['index'] = $info->index;
                    if (isset($oldInfo)) {
                        $thermiqueInfos[$b->nom]['oldIndex'] = $oldInfo->index;

                    } else {
                        $thermiqueInfos[$b->nom]['oldIndex'] = 0;

                    }
                    break;
                }
            }
        }
        return view('excel', [
            'headers' => $headers,
            'combustibles' => $combustibles, 'barragesInfos' => $barInfos, 'thermiqueInfos' => $thermiqueInfos,
            'barragesProd' => $barrageData, 'turbinesProd' => $turbineData, 'eoliensProd' => $eolienData, 'thermiquesProd' => $thermiqueData, 'cyclesProd' => $ccData, "solairesProd" => $solaireData, 'intersProd' => $interData
//            'barrages' => $barrageData, 'turbines' => $turbineData, 'eoliens' => $eolienData, 'thermiques' => $thermiqueData, 'cycles' => $ccData, "solaires" => $solaireData, 'inters' => $interData
        ]);
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
}
