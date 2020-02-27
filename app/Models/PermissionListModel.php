<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionListModel extends Model
{
    protected $table = 'permission_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_id', 'tracker_id', 'permission_id',
    ];
}
