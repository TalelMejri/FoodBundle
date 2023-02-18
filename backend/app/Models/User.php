<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\auth\notifications;
use App\Notifications\changer_email as NotificationsChanger_email;
use App\Notifications\notifications as NotificationsNotifications;
use App\Notifications\Notifications\changer_email;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //public $timestamps=false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];
    /*
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'numero_tlf',
        'Photo',
        'Isadmin'
    ];
    */

    public function sendEmailVerify()
    {
        $this->notify(new NotificationsNotifications());
    }

    public function sendEmailChangerEmail()
    {
        $this->notify(new NotificationsChanger_email());
    }

    public function Favorites(){
        return $this->hasMany(favorite::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }


    public function rates(){
        return $this->hasMany(Rate::class);
    }

    public function commandes(){
        return $this->hasMany(Commande::class);
     }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
