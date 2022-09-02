<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use App\Mail\sendToUser;
use App\Notifications\VerifyApiEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
// class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    /**
     * customize the email template
     */
    // public function sendEmailVerificationNotification()
    // {
    //     $mail_detail = [
    //         'email' => 'htetaung@thenexthop.net',
    //         'name' => 'Customer',
    //         'mail_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<div class="text-center mt-5 mb-5"><a href="#" class="btn btn-info text-center">Click for payment</a></div>'
    //     ];
    //     Mail::to($mail_detail['email'])->send(new sendToUser($mail_detail['name'], $mail_detail['mail_body']));
    //     // $this->notify(new App\Notifications\CustomEmailNotification);
    // }

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

  
}
