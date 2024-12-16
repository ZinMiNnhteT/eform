<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDeleteKeySend;
use Session;
use Illuminate\Support\Facades\Hash;

class DeletionController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('auth.accountDeletion.index', compact('user'));
    }

    public function accountDeletionRequest(){
        // generate delete key
        $key = str_random(32);
        $user = Auth::user();
        DB::table('users')->where('id', $user->id)->update(['delete_key' => $key]);

        // Mail::to($user->email)->send(new UserDeleteKeySend($key));

        return redirect()->route('acc_del_form');
    }

    public function accountDeletionForm(Request $request){
        $user = Auth::user();
        $key_error = Session::get('key_error');
        $psw_error = Session::get('psw_error');
        return view('auth.accountDeletion.delete_form', compact('user', 'key_error', 'psw_error'));
    }

    public function accountDeletionDone(Request $request){
        $key = $request->key;
        $user = Auth::user();

        // if($user->delete_key != $key){
        //     return redirect()->route('acc_del_form')->with(['key_error' => 'Confimation key is invalid']);
        // }else
        
        if(!Hash::check($request->password, $user->password)){
            return redirect()->route('acc_del_form')->with(['psw_error' => 'Password is invalid']);
        }

        // delete account
        $user = Auth::user();
        DB::table('users')->where('id', $user->id)->update(['delete_status' => 1]);

        // logout from this device
        // Auth::logout();

        $noti = 'Your account is successfully deleted';

        return view('auth.accountDeletion.delete_success', compact('noti'));
    }
}
