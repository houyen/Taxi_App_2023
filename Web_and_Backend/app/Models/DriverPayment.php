<?php

/**
 * Payment Model
 *
 * @package     NewTaxi
 * @subpackage  Model
 * @category    Driver Payment
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
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
