<?php

namespace Modules\TaskMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Tasks extends Model
{
    protected $guarded = [];
    protected $table = 'tasks';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function project()
    {
        return $this->belongsTo('Modules\TaskMaster\Entities\Project', 'project_id');
    }
    public function taskType()
    {
        return $this->belongsTo('Modules\Admin\Entities\TaskType', 'task_type_id');
    }
}
