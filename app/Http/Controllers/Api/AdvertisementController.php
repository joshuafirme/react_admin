<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Advertisements;
use App\NumberVerifications;
use Validator;

class AdvertisementController extends ResponseController
{
    
    public function getAnnouncements(){
        $ads = Advertisements::where('status',1)->get();

        if($ads){
            return $this->sendResponse($ads);
        }
        else{
            $error = "Sorry! advertisements not found.";
            return $this->sendError($error, 401); 
        }
    }
        
}

