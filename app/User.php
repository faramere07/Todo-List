<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password', 'username', 'type_id',
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

    public function userDetail()
    {
        return $this->hasOne('Modules\Admin\Entities\UserDetail');
    }

    public function userType()
    {
        return $this->belongsTo('Modules\Admin\Entities\UserType','type_id');
    }

    public function task()
    {
        return $this->hasMany('Modules\TaskManager\Entities\Task');
    }
    public function project()
    {
        return $this->hasMany('Modules\TaskManager\Entities\Project');
    }
}
