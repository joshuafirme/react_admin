<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MigrationsInfo extends Model
{
    protected $table = 'migrations_info';
    protected $fillable = ['user_id', 'complete_name','date_of_arrival_abroad','contact_person_ph','contact_number_ph','pra','fra','employer','attachment', 'migration_status','status'];
    
    public function user()
    {
        return $this->hasOne('App\User','user_id');
    }
}
