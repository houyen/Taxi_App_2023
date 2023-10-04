<?php

/**
 * Cancel Model

 * @subpackage  Model
 * @category    Cancel
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCancel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'schedule_cancel';

    protected $fillable = ['id','schedule_ride_id','cancel_reason','cancel_by','cancel_reason_id'];

    /**
     * Join with cancel reasons attribute
     *  
     */
    public function cancel_reasons()
    {
    	return $this->hasOne('App\Models\CancelReason','id','cancel_reason_id');
    }
}