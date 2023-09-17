<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportDriver extends Model {

    /**
    * The database table used by the model.
    *
    * @var string
    */
     protected $table = 'supports';

     protected $fillable = ['name','status','cancelled_by','owner'];

    public $timestamps = false;

    public function getImageSrcAttribute() {
        return url('images/support/'.$this->attributes['image']);
    }

    public function scopeActive($query) {
        return $query->whereStatus('Active')->where('owner', 'Driver')->orWhere('owner', 'All');
    }    
}