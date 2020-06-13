<?php

namespace App\Http\Controllers;

use App\Barrage;
use App\BarrageInfos;
use App\Prevision;
use App\Production;
use App\SolaireInfos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                    $infos->production_totale_brut = $data["production_totale_brut"]  ;
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
}
