<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelModel extends Model
{
    protected $table = 'fuels';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fuels_type', 'fuels_description',
    ];
}
