<?php

/**
 * Join Us Model
 *
 * @package     NewTaxi
 * @subpackage  Model
 * @category    Join Us
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinUs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'join_us';

    public $timestamps = false;
}
