<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AllNotifications;

class Friends extends Model
{
     use Notifiable;
    
    protected $table = 'friends';
    protected $fillable = ['user_id_01','user_id_02','status','action_user_id'];
    
    
    public function sendClientAddedNotification($client)
    {
        $this->notify(new AllNotifications($client));
    }
}
