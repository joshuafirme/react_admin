<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Logs;
use App\LogDetails;
use App\Incidents;
use App\Categories;
use App\Subcategories;
use Validator;
use Carbon\Carbon;
use Notification;
use App\Notifications\EmailNotification;
use Pusher\Pusher;

class IncidentController extends ResponseController
{
     
    
    //create logs
    public function createReport(Request $request)
    {
        try {
            $input = $request;

            $lat = $input['coord_x'];
            $long = $input['coord_y'];

            $formatted_location = $input['location'];
            
            $path = null;
            if ($input['attachment']) {
                $folder = "images/incident-reports/";
                $origName = pathinfo($input['attachment']->getClientOriginalName(), PATHINFO_FILENAME);
                $file_name = $origName . "_" . uniqid().'.'.$input['attachment']->extension();  
                
                $input['attachment']->move(public_path($folder), $file_name);
                $path = $folder . $file_name;
            }

            $logdetails = new LogDetails();
            $logdetails->log_id = 0;
            $logdetails->user_id =  $input['user_id'];
            $logdetails->category_id =  isset($input['category_id']) ? $input['category_id'] : 0;
            $logdetails->drop_off_points = $formatted_location;
            $logdetails->coord_x = $lat;
            $logdetails->coord_y = $long;
            $logdetails->agency_id = isset($input['agency_id']) ? $input['agency_id'] : 0;
            $logdetails->qty_dropped = 0;
            $logdetails->qty_remainings = 0;
            $logdetails->brgy =  $input['brgy'];
            $logdetails->remarks =  $input['remarks'];
            $logdetails->attachment =  $path;
            $logdetails->signature =  "Open";
            $logdetails->status = 1;
            $logdetails->save();

            
            $response = [];
            
            if($logdetails){
                $response['success'] = true;
                $response['message'] = "Incident Successfully submitted";
                $response['id'] = $logdetails->id;
                $response['log_details'] = $logdetails;
                $response['payload'] = $request->all();
                

                //Remember to change this with your cluster name3.
                $options = array(
                    'cluster' => 'eu',
                    'encrypted' => true
                );

                //Remember to set your credentials below.
                $pusher = new Pusher(
                    'f32dc778951bef48e635',
                    'ceea0f5d2e531a673977',
                    '1170519', $options
                );
                
                $pusher->trigger('update-data', 'update-data-event', json_encode($logdetails));

                return $this->sendResponse($response);
            }
            else{
                $response['success'] = false;
                $response['message'] = "An error was occured, please try again.";
                return $this->sendResponse($response);
            }
        } catch (\Exception $e) {
            
            $error_message = "Message: " . $e->getMessage() . "<br>" .
            "File: " . $e->getFile() . "<br>" .    
            "Line: " . $e->getLine() . "<br>";

            return response()->json([
                'success' => false,
                'message' => $error_message
            ]);

        }
        
    }

    public function getReportInfo($id){
        $data = LogDetails::with([
            'agency',
            'category'
        ])->find($id);
        
        if($data){
            return $this->sendResponse($data);
        }
        else{
            $error = "report not found";
            return $this->sendResponse($error);
        }
    }
    
    public function getUserInfo(Request $request){
        $user = User::find($request['user_id']);
        
        
        $data = array();
        
        $data['id'] = $user['employee_no'];
        $data['qty_assigned'] = $user['qty_assigned'];
        
        
        if($user){
            return $this->sendResponse($data);
        }
        else{
            $error = "report not found";
            return $this->sendResponse($error);
        }
    }

    public function getLogData(Request $request){
        $data = array();
        $date = Carbon::now()->format('Y-m-d');
        $logs = Logs::where('user_id',$request['user_id'])->where('status',1)->where('created_at','like',$date.'%')->get();
        if($logs){
            
            foreach($logs as $val){
                $logdetails = LogDetails::where('log_id',$val->id)->where('created_at','like',$date.'%')->get();
                if($logdetails){
                    foreach($logdetails as $dataLogs){
                        $arr['id'] = $dataLogs->id;
                        $arr['log_id'] = $dataLogs->log_id;
                        $arr['drop_off_points'] = $dataLogs->drop_off_points;
                        $arr['transaction_type'] = $dataLogs->transaction_type;
                        $arr['qty_dropped'] = $dataLogs->qty_dropped;
                        $arr['qty_remainings'] = $dataLogs->qty_remainings;
                        array_push($data,$arr);
                    }
                }else{
                    $error = "data not found";
                }
            }
            return $this->sendResponse($data);
        }
        else{
            $error = "data not found";
        }
        
        return $this->sendResponse($error);
    }

