<?php

namespace Modules\TaskMaster\Entities;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $guarded = [];
    protected $table = 'tasks';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('Modules\TaskMaster\Entities\Project');
    }
    public function taskType()
    {
        return $this->belongsTo('Modules\Admin\Entities\TaskType');
    }
}
