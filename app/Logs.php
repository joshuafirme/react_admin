<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $fillable = ['user_id', 'category_id','subcategory_id','transaction_type','qty_assign','qty_dropped','status'];
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
    
}