    //populate drop off points
    public function getDropOffPoints(Request $request){
        $data = array();
        $date = $request['date'];
        //$logs = Logs::where('user_id',$request['user_id'])->where('status',1)->get();
//        if($logs){
//            
//            foreach($logs as $val){
//                $logdetails = LogDetails::where('log_id',$val->id)->get();
//                if($logdetails){
//                    foreach($logdetails as $dataLogs){
//                        $arr['coord_x'] = $dataLogs->coord_x;
//                        $arr['coord_y'] = $dataLogs->coord_y;
//                        array_push($data,$arr);
//                    }
//                }else{
//                    $error = "data not found";
//                }
//            }
//            return $this->sendResponse($data);
//        }
        
        if($request['user_id'] != "0"){
            if($date){
                $logdetails = LogDetails::where('user_id',$request['user_id'])->where('created_at','like',$date.'%')->get();    
            }else{
                $logdetails = LogDetails::where('user_id',$request['user_id'])->get();    
            }
            
        }else{
            if($date){
                $logdetails = LogDetails::where('created_at','like',$date.'%')->get();
            }else{
                $logdetails = LogDetails::get();
            }
        }
        
        if($logdetails){
            foreach($logdetails as $dataLogs){
                $arr['coord_x'] = is_null($dataLogs->coord_x) ? 14.592200 : $dataLogs->coord_x;
                $arr['coord_y'] = is_null($dataLogs->coord_y) ? 121.033840 : $dataLogs->coord_y;
                array_push($data,$arr);
            }
        }else{
            $error = "data not found";
        }
        
        return $this->sendResponse($error);
    }
    
    public function updateLogData(Request $request){
        
        $date = Carbon::now()->format('Y-m-d');
        $user = Subcategories::selectRaw('SUM(subcategory_name) as qty_assigned')->where('category_id',$request['user_id'])->where('created_at','like',$date.'%')->first();
        $input = $request;
        $current_val = $user->qty_assigned == "" ? 0 : $user->qty_assigned; 
        $totalDropped = 0;
        $data = array();
        for ($i=0; $i < $input['counter']; $i++) { 
            $logdetails = LogDetails::where('id', $input['log_detail_id_'.$i])->first();
            
            if($logdetails){
                $current_val = $current_val -  $input['qty_dropped_'.$i];
                $logdetails->qty_dropped = $input['qty_dropped_'.$i];   
                $logdetails->qty_remainings = $current_val;
                $logdetails->update();

                $logs_update = Logs::where('id',$logdetails->log_id)->first();
                $logs_update->qty_assign = $current_val;
                $logs_update->qty_dropped = $input['qty_dropped_'.$i];
                $logs_update->update();

                $totalDropped += $input['qty_dropped_'.$i];
                $success['message'] = 'Logs Successfully updated';
            }
        }

        $user = User::find($input['user_id']);
        $user->qty_assigned = $current_val;
        $user->qty_dropped = $totalDropped;
        $user->update();

        if($current_val == 0){
            $log_update = Logs::where('user_id',$input['user_id'])->where('status',1)->where('created_at','like',$date.'%')->get();
            foreach($log_update as $x){
                $x->status = 2;
                $x->update();

                $log_update_details = LogDetails::where('log_id',$x->id)->get();
                foreach($log_update_details as $y){
                    // $y->qty_assign = $current_val;
                    // $y->qty_dropped = $totalDropped;
                    $y->status = 2;
                    $y->update();
                }
            }
        }
        
        // foreach($input['log_detail_id'] as $key => $value){
            
        
        //     if($logdetails){
        //         $current_val = $current_val -  $input['qty_dropped'][$key];
        //         $logdetails->qty_dropped = $input['qty_dropped'][$key];
        //         $logdetails->qty_remainings = $current_val;
        //         $logdetails->update();
        //         $success['message'] = 'Logs Successfully updated';

                
        //     }
        // }
        
        return $this->sendResponse($success);
        
    }

  
    
    public function getPopulatedData(){
        
        $category = Categories::with('agencies')->where('status',1)->get();
       
        
        if($category){
            return $this->sendResponse($category);
        }
        else{
            $error = "data not found";
            return $this->sendResponse($error);
        }
    }
    
    //logs
    //create report/complaint
    public function saveSignature(Request $request)
    {
        $now = Carbon::now();
        $input = $request;
        
        $logs = Logs::where('user_id',$input['user_id'])->first();
        $logs->transaction_type = $input['transaction_type'];
        $logs->qty_assign = $input['qty_assign'];
        $logs->qty_dropped = $input['qty_dropped'];
        $logs->date_registered = $now;
        $logs->status = 1;
        $logs->update();
        
        if($logs){
            $success['message'] = "Successfully submitted";
            $success['id'] = $logs ->id;
            
            $logdetails = new LogDetails();
            $logdetails->log_id = $logs ->id;
            $logdetails->drop_off_points = $input['drop_off_points'];
            $logdetails->transaction_type = $input['transaction_type'];
            $logdetails->qty_remainings = $input['qty_remainings'];
            $logdetails->remarks = $input['remarks'];
            $logdetails->signature = $input['signature'];
            $logdetails->status = 1;
            $logdetails->save();
//            $user = User::find(3);
//            $getReport = Incidents::find($report->id);
//            $userSender = User::find($input['user_id']);
//            $fullname = $userSender->firstname . " " . $userSender->middlename . " " . $userSender->lastname;
//            $details = [
//                'subject' => 'Incident Report',
//                'greeting' => 'Hi Admin',
//                'body' => 'This is a report from ' . $fullname,
//                'description' => "Description: " . $input['incident_description'],
//                'location' => "Location: " . $input['location'],
//                'category' => "Category: " . $getReport->categories->category_name,
//                'incident_type' => "Incident Type: " . $report->subcategories->subcategory_name,
//                'thanks' => 'Thank you for using OFW App',
//                'actionText' => 'View My Site',
//                'actionURL' => url('/'),
//                'notification_id' => $report->id
//            ];
//
//            Notification::send($user, new EmailNotification($details));

            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Logging Data is not successfull.";
            return $this->sendError($error, 401); 
        }
        
    }
}
