<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\UserRoleRelation;
use App\Models\MasjidFollowModel;
use App\Models\Compain;
use Auth;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'firstName',
        'lastName',
        'phone',
        'info',
        'website',
        'contactEmail',
        'addressLine',
        'addressLine2',
        'addressCity',
        'addressState',
        'addressCountry',
        'addressPostalCode',
        'latitude',
        'longitude',
        'profile_photo',
        'is_active',
        'email_verified_at',
        'password',
        'driver_license_id',
        'driver_license_class',
        'driver_license_expiry',
        'national_id', 
        'insurance_company',
        'ontrac_username',
        'ontrac_password'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getRole()
    {
        return $this->hasOneThrough('App\Models\Role', 'App\Models\UserRoleRelation', 'user_id', 'id', 'id', 'role_id');
    }
    public function checkFollow()
    {
        return $this->belongsToMany('App\User', 'following', 'masjid_id', 'user_id');
    }
    /**
     * Check Roles admin here 
     *
     * @var array
     */
    public function isAdmin()
    {
        $role = Role::join('role_user', 'roles.id', '=', 'role_user.role_id')
            //->join('permission_role','roles.id', '=', 'permission_role.role_id')
            ->where('user_id', Auth::user()->id)
            ->first();
           // dd($role);
        return $role->name == 'admin' ? true : false;
    }
    public function isCompany()
    {
        $role = Role::join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('user_id', Auth::user()->id)
            ->first();
        return $role->name == 'company' ? true : false;
    }
    public function isUsers()
    {
        $role = Role::join('role_user', 'roles.id', '=', 'role_user.role_id')
                   // ->join('permission_role','roles.id', '=', 'permission_role.role_id')
                    ->where('user_id', Auth::user()->id)
                    ->first();
               // dd($role);
        return $role->name == 'user' ? true : false;
    }
    public function campaign()
    {
        return $this->hasMany('App\Models\Compain', 'masjid_id')->orderBy('created_at', 'DESC');
    }
}
