<?php

namespace App\Http\Controllers\ApiForUser\Yangon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Usage Models
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

// Database Models
use App\User;
use App\User\ApplicationForm;
use App\User\ApplicationFile;
use App\Admin\FormProcessAction;
use App\Admin\AdminAction;

class ResidentialPowerController extends Controller
{
    public function __construct()
    {
        $this->apply_division = 1; // yangon
        $this->apply_type = 2; // residential power
    }

    // step1 : choose meter type
    public function meter_type(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        if($request->form_id != null || $request->form_id != ''){
            $form = ApplicationForm::find($request->form_id);
        }else{
            $form = new ApplicationForm();
        }

        $form->user_id = $user->id;
        $form->apply_division = $this->apply_division;
        $form->apply_type = $this->apply_type;
        $form->apply_sub_type = $request->type;
        $form->date = date('Y-m-d');
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }
}
