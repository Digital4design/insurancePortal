<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'page_slug', 'content', 'status',
    ];
}
