<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisements extends Model
{
    protected $table = 'advertisements';
    protected $fillable = ['organization_id','ads_name','ads_description','ads_email','ads_type','ads_url','ads_img','ads_status', 'status', 'date_registered'];
    
}
