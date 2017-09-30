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

        return $this->belongsTo(User::class);

    }

    public function questions(){

        return $this->hasMany(WellnessQuestion::class);

    }

}
