<?php

namespace App\Http\Controllers;

use App\BarrageInfos;
use App\Centrale;
use App\EolienInfos;
use App\Prevision;
use App\Production;
use App\SolaireInfos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use phpDocumentor\Reflection\Types\Array_;

class UserRoleController extends Controller
{
    public $successStatus = 200;

    public function newProductions()
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "user") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        $response = array();
        $centrale = $user->centrale;

        $response['centrale']['id'] = $centrale->id;
        $response['centrale']['nom'] = $centrale->nom;
        $response['centrale']['type'] = $centrale->type;
        $response['centrale']['subtype'] = $centrale->subtype;
        if (strcasecmp($centrale->type, "Barrage") == 0) {
            $horaires = ['7', '11', '14', '24'];
        } else {
            $horaires = ['7', '13', '21', '24'];
        }
        $centraleInfos = $centrale->infos->whereNotNull('horaire');
        if (is_object($centraleInfos->last())) {
            $lastCentraleInfos = $centraleInfos->last();
            $horaire = '';
            $lastCentraleInfosDate = explode(" ", $lastCentraleInfos->date)[0];
            $newCentraleInfosDate = $lastCentraleInfosDate;
            $nextCentraleInfosDate = "$lastCentraleInfosDate $lastCentraleInfos->horaire:00:00";

            switch ($lastCentraleInfos->horaire) {
                case '7':
                    $nextCentraleInfosDate = "$newCentraleInfosDate $horaires[1]:00:00";
                    if (date('Y-m-d H:i:s') > $nextCentraleInfosDate) $horaire = $horaires[1];
                    break;
                case $horaires[1]:
                    $nextCentraleInfosDate = "$newCentraleInfosDate $horaires[2]:00:00";
                    if (date('Y-m-d H:i:s') > $nextCentraleInfosDate) $horaire = $horaires[2];
                    break;
                case $horaires[2]:
                    $nextCentraleInfosDate = "$newCentraleInfosDate 24:00:00";
                    Log::debug(date('Y-m-d H:i:s'));
                    Log::debug($nextCentraleInfosDate);
                    if (date('Y-m-d H:i:s') > $nextCentraleInfosDate) $horaire = '24';
                    break;
                case '24':
                    $newCentraleInfosDate = date("Y-m-d", strtotime("+1 day", strtotime($lastCentraleInfosDate)));
                    $nextCentraleInfosDate = "$newCentraleInfosDate 07:00:00";
                    Log::debug(date('Y-m-d H:i:s'));
                    Log::debug($nextCentraleInfosDate);
                    if (date('Y-m-d H:i:s') > $nextCentraleInfosDate) $horaire = '7';
                    break;
                default:

                    $horaire = '7';
                    break;
            }

        } else {
            $newCentraleInfosDate = date('Y-m-d');
            $horaire = '7';
        }
        if (empty($horaire)) return response()->json($response, 230);
        $response['centrale']['horaire'] = $horaire;
        $response['centrale']['date'] = $newCentraleInfosDate;


        return response()->json($response, $this->successStatus);
    }

    public function newPrevisions()
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "user") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        $response = array();
        $centrale = $user->centrale;
        $centraleInfos = $centrale->infos->where('type', '=', 'previsions');
        if (is_object($centraleInfos->last())) {
            $lastPrevisions = $centraleInfos->last();
            $lastPrevisionsDate = $lastPrevisions->date;
            if (date('Y-m-d') < $lastPrevisionsDate) return response()->json($response, 230);
            $newPrevisionsDate = date("Y-m-d", strtotime("+1 day", strtotime($lastPrevisionsDate)));
        } else {
            $newPrevisionsDate = date("Y-m-d", strtotime("+1 day"));
        }
        $response['previsionsDate'] = $newPrevisionsDate;

        return response()->json($response, $this->successStatus);
    }


    /**
     * Create centrale
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function saveInfos(Request $request)
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
                    $infos->date = $data["date"];
                    $infos->cote = $data["cote"];
                    $infos->cote2 = $data["cote2"];
                    $infos->turbine = $data["turbine"];
                    $infos->irrigation = $data["irrigation"];
                    $infos->lache = $data["lache"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->centrale()->associate($user->centrale->id);
                    $infos->save();

                    foreach ($data['productions'] as $key => $value) {
                        $prod = new Production;
                        $prod->horaire = $key;
                        $prod->value = $value;
                        $prod->productionable()->associate($infos);
                        $prod->save();
                    }
                    break;
                }
                case "Eolien":
                    $infos = new EolienInfos();
                case "Solaire":
                    if (!isset($infos)) $infos = new SolaireInfos();
                    $infos->type = $data["infosType"]; //Previsions or Productions
                    $infos->centrale()->associate($user->centrale->id);
                    $infos->save();
                    if (strcasecmp($infos->type, "productions") == 0) {
                        $infos->horaire = $data["horaire"];
                        $infos->date = $data["date"];
                        $infos->production_totale_brut = $data["production_totale_brut"];
                        $infos->production_totale_net = $data["production_totale_net"];
                        foreach ($data['productions'] as $key => $value) {
                            $prod = new Production;
                            $prod->horaire = $key;
                            $prod->value = $value;
                            $prod->productionable()->associate($infos);
                            $prod->save();
                        }
                        $infos->save();
                    }
                    if (strcasecmp($infos->type, "previsions") == 0) {
                        $infos->date = date("Y-m-d", strtotime("+1 day", time()));
                        foreach ($data['previsions'] as $key => $value) {
                            $prev = new Prevision;
                            $prev->horaire = $key;
                            $prev->value = $value;
                            $prev->previsionable()->associate($infos);
                            $prev->save();
                        }
                        $infos->save();
                    }
                    break;

            }
            DB::commit();

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
