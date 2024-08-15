<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogDetails extends Model
{
    protected $table = 'logdetails';
    protected $fillable = ['log_id', 'drop_off_points','coord_x','coord_y','agency_id','category_id','qty_remainings','remarks','signature','status','user_id','attachment'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function agency()
    {
        return $this->belongsTo('App\Agencies','agency_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Categories','category_id');
    }
    
    public function categories()
    {
        return $this->hasMany('App\Categories','id','category_id');
    }

    public function agencies()
    {
        return $this->hasMany('App\Agencies','id','agency_id');
    }

    public function subcategories()
    {
        return $this->belongsTo('App\Subcategories','subcategory_id');
    }
}
