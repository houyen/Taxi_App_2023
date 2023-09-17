<?php
/**
 * Language Model
 *
 * @package     NewTaxi
 * @subpackage  Model
 * @category    TollReason
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
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