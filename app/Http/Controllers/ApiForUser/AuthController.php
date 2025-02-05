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
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use VerifiesEmails;

    // validator error 400
    // unauthorized 401
    // success 200

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('signed')->only('verify');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            // 'password' => 'required|string|min:6',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }

        $input = $request->only('email', 'password');
        $jwt_token = null;
        
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'delete_status' => 0, 'active' => 1])) {
            $user = User::where('email', $request->email)->where('delete_status', true)->first();
            if (isset($user) && Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success'   => false,
                    'title'     => 'Login Invalid!',
                    'message'   => 'Your account had been deleted! Login with other account',
                ], 401);
            }else{
                $user = User::where('email', $request->email)->where('active', 0)->first();
                if (isset($user) && Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'title' => 'Login Invalid!',
                        'message' => 'Your account had been blocked for some reason!',
                    ], 401);
                }
            }
        }

        $user_data = User::where('email', $request->email)->where('active', 1)->where('delete_status', 0)->first();
        if(isset($user_data)){
            if(Hash::check($request->password, $user_data->password)){  
                if($user_data->email_verified_at != null){
                    try{
                        if (!$jwt_token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password, 'active'=>1, 'delete_status' => 0])) {
                            return response()->json([
                                'success' => false,
                                'title' => 'Login Invalid!',
                                'message' => 'Invalid Email/Phone or Password',
                            ], 401);
                        }
                    }catch(JWTException  $e){
                        return response()->json([
                            'success' => false,
                            'title' => 'Login Failed!',
                            'message' => 'Currently, you can not login to server.'
                        ], 500);
                    }
        
                    $login_user = JWTAuth::user();
                    
                    $user = User::find($login_user->id);
                    $user->fcm_key = $request->fcm_key;
                    $user->save();
                    
                    $expired_time = date('Y-m-d H:i:s', strtotime(' + 2 hours'));
                    
                    
                    return response()->json([
                        'success'   => true,
                        'token'     => $jwt_token,
                        'user'      => $login_user,
                        'expired_time'      => $expired_time
                    ]);
                }else{
                    return response()->json([
                        'success'   => false,
                        'title'     => 'Verify Your Email!',
                        'message'   => 'သင့်အီးမေးလ်မှန်ကန်ကြောင်းအတည်မပြုရသေးပါ။ သင့်အီးမေးလ် ('.$request->email.') တွင် MOEP Support Team မှပေးပို့ထားသည့် mail ကို အတည်ပြုပေးရန်လိုအပ်သည်။ Mail မတွေ့ရှိပါက Resend Verify နှိပ်ပါ။',
                    ], 401);
                }
            }else{
                return response()->json([
                    'success'       => false,
                    'title'         => 'Login Invalid!',
                    'message'       => 'Invalid Email or Password',
                ], 401);
            }
        } else{
            $user_data = User::where('phone', $request->email)->first();

            if(isset($user_data)){
                if(Hash::check($request->password, $user_data->password)){  
                    if($user_data->email_verified_at != null){
                        try{
                            $input_request = [
                                'email' => $user_data->email,
                                'password' => $request->password
                            ];
                            if (!$jwt_token = JWTAuth::attempt($input_request)) {
                                return response()->json([
                                    'success' => false,
                                    'title' => 'Login Invalid! password'.$request->email,
                                    'message' => 'Invalid Email/Phone or Password',
                                ], 401);
                            }
                        }catch(JWTException  $e){
                            return response()->json([
                                'success' => false,
                                'title' => 'Login Failed!',
                                'message' => 'Currently, you can not login to server.'
                            ], 500);
                        }
            
                        $login_user = JWTAuth::user();
                        
                        
                        return response()->json([
                            'success'   => true,
                            'token'     => $jwt_token,
                            'user'      => $login_user
                        ]);
                    }else{
                        return response()->json([
                            'success'   => false,
                            'title'     => 'Verify Your Email!',
                            'message'   => 'သင့်အီးမေးလ်မှန်ကန်ကြောင်းအတည်မပြုရသေးပါ။ သင့်အီးမေးလ် ('.$request->email.') တွင် MOEP Support Team မှပေးပို့ထားသည့် mail ကို အတည်ပြုပေးရန်လိုအပ်သည်။ Mail မတွေ့ရှိပါက Resend Verify နှိပ်ပါ။',
                        ], 401);
                    }
                }else{
                    return response()->json([
                        'success'       => false,
                        'title'         => 'Login Invalid!',
                        'message'       => 'Invalid Email or Password',
                    ], 401);
                }
            } else{
                $user_data = User::where('phone', $request->email)->first();
    
                return response()->json([
                    'success'       => false,
                    'title'         => 'Login Invalid!',
                    'message'       => 'Invalid Email or Password',
                ], 401);
            }
        }
    }

    public function register_old(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'string', 'min:9', 'max:11', 'unique:users'],
            'password'  => ['required', 'string', 'min:6']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'title'     => 'Validate Error',
                'errors'    => $validator->errors(),
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();

        $user->sendEmailVerificationNotification();

        // $user = User::first();
        // $token = JWTAuth::fromUser($user);
 
        return response()->json([
            'success' => true,
            'title' => 'အီးမေးလ်အတည်ပြုပေးပါ။',
            'message' => 'အကောင့်ပြုလုပ်ပြီးပါပြီ။ အကောင့်ဝင်နိုင်ရန် သင့်အီးမေးလ် ('.$request->email.') တွင် MOEP Support Team မှပေးပို့ထားသည့် mail ကို အတည်ပြုပေးရန်လိုအပ်သည်။ Mail မတွေ့ရှိပါက Resend Verify နှိပ်ပါ။',
            // 'token' => $token,
        ]);
    }

    public function verify(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => ['required', 'string', 'email'],
            'password'  => ['required', 'string', 'min:6']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if(isset($user)){
            if(Hash::check($request->password, $user->password)){  
                if($user->email_verified_at == null){

                        $user->sendEmailVerificationNotification();
                        // event(new Verified($user));
                        return response()->json([
                            'success' => true,
                            'title' => 'Verify Send Success!',
                            'message' => 'အီးမေးလ်မှန်ကန်ကြောင်း အတည်ပြုပေးရန် လင့်ကို  သင့်အီးမေးလ် ('.$request->email.')သို့ပေးပို့ပြီးဖြစ်ပါသည်။',
                        ]);
                    
                }else{
                    return response()->json([
                        'success' => true,
                        'title' => 'Verify Send Fail!',
                        'message' => 'အီးမေးလ်မှန်ကန်ကြောင်း အတည်ပြုပေးပြီးဖြစ်ပါသည်။ Verify Send လုပ်ရန်မလိုအပ်တော့ပါ။',
                    ]);
                }
            }
        }
        return response()->json([
            'success' => true,
            'title' => 'Verify Send Fail',
            'message' => 'အကောင့်မတွေ့ရှိပါ',
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
            $new_token = $this->refresh_token($request->token);
            return response()->json(['success' => true, 'token' => $new_token]);
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

    public function refresh_token($token){
        return $token;
        try{
            $new_token = JWTAuth::refresh($token);
            return $new_token;
        }catch(TokenInvalidException $e){
            return $token;
        }
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
    */
    public function reset_psw(Request $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        $user  = User::where('email', $request->email)->first();
        if(isset($user)){
            $psw_reset = DB::table('password_resets')->where('email', $request->email)->first();

            $url = $psw_reset->token;
            new ResetPasswordNotification($url);
            return response()->json([
                'success'    => true,
                'title'     => 'လင့်ခ်ပို့ပေးပြီးပါပြီ',
                'message'   => 'သင့်အီးမေးလ် ('. $request->email.') သို့ စကားဝှက်ပြောင်းလဲရန်လင့်ခ်ကို ပေးပို့ပေးပြီးဖြစ်ပါသည်။',
            ]);
        }else{
            return response()->json([
                'success'    => true,
                'title'     => 'အကောင့်မတွေ့ရှိပါ',
                'message'   => ''. $request->email.') ဖြင့် အကောင့်ဖွင့်ထားခြင်းမရှိပါ။',
            ]);
        }
        
    }
    
    
    public function register(Request $request){

        $email = $request->email;
        $phone = $request->phone;

        // check deleted user
        $deletedUserByEmail = DB::table('users')->where('email', $email)->where('delete_status', 1)->first();
        $deletedUserByPhone = DB::table('users')->where('phone', $phone)->where('delete_status', 1)->first();
        $activeUserByEmail = DB::table('users')->where('email', $email)->where('delete_status', 0)->first();
        $activeUserByPhone = DB::table('users')->where('phone', $phone)->where('delete_status', 0)->first();

        if(isset($deletedUserByEmail) && !isset($activeUserByEmail)){
            $validator = $this->validatorForDeletedUserByEmail($request->all());
        }elseif(isset($deletedUserByPhone) && !isset($activeUserByPhone)){
            $validator = $this->validatorForDeletedUserByPhone($request->all());
        }else{
            $validator = $this->validator($request->all());
        }
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'title'     => 'Validate Error',
                'errors'    => $validator->errors(),
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();

        $user->sendEmailVerificationNotification();

        // $user = User::first();
        // $token = JWTAuth::fromUser($user);
 
        return response()->json([
            'success'   => true,
            'title'     => 'အီးမေးလ်အတည်ပြုပေးပါ။',
            'message'   => 'အကောင့်ပြုလုပ်ပြီးပါပြီ။ အကောင့်ဝင်နိုင်ရန် သင့်အီးမေးလ် ('.$request->email.') တွင် MOEP Support Team မှပေးပို့ထားသည့် mail ကို အတည်ပြုပေးရန်လိုအပ်သည်။ Mail မတွေ့ရှိပါက Resend Verify နှိပ်ပါ။',
            // 'token' => $token,
        ]);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'         => ['required', 'string', 'max:11', 'min:7', 'unique:users'],
            'password'      => ['required', 'string', 'min:6'],
        ]);
    }
    protected function validatorForDeletedUserByEmail(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'phone'         => ['required', 'string', 'max:11', 'min:7', 'unique:users'],
            'password'      => ['required', 'string', 'min:6']
        ]);
    }
    protected function validatorForDeletedUserByPhone(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'         => ['required', 'string', 'max:11', 'min:7'],
            'password'      => ['required', 'string', 'min:6'],
        ]);
    }
    
    public function checkLogin(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
 
        $user = JWTAuth::authenticate($request->token);

        if(isset($user)){
            $new_token = $this->refresh_token($request->token);
            return response()->json(['success' => true, 'token' => $new_token]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
