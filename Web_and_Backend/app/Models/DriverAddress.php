<?php

/**
 * Driver Address Model
 * @subpackage  Model
 * @category    Driver Address
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverAddress extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'driver_address';

    public $timestamps = false;
}