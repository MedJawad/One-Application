<?php

namespace App\Http\Controllers;

use App\Centrale;
use App\Http\Controllers\API\UserController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class CentraleController extends Controller
{
    /**
     * Create centrale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if(!isset($user) || strcasecmp($user->role,"admin")!=0) return response()->json(['error'=>'Unauthorised'], 401);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nom' =>'required',
            'type'=> Rule::in(['Barrage','Eolien','Cycle Combine','Interconnexion','Solaire','Thermique a charbon','Turbine a gaz']),
        ]);

        $response = array();
        $centraleUser= User::where('username',request('username'))->first();
        if(!isset($centraleUser) || strcasecmp($centraleUser->role,"user")!=0) return response()->json(['error'=>'Username is not for a Centrale account'], 401);
        $centrale = new Centrale;
        $centrale->nom=request('nom');
        $centrale->adresse=request('adresse');
        $centrale->description=request('description');
        $centrale->type=request('type');

        $centrale->user()->associate($centraleUser);
        $centrale->save();

        $response["centrale"]= $centrale;

        return response()->json($response);

    }

    public function getById($id)
    {
        $response = array();

        $centrale = Centrale::find($id);
        $response["centrale"]= $centrale;
        $response["centrale"]["infos"]=$centrale->infos();

        return response()->json($response);

    }
    public function getAll()
    {
        $response = array();

        $centrales = Centrale::all();
        $response["centrales"]= $centrales;
//        $response["centrale"]["infos"]=$centrale->infos();

        return response()->json($response);
    }

    public function getCentraleNextHoraire($id)
    {
        $response = array();

//        $infos = CentraleInfos::where('centrale_id',$id)->orderBy('created_at', 'desc')->first();
//        $infos = CentraleInfos::where('centrale_id',$id)->orderBy('id', 'desc')->first();
//        $response["centrale"]= $centrale;
//        $response["centrale"]["infos"]=$centrale->infos();

        return response()->json($response);

    }
}
