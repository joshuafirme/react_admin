<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agencies extends Model
{
    protected $table = 'agencies';
    protected $fillable = ['organization_id','agency_name','agency_description','agency_type','agency_status', 'status', 'date_registered'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function incidents()
    {
        return $this->hasMany('App\Incidents','id');
    }
}
