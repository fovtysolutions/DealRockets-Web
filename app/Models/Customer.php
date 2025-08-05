<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'f_name', 'l_name', 'phone', 'email', 'password', 'image',
        'street_address', 'country', 'city', 'zip', 'house_no', 'apartment_no',
        'is_active', 'login_medium', 'social_id', 'is_phone_verified', 
        'is_email_verified', 'wallet_balance', 'loyalty_point', 'referral_code'
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
        'id' => 'integer',
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'is_phone_verified' => 'boolean',
        'is_email_verified' => 'boolean',
        'wallet_balance' => 'float',
        'loyalty_point' => 'float',
        'is_temp_blocked' => 'boolean',
        'temp_block_time' => 'datetime',
    ];
}
