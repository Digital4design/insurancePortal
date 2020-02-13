<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionPolicyHolderModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission_policy_holder';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permissions_name',
    ];
}
