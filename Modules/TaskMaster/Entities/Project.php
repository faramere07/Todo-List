<?php

namespace Modules\TaskMaster\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function task()
    {
        return $this->hasMany('Modules\TaskMaster\Entities\Tasks');
    }
}
