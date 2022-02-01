<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{

    protected $table = 'recruits';

    protected $guarded = ['user_id', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
