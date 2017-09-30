<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user
 */
class WellnessRecord extends Model
{
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\User');

    }

    public function questions(){

        return $this->hasMany('App\WellnessQuestion', 'user_records');

    }

}
