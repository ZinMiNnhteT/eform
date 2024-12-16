<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    /* Show Admin Register Form */
    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'moee']);
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
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'captcha'       => ['required', 'captcha']
        ], ['captcha.captcha' => 'Invalid Code']);
    }
    protected function validatorForDeletedUserByEmail(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'phone'         => ['required', 'string', 'max:11', 'min:7', 'unique:users'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'captcha'       => ['required', 'captcha']
        ], ['captcha.captcha' => 'Invalid Code']);
    }
    protected function validatorForDeletedUserByPhone(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'         => ['required', 'string', 'max:11', 'min:7'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'captcha'       => ['required', 'captcha']
        ], ['captcha.captcha' => 'Invalid Code']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
        ]);
    }

    /**
     * Overwrite
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $email = $request->email;
        $phone = $request->phone;

        // check deleted user
        $deletedUserByEmail = DB::table('users')->where('email', $email)->where('delete_status', 1)->first();
        $deletedUserByPhone = DB::table('users')->where('phone', $phone)->where('delete_status', 1)->first();
        $activeUserByEmail = DB::table('users')->where('email', $email)->where('delete_status', 0)->first();
        $activeUserByPhone = DB::table('users')->where('phone', $phone)->where('delete_status', 0)->first();

        if(isset($deletedUserByEmail) && !isset($activeUserByEmail)){
            $this->validatorForDeletedUserByEmail($request->all())->validate();
        }elseif(isset($deletedUserByPhone) && !isset($activeUserByPhone)){
            $this->validatorForDeletedUserByPhone($request->all())->validate();
        }else{
            $this->validator($request->all())->validate();
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /* create admin function */
    protected function createAdmin(Request $request)
    {
        $this->validatorAdmin($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/admin');
    }
    protected function validatorAdmin(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'captcha'       => ['required', 'captcha']
        ], ['captcha.captcha' => 'Invalid Code']);
    }
}
