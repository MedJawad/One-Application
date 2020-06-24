<?php

namespace App\Http\Controllers;

use App\BarrageInfos;
use App\Centrale;
use App\CycleCombineInfos;
use App\EchangeEnergie;
use App\EolienInfos;
use App\InterconnexionInfos;
use App\Prevision;
use App\Production;
use App\SolaireInfos;
use App\TACInfos;
use App\TAGInfos;
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
    public function checkPermission()
    {
        $user = Auth::user();
        if (isset($user) || strcasecmp($user->role, "user") == 0) return $user;
        return false;
    }
    public function newProductions()
    {
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);

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
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);

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
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);
        DB::beginTransaction();
        try {
            $data = $request->json()->all();
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
                    $infos->volume_pompe = $data["volume_pompe"];
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
                case "Thermique a charbon":
                {
                    $infos = new TACInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->date = $data["date"];
                    $infos->autonomie_charbon = $data["autonomie_charbon"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->index = $data["index"];
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
                case "Cycle Combine":
                {
                    $infos = new CycleCombineInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->date = $data["date"];
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
                case "Turbine a gaz":
                {
                    $infos = new TAGInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->date = $data["date"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->production_gazoil = $data["production_gazoil"];

                    $infos->livraison_charbon = $data["livraison_charbon"];
                    $infos->consommation_charbon = $data["consommation_charbon"];
                    $infos->transfert_charbon = $data["transfert_charbon"];

                    $infos->livraison_fioul = $data["livraison_fioul"];
                    $infos->consommation_fioul = $data["consommation_fioul"];
                    $infos->transfert_fioul = $data["transfert_fioul"];

                    $infos->livraison_gazoil = $data["livraison_gazoil"];
                    $infos->consommation_gazoil = $data["consommation_gazoil"];
                    $infos->transfert_gazoil = $data["transfert_gazoil"];

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
                case "Interconnexion":
                {
                    $infos = new InterconnexionInfos();
                    $infos->horaire = $data["horaire"];
                    $infos->date = $data["date"];
                    $infos->production_totale_recu = $data["production_totale_recu"];
                    $infos->production_totale_fourni = $data["production_totale_fourni"];
                    $infos->centrale()->associate($user->centrale->id);
                    $infos->save();

                    foreach ($data['productions'] as $key => $values) {
                        $prod = new EchangeEnergie;
                        $prod->horaire = $key;
                        $prod->recu = $values["recu"];
                        $prod->fourni = $values["fourni"];
                        $prod->infos()->associate($infos);
                        $prod->save();
                    }
                    break;
                }


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

    public function lastDayReports()
    {
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);

        $response = array();
        $centrale = $user->centrale;
        $yesterday = date('Y-m-d', strtotime("-1 days"));
//        $centraleInfos = $centrale->infos->where('date', '>=', $yesterday);
    Log::debug($centrale->type);
        if(strcasecmp($centrale->type,"Eolien")==0 || strcmp($centrale->type,"Solaire")==0){
            $centraleInfos = $centrale->infos->where('date', '>=', $yesterday)->where('type','=','productions');
        }else{
            $centraleInfos = $centrale->infos->where('date', '>=', $yesterday);
        }
        Log::debug($centraleInfos);

        $response['reports'] = $centraleInfos;

        return response()->json($response, $this->successStatus);
    }

    /**
     *
     * @param int $report_id
     * @return JsonResponse
     */
    public function getReportById($report_id)
    {
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);

        $response = array();
        $centrale = $user->centrale;
        $response['centrale']['id'] = $centrale->id;
        $response['centrale']['nom'] = $centrale->nom;
        $response['centrale']['type'] = $centrale->type;
        $response['centrale']['subtype'] = $centrale->subtype;

        $centraleInfos = $centrale->infos->where('id', '=', $report_id)->first();
//        Log::debug($centraleInfos);
        $response['centrale']['horaire'] = $centraleInfos->horaire;
        $response['centrale']['date'] = $centraleInfos->date;


        return response()->json($response, $this->successStatus);
    }

    /**
     *
     * @param Request $request
     * @param int $report_id
     * @return JsonResponse
     */
    public function updateReportById(Request $request, $report_id)
    {
        if (!($user = $this->checkPermission())) return response()->json(['error' => 'Unauthorised'], 401);

        DB::beginTransaction();
        try {
            $data = $request->json()->all();
            $centrale = $user->centrale;
            $infos = $centrale->infos->where('id', '=', $report_id)->first();
            switch ($user->centrale->type) {
                case "Barrage":
                {
                    $infos->cote = $data["cote"];
                    $infos->cote2 = $data["cote2"];
                    $infos->turbine = $data["turbine"];
                    $infos->irrigation = $data["irrigation"];
                    $infos->lache = $data["lache"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->volume_pompe = $data["volume_pompe"];
                    $infos->save();
                    foreach ($data['productions'] as $key => $value) {
                        $prod = $infos->productions->where('horaire', $key)->first();
                        $prod->value = $value;
                        $prod->save();
                    }
                    break;
                }
                case "Eolien":
                case "Solaire":
                $infos->type = $data["infosType"]; //Previsions or Productions
                    if (strcasecmp($infos->type, "productions") == 0) {
                        $infos->production_totale_brut = $data["production_totale_brut"];
                        $infos->production_totale_net = $data["production_totale_net"];
                        foreach ($data['productions'] as $key => $value) {
                            $prod = $infos->productions->where('horaire', $key)->first();
                            $prod->value = $value;
                            $prod->save();
                        }
                        $infos->save();
                    }
                    elseif (strcasecmp($infos->type, "previsions") == 0) {
                        foreach ($data['previsions'] as $key => $value) {
                            $prev = $infos->previsions->where('horaire', $key)->first();
                            $prev->value = $value;
                            $prev->save();
                        }
                        $infos->save();
                    }
                    else{
                        return response()->json(['error' => 'Unauthorised'], 401);
                    }
                    break;
                case "Thermique a charbon":
                {
                    $infos->autonomie_charbon = $data["autonomie_charbon"];
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->index = $data["index"];
                    $infos->save();

                    foreach ($data['productions'] as $key => $value) {
                        $prod = $infos->productions->where('horaire', $key)->first();
                        $prod->value = $value;
                        $prod->save();
                    }
                    break;
                }
                case "Cycle Combine":
                {
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->save();
                    foreach ($data['productions'] as $key => $value) {
                        $prod = $infos->productions->where('horaire', $key)->first();
                        $prod->value = $value;
                        $prod->save();
                    }
                    break;
                }
                case "Turbine a gaz":
                {
                    $infos->production_totale_brut = $data["production_totale_brut"];
                    $infos->production_totale_net = $data["production_totale_net"];
                    $infos->production_gazoil = $data["production_gazoil"];

                    $infos->livraison_charbon = $data["livraison_charbon"];
                    $infos->consommation_charbon = $data["consommation_charbon"];
                    $infos->transfert_charbon = $data["transfert_charbon"];

                    $infos->livraison_fioul = $data["livraison_fioul"];
                    $infos->consommation_fioul = $data["consommation_fioul"];
                    $infos->transfert_fioul = $data["transfert_fioul"];

                    $infos->livraison_gazoil = $data["livraison_gazoil"];
                    $infos->consommation_gazoil = $data["consommation_gazoil"];
                    $infos->transfert_gazoil = $data["transfert_gazoil"];
                    $infos->save();

                    foreach ($data['productions'] as $key => $value) {
                        $prod = $infos->productions->where('horaire', $key)->first();
                        $prod->value = $value;
                        $prod->save();
                    }
                    break;
                }
                case "Interconnexion":
                {
                    $infos->production_totale_recu = $data["production_totale_recu"];
                    $infos->production_totale_fourni = $data["production_totale_fourni"];
                    $infos->save();

                    foreach ($data['productions'] as $key => $values) {
                        $prod = $infos->echanges->where('horaire', $key)->first();
                        $prod->recu = $values["recu"];
                        $prod->fourni = $values["fourni"];
                        $prod->save();
                    }
                    break;
                }
            }
            DB::commit();
            $response = array();

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
