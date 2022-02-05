<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{

    protected $table = 'journeys';

    protected $fillable = ['user_id', 'tim', 'struktur', 'divisi', 'tanggal_gabung'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
