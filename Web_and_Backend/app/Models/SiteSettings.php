<?php

/**
 * Site Settings Model
 *
 * @package     SGTaxi
 * @subpackage  Model
 * @category    Site Settings


 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_settings';

    public $timestamps = false;
}
