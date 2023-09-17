<?php

/**
 * Cancel Model
 *
 * @package     NewTaxi
 * @subpackage  Model
 * @category    Cancel
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cancel';

    protected $fillable = ['user_id','trip_id','cancel_reason_id','cancel_comments','cancelled_by'];

    /**
     * Join With Trip Table
     *
     */
    public function trip()
    {
    	return $this->hasOne('App\Models\Trips','id','trip_id');
    }

    /**
     * Join With Cancel Reson Table
     *
     */
    public function cancel_reason()
    {
        return $this->hasOne('App\Models\CancelReason','id','cancel_reason_id');
    }
   
}
