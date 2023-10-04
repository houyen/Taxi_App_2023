<?php

/**
 * ApiCredential Model

 * @subpackage  Model
 * @category    ApiCredential

 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    public $timestamps = false;
}
