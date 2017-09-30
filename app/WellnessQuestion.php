<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WellnessQuestion extends Model
{

    protected $guarded = [];

    public function record(){

        return $this->belongsTo(WellnessRecord::class);

    }

}
