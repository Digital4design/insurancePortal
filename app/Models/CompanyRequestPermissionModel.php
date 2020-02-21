<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRequestPermissionModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_request_permission';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_detail_id', 'permission_policy_id', 'accept_status',
    ];

    public function getPermission()
    {
        return $this->hasMany('App\Models\PermissionPolicyHolderModel', 'id');
    }

}
