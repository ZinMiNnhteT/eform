<?php

namespace App\Http\Controllers\ApiForUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    // validator error 400
    // unauthorized 401
    // success 200
    
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            // 'password' => 'required|string|min:6',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }

        $input = $request->only('email', 'password');
        $jwt_token = null;

        $user = User::where('email', $request->email)->first();
        if(Hash::check(request('password'), $user->password)){  
            try{
                if (!$jwt_token = JWTAuth::attempt($input)) {
                    return response()->json([
                        'success' => false,
                        'title' => 'Login Invalid!',
                        'message' => 'Invalid Email or Password',
                    ], 401);
                }
            }catch(JWTException  $e){
                return response()->json([
                    'success' => false,
                    'title' => 'Login Failed!',
                    'message' => 'can not login to server. try again'
                ], 500);
            }
            $user = JWTAuth::authenticate($jwt_token);
            return response()->json([
                'success' => true,
                'token' => $jwt_token,
                'user' => $user
            ]);
        }else{
            return response()->json([
                'success' => false,
                'title' => 'Login Invalid!',
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        // hello
    }

    public function register(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:6', 'confirmed'],
        //     'captcha' => ['required', 'captcha']
        // ], ['captcha.captcha' => 'Invalid Code']);

        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();

        $user->sendEmailVerificationNotification();

        // $user = User::first();
        $token = JWTAuth::fromUser($user);
 
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function profile(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }

    public function checkToken(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
 
        $user = JWTAuth::authenticate($request->token);

        if(isset($user)){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
 
    }

    public function refresh(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $token = $request->token;
        try{
            $new_token = JWTAuth::refresh($token);
            return response()->json(['success' => true,'token'=>$new_token]);
        }catch(TokenInvalidException $e){
            return response()->json(['success' => false,'message'=> 'error in getting new token']);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
            ]
        );
    }

    protected function guard(){
        return Auth::guard();
    }
}
