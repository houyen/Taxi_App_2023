<?php
/**
 * Language Model

 * @subpackage  Model
 * @category    TollReason

 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripTollReason extends Model
{
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trip_id','reason'];
    
}