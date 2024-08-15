<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logs;
use App\User;
use App\LogDetails;
use App\Incidents;
use App\Categories;
use App\SubCategories;
use App\Tracking;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\LogDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Imports\TrackingImport;
use App\Exports\TrackingExport;
use App\Exports\TrackingPerRiderExport;
use Illuminate\Support\Facades\DB as DB;

class TrackingController extends Controller
{
    public $incident_statuses = [
        0=> 'Deleted',
        1=> 'Pending',
        2=> 'No Action',
        3=> 'Done / Completed',
        4=> 'Rejected',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('status',1)->get();
        $dataArr2 = array();
        
        $getDataLogs = Tracking::get();
        foreach($getDataLogs as $data){
            
            $user = User::find($data->user_id);
            $inc['id'] = $data->id;   
            $inc['order_number'] = $data->order_number;
            $inc['name'] = $data->name;
            $inc['username'] = !empty($user) ? $user->username : "";
            $inc['address'] = $data->address;   
            $inc['phone_number'] = $data->phone_number;   
            $inc['area'] = $data->area;
            $inc['actual_weight'] = $data->actual_weight; 
            $inc['weight_cost'] = $data->weight_cost; 
            $inc['cost'] = $data->cost; 
            $inc['declared_value'] = $data->declared_value; 
            $inc['delivery_status'] = $data->delivery_status; 
            $inc['delivery_date'] = $data->delivery_date; 
            $inc['returned_date'] = $data->returned_date; 
            $inc['aging'] = $data->aging; 
            $inc['remarks'] = $data->remarks; 
            $inc['user_id'] = $data->user_id; 
            $inc['created_at'] = $data->created_at; 
            $inc['date'] = $data->date; 
            array_push($dataArr2,$inc);
            
        }
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($dataArr2);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());
        
        return view('catalog.tracking.tracking')->with(['tracking'=>$paginatedItems,'users'=>$users]);
        
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $dataArr2 = array();
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $getDataLogs = Tracking::where('order_number', 'like', '%'.$query.'%')
                            ->orderBy($sort_by, $sort_type)->get();
            
            foreach($getDataLogs as $data){

                $user = User::find($data->user_id);
                $inc['id'] = $data->id;   
                $inc['order_number'] = $data->order_number;
                $inc['name'] = $data->name;
                $inc['username'] = !empty($user) ? $user->username : "";
                $inc['address'] = $data->address;   
                $inc['phone_number'] = $data->phone_number;   
                $inc['area'] = $data->area;
                $inc['actual_weight'] = $data->actual_weight; 
                $inc['weight_cost'] = $data->weight_cost; 
                $inc['cost'] = $data->cost; 
                $inc['declared_value'] = $data->declared_value; 
                $inc['delivery_status'] = $data->delivery_status; 
                $inc['delivery_date'] = $data->delivery_date; 
                $inc['returned_date'] = $data->returned_date; 
                $inc['aging'] = $data->aging; 
                $inc['remarks'] = $data->remarks; 
                $inc['user_id'] = $data->user_id; 
                $inc['date'] = $data->date; 
                $inc['created_at'] = $data->created_at; 
                array_push($dataArr2,$inc);
                
            }
            
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
    
            // Create a new Laravel collection from the array data
            $itemCollection = collect($dataArr2);
    
            // Define how many items we want to be visible in each page
            $perPage = 10;
    
            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
    
            // Create our paginator and pass it to the view
            $tracking= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
    
            // set url path for generted links
            $tracking->setPath($request->url());
                    
