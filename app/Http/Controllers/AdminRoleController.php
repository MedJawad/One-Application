<?php

namespace App\Http\Controllers;

use App\Centrale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class AdminRoleController extends Controller
{
    /**
     * Create centrale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCentrale(Request $request)
    {
        $user = Auth::user();
        if(!isset($user) || strcasecmp($user->role,"admin")!=0) return response()->json(['error'=>'Unauthorised'], 401);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'nom' =>'required',
            'type'=> Rule::in(['Barrage','Eolien','Cycle Combine','Interconnexion','Solaire','Thermique a charbon','Turbine a gaz']),
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $centraleUser = User::create($input);
        $response = array();

//        $response['username'] =  $centraleUser->username;
//        $response['role'] =  $centraleUser->role;

        $centrale = new Centrale;
        $centrale->nom=request('nom');
        $centrale->adresse=request('adresse');
        $centrale->description=request('description');
        $centrale->type=request('type');
        $centrale->subtype=request('subtype');

        $centrale->user()->associate($centraleUser);
        $centrale->save();

        $response["centrale"]= $centrale;

        return response()->json($response);

    }
}
