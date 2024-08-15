<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\NumberVerifications;
use Validator;
use Notification;
use App\Notifications\EmailNotification;

class ProfileController extends ResponseController
{
    public function getProfileInfoByUserId($id){
        $user = User::find($id);
        
        $return = array();
        if(!empty($user)){
            $return['data'] = $user;
        }
        return $this->sendResponse($return); 
    }
}
