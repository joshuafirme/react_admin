<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    protected $table = 'incidents';
    protected $fillable = ['user_id', 'category_id','subcategory_id','incident_name','incident_description','forwared_to','location','attachment', 'incident_status','status',];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    
    public function categories()
    {
        return $this->belongsTo('App\Categories','category_id');
    }

    public function subcategories()
    {
        return $this->belongsTo('App\Subcategories','subcategory_id');
    }
    
    public function agencies()
    {
        return $this->belongsTo('App\Agencies','agency_id');
    }
}
