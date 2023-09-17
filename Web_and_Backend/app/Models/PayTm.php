<?php

/**
 * ApiCredential Model
 *
 * @package     NewTaxi
 * @subpackage  Model
 * @category    ApiCredential
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayTm extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paytm_payments';

    public $timestamps = false;
}
