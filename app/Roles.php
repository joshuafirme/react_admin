<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    protected $table = 'roles';
    protected $fillable = ['role_name', 'role_description', 'role_type','role_status','status',];
    public function user()
    {
        return $this->hasMany('App\User','role_id');
    }
}