            return view('catalog.tracking.pagination_data', compact('tracking'))->render();
            // return view('catalog.tracking.pagination_data', compact('data'))->with(['tracking'=>$paginatedItems]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('status',1)->get();
        return view('catalog.tracking.add')->with(["users"=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'order_number' => 'required',
                'name' => 'required',
                'address' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $tracking = new Tracking();
            $tracking->date = $input['date'];
            $tracking->order_number = $input['order_number'];
            $tracking->name = $input['name'];
            $tracking->address = $input['address'];
            $tracking->phone_number = $input['phone_number'];
            $tracking->area = $input['area'];
            $tracking->actual_weight = $input['actual_weight'];
            $tracking->weight_cost = $input['weight_cost'];
            $tracking->cost = $input['cost'];
            $tracking->declared_value = $input['declared_value'];
            $tracking->delivery_status = "Order received by Flying High";
            $tracking->delivery_date = $input['delivery_date'];
            $tracking->returned_date = $input['returned_date'];
            $tracking->aging = $input['aging'];
            $tracking->remarks = $input['remarks'];
            $tracking->status = 1;
            $tracking->save();

            if($tracking){
                $data['message'] ="Successfully added";
            }else{
                $data['message'] = "Failed to added";
            }
            
            return json_encode($data);
            
        }
        
        $messages = $validator->messages();
        return json_encode($messages);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'order_number' => 'required',
                'name' => 'required',
                'address' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $tracking = Tracking::find($input['id']);
            $tracking->date = $input['date'];
            $tracking->order_number = $input['order_number'];
            $tracking->name = $input['name'];
            $tracking->address = $input['address'];
            $tracking->phone_number = $input['phone_number'];
            $tracking->area = $input['area'];
            $tracking->actual_weight = $input['actual_weight'];
            $tracking->weight_cost = $input['weight_cost'];
            $tracking->cost = $input['cost'];
            $tracking->declared_value = $input['declared_value'];
            $tracking->delivery_status = $input['delivery_status'];
            $date_today = Carbon::now();
            if($input['delivery_status'] == "Delivered"){
                $tracking->delivery_date =  $input['delivery_date'];
            }else{
                $tracking->delivery_date = $input['delivery_date'];
            }

            if($input['delivery_status'] == "Returned"){
                $tracking->returned_date = $input['returned_date'];
            }else{
                $tracking->returned_date = $input['returned_date'];
            }
            
            $tracking->aging = $input['aging'];
            $tracking->remarks = $input['remarks'];
            $tracking->status = 1;
            $tracking->update();

            if($tracking){
                $data['message'] ="Successfully added";
            }else{
                $data['message'] = "Failed to added";
            }
            
            return json_encode($data);
            
        }
        
        $messages = $validator->messages();
        return json_encode($messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tracking = Tracking::where("status",1)->where('id',$id)->first();
        return view('catalog.tracking.show')->with(["tracking"=>$tracking]);
    }

    public function edit($id)
    {
        $tracking = Tracking::where("status",1)->where('id',$id)->first();
        return view('catalog.tracking.edit')->with(["tracking"=>$tracking]);
    }

    function update_data(Request $request)
    {
        $return = '';
        if($request->ajax())
        {
            $value = $request->get('value');
            $data = $request->get('data');
            $type = $request->get('type');

            switch($type){
                case "assign":
                    $return = "<p class='alert alert-success'>Rider assigned successfully</p>";
                    $tracking = Tracking::find($value);
                    $tracking->user_id = $data;
                    $tracking->delivery_status = "In Transit";
                    $tracking->update();

                    $user = User::find($data);
                    $user->qty_assigned =  $user->qty_assigned + 1;
                    $user->update();
                break;
                case "delivery":
                    $return = "<p class='alert alert-success'>Status set successfully</p>";
                    $tracking = Tracking::find($value);
                    $tracking->delivery_status = $data;
                    $tracking->update();

                break;
                case "delete":
                    $return = "<p class='alert alert-success'>Status set successfully</p>";
                    $tracking = Tracking::find($value);
                    $tracking->status = 0;
                    $tracking->update();

                break;
            }
            
            return $return;
        }
    }

    function update_status(Request $request)
    {
        $return = '';
        if($request->ajax())
        {
            $delivery_status_update = $request->get('delivery_status_update');
            $date_to_update = $request->get('date_to_update');
            $date_from_update = $request->get('date_from_update');

          
            $tracking = Tracking::whereBetween('created_at', [$date_from_update, $date_to_update])->update(['delivery_status' => $delivery_status_update,'delivery_date'=>DB::raw("`created_at`")]);
            // $tracking->delivery_status = $delivery_status_update;
            // $tracking->update();

            $return = "<p class='alert alert-success'>Status from ". $date_from_update. " up to ". $date_to_update ." is updated to " . $delivery_status_update ." </p>";
           
            
            return $return;
        }
    }

