<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany('App\User');
    }
}


