<?php
namespace App\Http\Controllers\API;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return JsonResponse
     */
    public function login(){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['role'] =  $user->role;

            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $user = Auth::user();
        if(!isset($user) || strcasecmp($user->role,"admin")!=0) return response()->json(['error'=>'Unauthorised'], 401);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'role'=> Rule::in(['user','pch','admin']),
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['username'] =  $user->username;
        $success['role'] =  $user->role;
        return response()->json(['success'=>$success], $this-> successStatus);
    }
    /**
     * details api
     *
     * @return JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['username'=>$user->username,'role'=>$user->role], $this-> successStatus);
    }
}
