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


class ProductionExportsSheet implements FromView, WithEvents, ShouldAutoSize
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
                $event->sheet->mergeCells("B34:J34");
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
        return view('excel', ['headers' => $headers,'comb'=>$turbines, 'barrages' => $barrageData, 'turbines' => $turbineData, 'eoliens' => $eolienData, 'thermiques' => $thermiqueData, 'cycles' => $ccData, "solaires" => $solaireData, 'inters' => $interData]);
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