    public function import() 
    {
        Excel::import(new TrackingImport, request()->file('imported_file'));
        
        return redirect('/catalog/tracking')->with('success', 'All good!');
    }


    public function reports(Request $request)
    {
        $users = User::where('status',1)->where('role_id',4)->get();
        return view('catalog.logs.reports')->with('users',$users);
    }

    public function report(Request $request)
    {
        $users = User::where('status',1)->get();
        $dataArr2 = array();
        
        $getDataLogs = Tracking::whereIn('delivery_status',['Delivered','Returned'])->get();
        foreach($getDataLogs as $data){
            
            $user = User::find($data->user_id);
            $inc['id'] = $data->id;   
            $inc['order_number'] = $data->order_number;
            $inc['name'] = $data->name;
            $inc['username'] = !empty($user) ? $user->username : "";
            $inc['address'] = $data->address;   
            $inc['phone_number'] = $data->phone_number;   
            $inc['area'] = $data->area;
            $inc['actual_weight'] = $data->actual_weight; 
            $inc['weight_cost'] = $data->weight_cost; 
            $inc['cost'] = $data->cost; 
            $inc['declared_value'] = $data->declared_value; 
            $inc['delivery_status'] = $data->delivery_status; 
            $inc['delivery_date'] = $data->delivery_date; 
            $inc['returned_date'] = $data->returned_date; 
            $inc['aging'] = $data->aging; 
            $inc['remarks'] = $data->remarks; 
            $inc['user_id'] = $data->user_id; 
            $inc['created_at'] = $data->created_at; 
            $inc['date'] = $data->date; 
            array_push($dataArr2,$inc);
            
        }
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($dataArr2);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());
        
