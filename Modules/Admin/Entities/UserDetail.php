<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $guarded = [];

    protected $table = 'user_details';

    protected $fillable = [ 
    	'first_name', 'user_id', 'mid_name', 'last_name', 'profile_picture' 
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
