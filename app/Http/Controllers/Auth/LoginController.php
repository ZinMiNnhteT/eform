<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Validation\Rule;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    // use RedirectsUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    /*
    Check the user is active or not
    */
    // protected function credentials(Request $request) {
    //     $data = $request->only($this->username(), 'password');
    //     return array_add($data, 'active', 1); /* 1 means active and 0 means banned */
    // }

    /**
    * Show Admin Login Form
    * @return view
    */
    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'moee']);
    }

    /* Admin Login function */
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    // public function username() {
    //     $type = request()->input('email');
    //     $this->username = filter_var($type, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     request()->merge([$this->username => $type]);
    //     return property_exists($this, 'username') ? $this->username : 'email';
    // }

    public function login(Request $request){
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'delete_status' => false, 'active' => 1])) {
            return $this->sendLoginResponse($request);
        }else{
            $user = User::where('email', $request->email)->where('delete_status', true)->first();
            if (isset($user) && Hash::check($request->password, $user->password)) {
                $this->incrementLoginAttempts($request);
                return redirect()
                ->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors(['email' => 'Your account had been deleted!']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
