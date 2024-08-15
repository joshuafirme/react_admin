<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    protected $table = 'subcategories';
    protected $fillable = ['category_id','subcategory_name', 'subcategory_description','subcategory_status','status'];
    
    public function categories()
    {
        return $this->hasMany('App\Categories','id','category_id');
    }
    
    public function incidents()
    {
        return $this->hasMany('App\Incidents','id');
    }
}
