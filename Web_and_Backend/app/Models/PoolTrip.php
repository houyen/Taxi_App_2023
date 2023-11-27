<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PoolTrip extends Model {

    // Join with Pool Trip table
    public function trips() {
        return $this->hasMany('App\Models\Trips','pool_id','id');
    }
}
