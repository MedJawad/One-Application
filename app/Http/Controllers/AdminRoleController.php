<?php

namespace App\Http\Controllers;

use App\Centrale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        if (!isset($user) || strcasecmp($user->role, "admin") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'nom' => 'required',
            'type' => Rule::in(['Barrage', 'Eolien', 'Cycle Combine', 'Interconnexion', 'Solaire', 'Thermique a charbon', 'Turbine a gaz']),
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $centraleUser = User::create($input);
        $response = array();

//        $response['username'] =  $centraleUser->username;
//        $response['role'] =  $centraleUser->role;

        $centrale = new Centrale;
        $centrale->nom = request('nom');
        $centrale->adresse = request('adresse');
        $centrale->description = request('description');
        $centrale->type = request('type');
        $centrale->subtype = request('subtype');

        $centrale->user()->associate($centraleUser);
        $centrale->save();

        $response["centrale"] = $centrale;

        return response()->json($response);

    }

    /**
     * Create centrale
     *
     * @param Request $request
     * //     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadReport(Request $request)
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "admin") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        return Excel::download(new ProductionExports, 'productions.xlsx');
    }

    /**
     * Get List of Barrages
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function centrales(Request $request)
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "admin") != 0) return response()->json(['error' => 'Unauthorised'], 401);
        $res = array();
        $type = request('type');
        if (isset($type)) {
            $res['centrales'] = Centrale::whereType(request('type'))->with('user')->get();
        } else {
            $res['centrales'] = Centrale::all();
        }

        return response()->json($res, 200);
    }

    /**
     *
     * @param int $centrale_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCentraleById($centrale_id)
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "admin") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        $res = array();
        $centrale = Centrale::find($centrale_id);
        $res['centrale']['nom'] = $centrale->nom;
        $res['centrale']['adresse'] = $centrale->adresse;
        $res['centrale']['description'] = $centrale->description;
        $res['centrale']['type'] = $centrale->type;
        $res['centrale']['subtype'] = $centrale->subtype;
        $res['centrale']['username'] = $centrale->user->username;
        return $res;
    }

    /**
     *
     * @param int $centrale_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCentraleById(Request $request,$centrale_id)
    {
        $user = Auth::user();
        if (!isset($user) || strcasecmp($user->role, "admin") != 0) return response()->json(['error' => 'Unauthorised'], 401);

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password',
            'nom' => 'required',
            'type' => Rule::in(['Barrage', 'Eolien', 'Cycle Combine', 'Solaire', 'Thermique a charbon', 'Turbine a gaz']),
            'subtype' =>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $res = array();
        $centrale = Centrale::find($centrale_id);
        $centrale->nom = request('nom');
        $centrale->adresse = request('adresse');
        $centrale->description = request('description');
        $centrale->type = request('type');
        $centrale->subtype = request('subtype');
        $centrale->user->username = request('username');
        $centrale->user->password = bcrypt(request('password'));
        $centrale->user->save();
        $centrale->save();
        $res =$centrale;
        return $res;
    }
}