        return view('catalog.tracking.report.reports')->with(['tracking'=>$paginatedItems,'users'=>$users]);
        
    }

    function fetch_data_report(Request $request)
    {
        if($request->ajax())
        {
            $dataArr2 = array();
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $getDataLogs = Tracking::where('order_number', 'like', '%'.$query.'%')->whereIn('delivery_status',['Delivered','Returned'])
                            ->orderBy($sort_by, $sort_type)->get();
            
            foreach($getDataLogs as $data){

                $user = User::find($data->user_id);
                $inc['id'] = $data->id;   
                $inc['order_number'] = $data->order_number;
                $inc['name'] = $data->name;
                $inc['username'] = !empty($user) ? $user->username : "";
                $inc['address'] = $data->address;   
                $inc['phone_number'] = $data->phone_number;   
                $inc['area'] = $data->area;
                $inc['actual_weight'] = $data->actual_weight; 
                $inc['weight_cost'] = $data->weight_cost; 
                $inc['cost'] = $data->cost; 
                $inc['declared_value'] = $data->declared_value; 
                $inc['delivery_status'] = $data->delivery_status; 
                $inc['delivery_date'] = $data->delivery_date; 
                $inc['returned_date'] = $data->returned_date; 
                $inc['aging'] = $data->aging; 
                $inc['remarks'] = $data->remarks; 
                $inc['user_id'] = $data->user_id; 
                $inc['date'] = $data->date; 
                $inc['created_at'] = $data->created_at; 
                array_push($dataArr2,$inc);
                
            }
            
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
    
            // Create a new Laravel collection from the array data
            $itemCollection = collect($dataArr2);
    
            // Define how many items we want to be visible in each page
            $perPage = 10;
    
            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
    
            // Create our paginator and pass it to the view
            $tracking= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
    
            // set url path for generted links
            $tracking->setPath($request->url());
                    
            return view('catalog.tracking.report.pagination_data', compact('tracking'))->render();
            // return view('catalog.tracking.pagination_data', compact('data'))->with(['tracking'=>$paginatedItems]);
        }
    }

    public function export(Request $request) 
    {
        $user_id = $request->get('user_id');
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');

        if($user_id){
            $trackings = Tracking::whereIn('delivery_status',['Delivered','Returned'])->where('user_id',$user_id)->get();
        }else if(!empty($date_to) && !empty($date_from)){
            $trackings = Tracking::whereIn('delivery_status',['Delivered','Returned'])->whereBetween('date',[$date_from,$date_to])->where('user_id',$user_id)->get();
        }else{
            $trackings = Tracking::whereIn('delivery_status',['Delivered','Returned'])->where('user_id',$user_id)->get();
        }

        if(count($trackings) < 1){
            return json_encode("No results found.");
        }
        
        return Excel::download(new TrackingExport($user_id,$date_from,$date_to), 'tracking.xlsx');
    }

    public function exportTrackingPerRider(Request $request) 
    {
        $user_id = $request->get('user_id');
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');

        if($user_id){
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->where('user_id',$user_id)->get();
        }
        
        if(!empty($date_to) && !empty($date_from)){
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->whereBetween('updated_at',[$date_from,$date_to])->where('user_id',$user_id)->get();
            
        }else{
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->where('user_id',$user_id)->get();
        }
        if(count($trackings) < 1){
            return json_encode("No results found.");
        }
        
        return Excel::download(new TrackingPerRiderExport($user_id,$date_from,$date_to), 'tracking.xlsx');
    }

    public function monitor(){
        $tracking = array();
        return view('catalog.tracking.monitor')->with('tracking',$tracking);
    }

    public function getsearchdata(Request $request){
        $ordernumber = $request->get('query');
        $getDataLogs = Tracking::where('order_number',$ordernumber)->get();
        $dataArr2 =array();
            foreach($getDataLogs as $data){

                $user = User::find($data->user_id);
                $inc['id'] = $data->id;   
                $inc['order_number'] = $data->order_number;
                $inc['name'] = $data->name;
                $inc['username'] = !empty($user) ? $user->username : "";
                $inc['address'] = $data->address;   
                $inc['phone_number'] = $data->phone_number;   
                $inc['area'] = $data->area;
                $inc['actual_weight'] = $data->actual_weight; 
                $inc['weight_cost'] = $data->weight_cost; 
                $inc['cost'] = $data->cost; 
                $inc['declared_value'] = $data->declared_value; 
                $inc['delivery_status'] = $data->delivery_status; 
                $inc['delivery_date'] = $data->delivery_date; 
                $inc['returned_date'] = $data->returned_date; 
                $inc['aging'] = $data->aging; 
                $inc['remarks'] = $data->remarks; 
                $inc['user_id'] = $data->user_id; 
                $inc['date'] = $data->date; 
                $inc['created_at'] = $data->created_at; 
                $inc['updated_at'] = $data->updated_at; 
                array_push($dataArr2,$inc);
                
            }

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
    
            // Create a new Laravel collection from the array data
            $itemCollection = collect($dataArr2);
    
            // Define how many items we want to be visible in each page
            $perPage = 10;
    
            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
    
            // Create our paginator and pass it to the view
            $tracking= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
    
            // set url path for generted links
            $tracking->setPath($request->url());

        return view('catalog.tracking.getsearchdata')->with(['tracking'=>$tracking]);
    }
    
    public function updatestatus()
    {
        return view('catalog.tracking.updatestatus');
    }

    public function update_status_del(Request $request){
       
        if($request->ajax())
        {
            $ret['error'] = array();
            $ret['success'] = array();
            //validations of data
            foreach($request->order_number as $key => $value){
                
                $tracking = Tracking::where('order_number',$value)->first();
                if(!empty($tracking)){
                    continue;
                }else{
                    array_push($ret['error'],$request->counter[$key]);
                }

            }

            if(count($ret['error']) > 0){
                return json_encode($ret);
            }

            //updating of data after validations
            foreach($request->order_number as $key => $value){
                
                $tracking = Tracking::where('order_number',$value)->first();
                $tracking->delivery_date = $request->delivery_date[$key];
                $tracking->delivery_status = "Delivered";
                $tracking->update();
                
                array_push($ret['success'],array('counter' => $request->counter[$key],'order_number' => $value));
            }

           if(count($ret['success']) > 0 ){
               return json_encode($ret);
           }
            
            return $ret;
        }
    }

}
