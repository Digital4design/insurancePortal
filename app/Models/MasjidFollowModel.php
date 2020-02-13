<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasjidFollowModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'following';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'masjid_id', 'user_id',
    ];
    public function masjid()
    {
        return $this->belongsToMany('App\User', 'following', 'user_id', 'masjid_id');
        //return $this->belongsToMany('App\User','App\Models\MasjidFollowModel');
    }
}
