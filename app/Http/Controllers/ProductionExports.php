<?php


namespace App\Http\Controllers;


use App\Centrale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;


class ProductionExports implements FromView,WithEvents,ShouldAutoSize
{

    /**
     * @inheritDoc
     */
    public function view(): View
    {
        $data = array();
//        $centrales = Centrale::orderBy('type')->get();
        $centrales = Centrale::orderByRaw('FIELD(type, "Turbine a gaz", "Barrage", "Eolien","Thermique a charbon","Cycle Combine","Solaire")')->get();
        $headers = array(); //'<th>#</th>';
//        $type = "";
        foreach ($centrales as $key => $centrale) {
//            if(strcmp($type,$centrale->type)!=0 ) array_push($headers, 'Total');
//            $type= $centrale->type;
            array_push($headers, $centrale->nom);
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
            $data[$centrale->nom] = array();
            foreach ($infos as $index => $info) {
                foreach ($info->productions as $indexProd => $prod) {
                    $data[$centrale->nom][$index][$prod->horaire] = $prod->value;
                }
                if (strcasecmp($info->horaire, "24")==0) {
                    $data[$centrale->nom][$index+1]['brut'] = $info->production_totale_brut;
                    $data[$centrale->nom][$index+2]['net'] = $info->production_totale_net;
                }
            }
            $data[$centrale->nom] = array_merge(...$data[$centrale->nom]);
        }
//return $data;
        $contents = array(); //'';
        for ($i = 1; $i <= 24; $i++) {
            $rowContent = array(); //'';

            foreach ($data as $centraleNom => $value) {
                if (isset($value[$i . "H"])) {
                    $prod = $value[$i . "H"];
                    array_push($rowContent, $prod);
                }
                else {
                    array_push($rowContent, 0);
                }
            }
            $contents[$i."H"] = $rowContent;
        }
        $brutProds = array();
        $netProds = array();
        foreach ($data as $centaleNom => $value){
            if (isset($value["brut"])&&isset($value["net"])) {
                $brut = $value["brut"];
                $net = $value["net"];
                array_push($brutProds, $brut);
                array_push($netProds, $net);
            }
            else {
                array_push($brutProds, 0);
                array_push($netProds, 0);
            }
        }
//            array_push($contents, $rowContent);
        $contents['brut']=$brutProds;
        $contents['net']=$netProds;
        return view('excelTemplate', ['headers' => $headers, 'contents' => $contents]);

    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        //Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
        //    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        //});
//        $styleArray = [
//            'font' => [
//                'bold' => true,
//            ],
//            'alignment' => [
//                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
//            ],
//            'borders' => [
//                'allBorders' => [
//                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                ],
//
//            ],
//            'fill' => [
//                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
//                'rotation' => 90,
//                'startColor' => [
//                    'argb' => 'FFA0A0A0',
//                ],
//                'endColor' => [
//                    'argb' => 'FFFFFFFF',
//                ],
//            ],
//        ];

//        $to = $event->sheet->getDelegate()->getHighestColumn();
//        $event->sheet->getDelegate()->getStyle('A1:'.$to.'1')->applyFromArray($styleArray);
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('ONEEP');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
//                $event->sheet->styleCells(
//                    'A1:G1',
//                    [
//                        'borders' => [
//                            'outline' => [
//                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                                'color' => ['argb' => 'FFFF0000'],
//                            ],
//                        ]
//                    ]
//                );
//                $generalStyle = [
//                    'font' => [
//                        'bold' => true,
//                    ],
//                    'alignment' => [
//                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
//                    ],
//                    'borders' => [
//                        'allBorders' => [
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                        ],
////
//                    ],
//                        'rgb' => 'FF0000',
//
//                    'fill' => [
//                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                        'rotation' => 90,
//                        'startColor' => [
//                            'argb' => 'FF40E0D0',
//                        ],
//                        'endColor' => [
//                            'argb' => 'FFFFFFFF',
//                        ],
//                    ],
//                ];
//                $to = $event->sheet->getDelegate()->getHighestColumn();
//                $event->sheet->getDelegate()->getStyle('A1:'.$to.'25')->applyFromArray($generalStyle);
            },
        ];
    }
}
