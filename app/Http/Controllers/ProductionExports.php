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
        $turbineData = $this->formatData($turbines);
        $barrageData = $this->formatData($barrages);
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
            $info24 = $t->infos->where('date', '=', $yesterday)->where("horaire", "=", "24")->first();
            if (isset($info24)) {

                $combustibles[$t->nom]['stock'] = 0;
                $combustibles[$t->nom]['livraison_fioul'] = $info24->livraison_fioul;
                $combustibles[$t->nom]['consommation_fioul'] = $info24->consommation_fioul;
                $combustibles[$t->nom]['transfert_fioul'] = $info24->transfert_fioul;

                if (strcmp($t->subtype, "+gazoil") === 0) {
                    $combustibles[$t->nom]['production_gazoil'] = $info24->production_gazoil;
                    $combustibles[$t->nom]['livraison_gazoil'] = $info24->livraison_gazoil;
                    $combustibles[$t->nom]['consommation_gazoil'] = $info24->consommation_gazoil;
                    $combustibles[$t->nom]['transfert_gazoil'] = $info24->transfert_gazoil;
                }
                if (strcmp($t->subtype, "+charbon") === 0) {
                    $combustibles[$t->nom]['livraison_charbon'] = $info24->livraison_charbon;
                    $combustibles[$t->nom]['consommation_charbon'] = $info24->consommation_charbon;
                    $combustibles[$t->nom]['transfert_charbon'] = $info24->transfert_charbon;
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
            $info24 = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "24")->first();
            $info14 = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "14")->first();
            $info11 = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "11")->first();
            $info7 = $b->infos->where('date', '=', $yesterday)->where("horaire", "=", "7")->first();
            if (!isset($info24)) continue;
            switch ($b->subtype) {
                case "normal" :
                {
                    $barInfos[$b->nom]['cote']['24H'] = $info24->cote;
                    $barInfos[$b->nom]['cote']['14H'] = $info14->cote;
                    $barInfos[$b->nom]['cote']['11H'] = $info11->cote;
                    $barInfos[$b->nom]['cote']['7H'] = $info7->cote;
                    $barInfos[$b->nom]['turbine'] = $info24->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info24->irrigation;
                    $barInfos[$b->nom]['lache'] = $info24->lache;
                    break;
                }
                case "+cote":
                {
                    $barInfos[$b->nom]['cote']['24H'] = $info24->cote;
                    $barInfos[$b->nom]['cote']['14H'] = $info14->cote;
                    $barInfos[$b->nom]['cote']['11H'] = $info11->cote;
                    $barInfos[$b->nom]['cote']['7H'] = $info7->cote;
                    $barInfos[$b->nom]['cote2']['24H'] = $info24->cote2;
                    $barInfos[$b->nom]['cote2']['14H'] = $info14->cote2;
                    $barInfos[$b->nom]['cote2']['11H'] = $info11->cote2;
                    $barInfos[$b->nom]['cote2']['7H'] = $info7->cote2;
                    $barInfos[$b->nom]['turbine'] = $info24->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info24->irrigation;
                    $barInfos[$b->nom]['lache'] = $info24->lache;
                    break;
                }
                case "-cote":
                {
                    $barInfos[$b->nom]['turbine'] = $info24->turbine;
                    $barInfos[$b->nom]['irrigation'] = $info24->irrigation;
                    $barInfos[$b->nom]['lache'] = $info24->lache;
                    break;
                }
                case "onlyVolumePompe":
                {
                    $barInfos[$b->nom]['volume_pompe'] = $info24->volume_pompe;
                    break;
                }
                case "onlyProductionCote":
                {
                    $barInfos[$b->nom]['cote']['24H'] = $info24->cote;
                    $barInfos[$b->nom]['cote']['14H'] = $info14->cote;
                    $barInfos[$b->nom]['cote']['11H'] = $info11->cote;
                    $barInfos[$b->nom]['cote']['7H'] = $info7->cote;
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
        $solaireInfos = array();
        foreach ($solaires as $s) {
            $solaireInfos[$s->nom] = array();
            $today = date('Y-m-d', strtotime("0 days"));
            $info = $s->infos->where('date', '=', $today)->where("type", "=", "previsions")->first();
            if (!isset($info)) continue;
            foreach ($info->previsions as $prevision){
                $solaireInfos[$s->nom]['previsions'][$prevision->horaire] = $prevision->value;
            }
        }
        $eoliensInfos = array();
        foreach ($eoliens as $e) {
            $eoliensInfos[$e->nom] = array();
            $today = date('Y-m-d', strtotime("0 days"));
            $info = $e->infos->where('date', '=', $today)->where("type", "=", "previsions")->first();
            if (!isset($info)) continue;
            foreach ($info->previsions as $prevision){
                $eoliensInfos[$e->nom]['previsions'][$prevision->horaire] = $prevision->value;
            }
        }

        return view('excel', [
            'headers' => $headers,
            'combustibles' => $combustibles, 'barragesInfos' => $barInfos,"eoliensInfos"=>$eoliensInfos, 'thermiqueInfos' => $thermiqueInfos,"solairesInfos" =>$solaireInfos,
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
