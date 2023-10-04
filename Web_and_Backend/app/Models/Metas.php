<?php

/**
 * Metas Model

 * @subpackage  Model
 * @category    Metas

 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'metas';

    public $timestamps = false;
}
