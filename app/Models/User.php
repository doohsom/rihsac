<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;


use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject, Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'uuid',
        'firstname',
        'lastname',
        'email',
        'password',
        'phone_number',
        'username',
        'state_id',
        'cashir_id',
        'email_verified',
        'phone_number_verified',
        'role',
        'transaction_pin',
        'avatar',
        'onboarding_stage',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'transaction_pin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function scopeEnabled($query)
    {
        return $query->where('status', 'enabled');
    }

    public function scopePerson($query, $id){
        return $query->where('id', $id);
    }

    public function guarantor()
    {
        return $this->hasOne(GuarantorInformation::class);
    }
}
