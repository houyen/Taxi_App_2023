<?php
/**
 * Language Model
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

class Language extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language';

    public $timestamps = false;

    /**
     * Scope to get Active records Only
     *
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
