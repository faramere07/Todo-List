<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'task_types';

    public function ManyTask()
    {
        return $this->hasMany('Modules\TaskMaster\Entities\Tasks');
    }
}
