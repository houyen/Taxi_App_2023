<?php

/**
 * Documents Translation Model
 * @subpackage  Controller
 * @category    Documents Translation
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class DocumentsTranslations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents_langs';

    public $timestamps = false;

    protected $fillable = ['name'];

    public function language()
    {
        return $this->belongsTo('App\Models\Language','locale','value');
    }
}
