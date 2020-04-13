<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeedModel extends Model
{
    protected $table = 'speeding';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'speeding_start', 'speeding_end','rating', 'speedType',
    ];
}
