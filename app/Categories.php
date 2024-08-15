<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category_name', 'category_description','category_status','status','code_color','agency_id'];
    
    public function subcategories()
    {
        return $this->hasMany('App\Subcategories','category_id','id');
    }

    public function agencies()
    {
        return $this->hasMany('App\Agencies','id','agency_id');
    }
    
    public function incidents()
    {
        return $this->hasMany('App\Incidents','id');
    }
}
