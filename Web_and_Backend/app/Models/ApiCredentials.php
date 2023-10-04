<?php

/**
 * ApiCredential Model
 * @subpackage  Model
 * @category    ApiCredential
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCredentials extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_credentials';

    public $timestamps = false;
}
