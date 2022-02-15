<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Notifiable;

    protected $fillable = [
        'name', 'bio', 'photo',
    ];

    protected $hidden = [
        'password',
    ];

    public function journeys()
    {
        return $this->hasMany('App\Journey')->orderBy('tanggal_gabung', 'desc');
    }
}
