<?php

/**
 * Payment Model
 *
 * @package     SGTaxi
 * @subpackage  Model
 * @category    Driver Payment


 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverPayment extends Model
{
	use CurrencyConversion;

	public $convert_fields = ['paid_amount'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'driver_payment';

    protected $guarded = [];

    public $timestamps = false;
}
