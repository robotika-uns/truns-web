<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'sessions';

    protected $fillable = [
        'id', 'user_id', 'ip', 'device', 'platform', 'browser',
    ];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
