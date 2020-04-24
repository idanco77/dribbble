<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Eloquent;

/**
 * User
 *
 * @mixin Eloquent
 */

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable, SpatialTrait;

    protected $fillable = [
        'name', 'email', 'password', 'location',
        'tagline', 'about', 'username', 'formatted_address', 'available_to_hire'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $spatialFields = [
        'location'
    ];

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
