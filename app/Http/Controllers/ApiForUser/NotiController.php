<?php

namespace App\Http\Controllers\ApiForUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Usage Models
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Database Models
use App\User;
use App\User\ApplicationForm;
use App\User\ApplicationFile;
use App\Admin\FormProcessAction;
use App\Admin\AdminAction;
use App\Admin\ApplicationFormContractor;
use App\Setting\InitialCost;
use App\Setting\District;
use App\Setting\Township;


class NotiController extends Controller
{
    public function getNotis(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=> false, 
                'title'     => 'Validate Error',
                'validate'  => $validator->errors(),
                'errors'    => $validator->errors(),
                'message'   => $validator->errors(),
            ], 400);
        }
        
        $start = $request->start != null ? $request->start : 0;
        $limit = 10;

        $user = JWTAuth::authenticate($request->token);
        $notis = DB::table('flutter_notis')
        ->join('application_forms',function($join){
            $join->on('application_forms.id','=','flutter_notis.form_id');
        })
        ->select('flutter_notis.*', 'application_forms.serial_code as serial_code', 'application_forms.apply_type as apply_type', 'application_forms.apply_division as apply_division')
        ->where('flutter_notis.user_id', $user->id)
        ->orderBy('flutter_notis.id','desc')
        ->offset($start)->limit($limit)
        ->get();
        
        $total = DB::table('flutter_notis')
        ->join('application_forms',function($join){
            $join->on('application_forms.id','=','flutter_notis.form_id');
        })
        ->select('flutter_notis.*', 'application_forms.serial_code as serial_code', 'application_forms.apply_type as apply_type', 'application_forms.apply_division as apply_division')
        ->where('flutter_notis.user_id', $user->id)
        ->orderBy('flutter_notis.id','desc')
        ->get();

        $unread =  DB::table('flutter_notis')
        ->join('application_forms',function($join){
            $join->on('application_forms.id','=','flutter_notis.form_id');
        })
        ->select('flutter_notis.*', 'application_forms.serial_code as serial_code', 'application_forms.apply_type as apply_type', 'application_forms.apply_division as apply_division')
        ->where('flutter_notis.user_id', $user->id)
        ->where('read_status', 0)->get();

        $result = [];
        foreach($notis as $noti){
            $noti->form_id = (int) $noti->form_id;
            $noti->user_id = (int) $noti->user_id;
            $noti->read_status = (int) $noti->read_status;
            $noti->id = (int) $noti->id;
            $noti->send_date = date('d-m-Y h:i:s A', strtotime($noti->send_date));
            $noti->remark = $noti->remark != null ? $noti->remark : '';
            $noti->img = $noti->img != null ? $noti->img : '';
            $noti->apply_type = (string)$noti->apply_type;
            $noti->apply_division = (string)$noti->apply_division;
            array_push($result, $noti);
        }

        return response()->json([
            'success'       => true,
            'notis'         => $result,
            'start'         => (int)$start,
            'count'         => count($notis),
            'total_count'   => count($total),
            'limit'         => (int)$limit,
            'total_unread' => count($unread),
        ]);
    }
    
    public function readNoti(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=> false, 
                'title'     => 'Validate Error',
                'validate'  => $validator->errors(),
                'errors'    => $validator->errors(),
                'message'   => $validator->errors(),
            ], 400);
        }

        $user = JWTAuth::authenticate($request->token);
        $noti = DB::table('flutter_notis')->where('id', $request->id)->update(['read_status'=> 1]);
        return response()->json([
            'success'   => true
        ]);
    }
}