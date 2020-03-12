<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssestModel extends Model
{
    protected $table = 'assets';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'assets_id',
        'tracker_id',
        'label',
        'max_speed',
        'model',
        'type',
        'subtype',
        'garage_id',
        'status_id',
        'trailer',
        'manufacture_year',
        'color',
        'additional_info',
        'reg_number',
        'vin',
        'frame_number',
        'payload_weight',
        'payload_height',
        'payload_length',
        'payload_width',
        'passengers',
        'gross_weight',
        'fuel_type',
        'fuel_grade',
        'norm_avg_fuel_consumption',
        'fuel_tank_volume',
        'fuel_cost',
        'wheel_arrangement',
        'tyre_size',
        'tyres_number',
        'liability_insurance_policy_number',
        'liability_insurance_valid_till',
        'free_insurance_policy_number',
        'free_insurance_valid_till',
    ];
}
