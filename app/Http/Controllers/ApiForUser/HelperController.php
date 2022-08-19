<?php

namespace App\Http\Controllers\ApiForUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Usage Models
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

// Database Model
use App\Setting\District;
use App\Setting\Township;

class HelperController extends Controller
{
    // get Townships by Division
    public function township_dropdown(Request $request){
        $validator = Validator::make($request->all(),[
            'token'         => 'required',
            'division_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $division_id = $request->division_id;

        $townships = Township::select('townships.*', 'districts.name as district_name','division_states.name as division_states_name')
        ->leftJoin('districts', function($join){
            $join->on('townships.district_id','=','districts.id');
        })->leftJoin('division_states', function($join){
            $join->on('townships.division_state_id','=','division_states.id');
        });
        if($division_id != 2 && $division_id != 3){ // other division
            $townships = $townships->where('townships.division_state_id', '!=', 2)->where('townships.division_state_id', '!=', 3);
        }else{ // 2 is yangon, 3 is mandalay
            $townships = $townships->where('townships.division_state_id', $division_id);
        }
        $townships = $townships->get();

        return response()->json([
            'success'       => true,
            'count'         => count($townships),
            'townships'     => $townships,
        ]);
    }
}
