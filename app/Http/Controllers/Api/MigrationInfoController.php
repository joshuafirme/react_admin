<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\MigrationsInfo;
use Validator;
use Carbon\Carbon;


class MigrationInfoController extends ResponseController
{
     //create or update migration info
    public function createMigration(Request $request)
    {
        $now = Carbon::now();
        $input = $request;
        $user_id = $input['user_id'];
        
        $migrationsinfo = MigrationsInfo::where('user_id',$user_id)->first();
        
        if(!empty($migrationsinfo)){
            $migrationsinfo->user_id =  $user_id;
            $migrationsinfo->complete_name = $input['complete_name'];
            $migrationsinfo->date_of_arrival_abroad = $input['date_of_arrival_abroad'];
            $migrationsinfo->contact_person_ph = $input['contact_person_ph'];
            $migrationsinfo->contact_number_ph = $input['contact_number_ph'];
            $migrationsinfo->pra = $input['pra'];
            $migrationsinfo->fra = $input['fra'];
            $migrationsinfo->employer = $input['employer'];
            $migrationsinfo->migration_status = 1;
            $migrationsinfo->status = 1;
            $migrationsinfo->update();
            
            if($migrationsinfo){
                $success['message'] = "Migrations Info Successfully updated";
                $success['id'] = $migrationsinfo->id;
                $success['complete_name'] = $migrationsinfo->complete_name;
                $success['date_of_arrival_abroad'] = $migrationsinfo->date_of_arrival_abroad;
                $success['contact_person_ph'] = $migrationsinfo->contact_person_ph;
                $success['contact_number_ph'] = $migrationsinfo->contact_number_ph;
                $success['pra'] = $migrationsinfo->pra;
                $success['fra'] = $migrationsinfo->fra;
                $success['employer'] = $migrationsinfo->employer;
                $success['attachment'] = !empty($migrationsinfo->attachment) ? 'http://lattehub.com/ofw_admin/public' . $migrationsinfo->attachment : '' ;
                return $this->sendResponse($success);
            }
            else{
                $error = "Sorry! Registration is not successfull.";
                return $this->sendError($error, 401); 
            }
        }
        
        
        //proceed here if not yet added migrations info
        $migrationsinfo = new MigrationsInfo();
        $migrationsinfo->user_id =  $user_id;
        $migrationsinfo->complete_name = $input['complete_name'];
        $migrationsinfo->date_of_arrival_abroad = $input['date_of_arrival_abroad'];
        $migrationsinfo->contact_person_ph = $input['contact_person_ph'];
        $migrationsinfo->contact_number_ph = $input['contact_number_ph'];
        $migrationsinfo->pra = $input['pra'];
        $migrationsinfo->fra = $input['fra'];
        $migrationsinfo->employer = $input['employer'];
        $migrationsinfo->migration_status = 1;
        $migrationsinfo->status = 1;
        $migrationsinfo->save();
        
        if($migrationsinfo){
            $success['message'] = "Migrations Info Successfully saved";
            $success['id'] = $migrationsinfo->id;
            $success['complete_name'] = $migrationsinfo->complete_name;
            $success['date_of_arrival_abroad'] = $migrationsinfo->date_of_arrival_abroad;
            $success['contact_person_ph'] = $migrationsinfo->contact_person_ph;
            $success['contact_number_ph'] = $migrationsinfo->contact_number_ph;
            $success['pra'] = $migrationsinfo->pra;
            $success['fra'] = $migrationsinfo->fra;
            $success['employer'] = $migrationsinfo->employer;
            $success['attachment'] = !empty($migrationsinfo->attachment) ? 'http://lattehub.com/ofw_admin/public' . $migrationsinfo->attachment : '' ;
            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401); 
        }
        
        
        
    }
    
    public function uploadMigrationFiles(Request $request){
        $input = $request;
        $validation = Validator::make($request->all(), [
          'attachment' => 'required|max:20000'
        ]);
        
        if($validation->fails()){
            $error = "report not found";
            return $this->sendResponse($error);
        }



        $image = $request->file('attachment');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/migrationsinfo'), $new_name);

        $migrationsinfo = MigrationsInfo::find($input['migration_id_attachment']);
        $migrationsinfo->attachment = '/images/migrationsinfo/'. $new_name;
        $migrationsinfo->update();

        $return = array('message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success',
       'attachment' => 'http://lattehub.com/ofw_admin/public'.$migrationsinfo->attachment );

        return $this->sendResponse($return);
    }
    
    public function getMigrationsInfoByUserId($user_id){
        $migrationsinfo = MigrationsInfo::where('user_id',$user_id)->first();
        $user_data = User::where('id',$user_id)->first();
        $x = $user_data->agencies;
        
        $data = array();
        if($migrationsinfo){
            
            
        
            $data['id'] = str_pad($migrationsinfo['id'], 5, "0", STR_PAD_LEFT);
            $data['complete_name'] = $migrationsinfo['complete_name'];
            $data['date_of_arrival_abroad'] = date('Y-m-d', strtotime($migrationsinfo['date_of_arrival_abroad']));

            $data['contact_person_ph'] = $migrationsinfo['contact_person_ph'];

            $data['contact_number_ph'] = $migrationsinfo['contact_number_ph'];

            $data['pra'] = $migrationsinfo['pra'];
            $data['fra'] = $migrationsinfo['fra'];
            $data['employer'] = $migrationsinfo['employer'];
            $data['attachment'] = 'http://lattehub.com/ofw_admin/public'.$migrationsinfo['attachment'];

            $data['date'] = $migrationsinfo['created_at']->format('Y-m-d');
            $data['time'] = $migrationsinfo['created_at']->format('H:i:s A');
            $data['agency_info'] = $x;
            return $this->sendResponse($data);
        }
        else{
            $data['error'] = "migration not found";
            $data['agency_info'] = $x;
            return $this->sendResponse($data);
        }
    }
}
