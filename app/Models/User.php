<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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





    public function scopeDistance($query, $lat, $long, $distance) {
        return User::all()->filter(function ($profile) use ($lat, $long, $distance) {
            $latLongArr = $profile->lat_long ? explode(', ',$profile->lat_long) : [];

            $actual = 3959 * acos(
                cos(deg2rad($lat)) * cos(deg2rad($latLongArr[0]))
                * cos(deg2rad($latLongArr[1]) - deg2rad($long))
                + sin(deg2rad($lat)) * sin(deg2rad($latLongArr[0]))
            );
            return ($distance/1000) > $actual;
        });
    }


}
