<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseClassModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_license_class';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'license_class', 'description',
    ];
    public function countryHasLicense()
    {
        return $this->belongsTo('App\Models\CountryModel', 'country_id', 'id');
    }

}
