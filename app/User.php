<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

/*******************
*
* CRETAE PASSPORT
*
**********************/
//Cliente 1 =  AthR9nAfBCh5U6hyj7PKIIwvf7VPPg1Bsl1RtPGS
//Cliente 2 =   LHK4cWrqs1oatJUweAmHDMC7fIE3vl85CkdTDRX4

// Client ID: 1
// Client secret: fGT1l2OVZ8IAP9v6ADIgYWiPX0FwXZduRkF0gXop

// USE WHEN LOGIN FAIL:
// php artisan passport:client --personal
}
