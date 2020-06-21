<?php

namespace App\Http\Controllers;

use App\Barrage;
use App\BarrageInfos;
use App\Centrale;
use App\Prevision;
use App\Production;
use App\SolaireInfos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //

    public function index()
    {
        DB::beginTransaction();
        try {

            $user = Auth::user();
            if (!isset($user) || strcasecmp($user->role, "user") != 0) return response()->json(['error' => 'Unauthorised'], 401);

            $data = $request->json()->all();
            Log::debug($data);
//        $validator = Validator::make($request->all(), [
//            'nom' =>'required',
//            'type'=> Rule::in(['Barrage','Eolien','Cycle Combine','Interconnexion','SolaireInfos','Thermique a charbon','Turbine a gaz']),
//        ]);

            switch ($user->centrale->type) {
                case "Barrage":
                {
                    $infos = new BarrageInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->cote = $data["cote"];
                    $infos->turbine = $data["turbine"];
                    $infos->irrigation = $data["irrigation"];
                    $infos->lache = $data["lache"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->centrale()->associate($user->centrale->id);
                    $infos->save();

                    foreach ($data['production'] as $key => $value) {
                        $prod = new Production;
                        $prod->horaire = $key;
                        $prod->value = $value;
                        $prod->centraleInfos()->associate($infos->id);
                        $prod->save();
                    }
                    break;
                }
                case "Eolien":
                case "SolaireInfos":
                {
                    $infos = new SolaireInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->centrale()->associate($user->centrale->id);
                    $infos->save();

                    foreach ($data['production'] as $key => $value) {
                        $prod = new Production;
                        $prod->horaire = $key;
                        $prod->value = $value;
                        $prod->centraleInfos()->associate($infos->id);
                        $prod->save();
                    }
                    foreach ($data['prevision'] as $key => $value) {
                        $prev = new Prevision;
                        $prev->horaire = $key;
                        $prev->value = $value;
                        $prev->centraleInfos()->associate($infos->id);
                        $prev->save();
                    }
                    break;
                }
            }
            DB::commit();
            $response['horaire'] = $data['horaire'];
            $response['infos'] = $infos;
            return response()->json($response);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function generateReport()
    {
        $res = array();
        $headers = '<th>#</th>';
        $content = '';
        $centrales = Centrale::orderBy('type')->get();
        $infos = null;
        foreach ($centrales as $centrale) {
            $headers .= "<th>$centrale->nom</th>";
//            $content .="<td>$centrale->type</td>";
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $centrale->infos->where('date', '=', $yesterday);
//            $res['infos'] = $infos;
        }
        for ($i = 1; $i <= 24; $i++) {
            $rowContent = '';
            Log::debug("prod 114 :    " . $infos);
            foreach ($infos as $info) {
                $prod = $info->productions()->where('horaire', '=', $i . "H")->first();
                Log::debug("prod 117 :    " . $prod);
                Log::debug("prod 118 :    " . $i);
                if (isset($prod)) {
                    $rowContent .= "<td>$prod->value</td>";
                } else {
                    $rowContent .= "<td>0</td>";
                }

            }
            //PROBLEM IS I ONLY GET THE PRODUCTIONS Of The Last CentraleInfos inserted
            $content .= "<tr><th>$i</th>$rowContent</tr>";
        }
        $htmlString = "<table>
                  <tr>
                      $headers
                  </tr>
                  <tr>
                      $content
                  </tr>
              </table>";
        return response($htmlString);//->json($res,200);
    }


    public function genReport2()
    {
        $data = array();
        $centrales = Centrale::orderBy('type')->get();
        $headers = array(); //'<th>#</th>';
        foreach ($centrales as $key => $centrale) {
//            $headers.="<th>$centrale->nom</th>";
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
//                    $rowContent .= "<td>$prod</td>";
                    array_push($rowContent, $prod);
//                    $rowContent[$i."H"] = $prod;
                }
                else {
//                    $rowContent .= "<td>0</td>";
                    array_push($rowContent, 0);
//                    $rowContent[$i."H"] = 0;

                }

            }
//            $content .= "<tr><th>$i</th>$rowContent</tr>";
//            array_push($contents, $rowContent);
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
//            $htmlString = "
//                <table>
//                  <tr>
//                      $headers
//                  </tr>
//                  <tr>
//                      $contents
//                  </tr>
//              </table>";
//        return response($htmlString);//->json($res,200);
//        return $contents;
        return view('welcome', ['headers' => $headers, 'contents' => $contents]);
//        return $contents;

    }

    public function genReport3()
    {
        return Excel::download(new ProductionExports,'productions.xlsx');
    }

}
