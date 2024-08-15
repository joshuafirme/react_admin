<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Logs;
use App\User;
use App\LogDetails;
use App\Incidents;
use App\Categories;
use App\SubCategories;
use App\Agencies;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\LogDetailsExport;
use Maatwebsite\Excel\Facades\Excel;

class LogsController extends Controller
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
        $dataArr = array();
        $dataArr2 = array();
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3){
            $logDetails = LogDetails::with('agencies','categories')->orderby('signature','desc')->get();
        }else{
            $logDetails = LogDetails::with('agencies','categories')->where('agency_id',$user->agency_id)->orderby('signature','desc')->get();
        }
        
      
        foreach($logDetails as $data){
            $user = User::find($data->user_id);
            $inc['id'] = $data->id;   
            $inc['user_id'] = str_pad($data->id, 5, "0", STR_PAD_LEFT);
            $inc['username'] = isset($user) ? "$user->firstname $user->lastname" : "N/A";
            $inc['agency'] = !empty($data->agencies[0]) ?  $data->agencies[0]->agency_name : "";   
            $inc['category'] =  !empty($data->categories[0]) ? $data->categories[0]->category_name : "";   
            $inc['description'] = $data->remarks; 
            $inc['status'] = $data->status; 
            $inc['signature'] = $data->signature; 
            $inc['date_registered'] = $data->date_registered; 
            $inc['created_at'] = $data->created_at; 
            array_push($dataArr2,$inc);
        }
        
        
        
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($dataArr2);

        // Define how many items we want to be visible in each page
        $perPage = 20;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());
        
        return view('catalog.logs.logs')->with(['logs'=>$paginatedItems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::where('status',1)->get();
        return view('catalog.subcategory.add')->with(["categories"=>$categories]);
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
                'category_id' => 'required',
                'subcategory_name' => 'required',
                'subcategory_description' => 'required'
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $subcategory = new SubCategories();
            $subcategory->category_id = $input['category_id'];
            $subcategory->subcategory_name = $input['subcategory_name'];
            $subcategory->subcategory_description = $input['subcategory_description'];
            $subcategory->status = 1;
            $subcategory->save();

            if($subcategory){
                $data['message'] ="Successfully added";
            }else{
                $data['message'] = "Failed to added";
            }
            
            return json_encode($data);
            
        }
        
        $messages = $validator->messages();
        return json_encode($messages);
    }

    public function updateIncident(Request $request)
    {
           
        $validator = Validator::make($request->all(),
            [
                'signature' => 'required',
                'id' => 'required',
                'agency_id' => 'required'
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $logdetails = LogDetails::find($input['id']);
            $logdetails->signature = $input['signature'];
            $logdetails->agency_id = $input['agency_id'];
            $logdetails->update();

            if($logdetails){
                $data['message'] ="Successfully updated";
            }else{
                $data['message'] = "Failed to updated";
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
    public function show(Request $request,$id)
    {
        
        $logDetails = LogDetails::where('id',$id)->first();
       
        $userData = User::find($logDetails['user_id']);
        $agencies = Agencies::where('status',1)->get();;
  
        
        return view('catalog.logs.show')->with(['logs'=>$logDetails,'userData'=>$userData,'agencies'=>$agencies]);
    }

    //populate drop off points
    public function getDropOffPoints(Request $request){
        $data = array();
        $input = $request;
        $id = $input['category_id'];
        if($id != 0){
            
         
            $logdetails = LogDetails::where('category_id',$id)->whereDate('created_at',$input['date'])->get();
            if($logdetails){
                foreach($logdetails as $dataLogs){
                    $arr['coord_x'] = $dataLogs->coord_x;
                    $arr['coord_y'] = $dataLogs->coord_y;
                    array_push($data,$arr);
                }
            }else{
                $error = "data not found";
            }
            return json_encode($data);
        }
        else{
            $logdetails = LogDetails::whereDate('created_at',$input['date'])->get();
            if($logdetails){
                foreach($logdetails as $dataLogs){
                    $arr['coord_x'] = $dataLogs->coord_x;
                    $arr['coord_y'] = $dataLogs->coord_y;
                    array_push($data,$arr);
                }
            }else{
                $error = "data not found";
            }
            return json_encode($data);
        }
        
        return json_encode($error);
    }

    public function reports(Request $request)
    {
        $agencies = Agencies::where('status',1)->get();
        return view('catalog.logs.reports')->with(['agencies'=>$agencies]);
    }

    public function getReports (Request $request){

        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2 => 'reported_by',
                            3 => 'assigned_department',
                            3 => 'status',
                        );
  
        $totalData = LogDetails::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $logdetails = LogDetails::with('agencies','categories')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $username = 0;
            if(strpos($search, "|") !== false ){
                $keywords = explode("|", $search);
                $keywords2 = explode("|", $search);
                $filter = "";
                $logdetails = LogDetails::with('agencies','categories')->where(function($query) use($keywords){
                    foreach ($keywords as $key => $value) {
                        switch($key){
                            case 0:
                                $filter = $value;
                            break;
                            case 1:
                                $from = $value;
                            break;
                            case 2:
                                $to = $value;
                            case 3:
                                $agency = $value;
                            break;
                        }
                    }
                    if($agency != 0){
                        $query->whereBetween($filter, [$from, $to])->where('agency_id',$agency);
                    }else{
                        $query->WhereBetween($filter, [$from, $to]);    
                    }
                    
                })->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                
                $totalFiltered = LogDetails::with('agencies','categories')->where(function($query) use($keywords2){
                    foreach ($keywords2 as $key => $value) {
                        switch($key){
                            case 0:
                                $filter = $value;
                            break;
                            case 1:
                                $from = $value;
                            break;
                            case 2:
                                $to = $value;
                            case 3:
                                $agency = $value;
                            break;
                        }
                    }
                    if($agency != 0){
                        $query->whereBetween($filter, [$from, $to])->where('agency_id',$agency);
                    }else{
                        $query->WhereBetween($filter, [$from, $to]);    
                    }
                    
                })->count();

            }else{

        

            $logdetails =  LogDetails::with('agencies','categories')->where('agency_id',$search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = LogDetails::where('agency_id',$search)->count();
                
        
            }
        }

            $data = array();
            if(!empty($logdetails))
            {
                foreach ($logdetails as $x)
                {
                
                    $num = $x->id;
                    $number = str_pad($num, 8, "0", STR_PAD_LEFT);
                    $nestedData['incident_number'] = $number;
                    $nestedData['date'] = date('j M Y',strtotime($x->created_at));
                    $user = User::find($x->user_id);
                    $nestedData['reported_by'] = isset($user) ? $user['username'] : "N/A";
                    $nestedData['assigned_department'] = count($x->agencies) > 0 ? $x->agencies[0]->agency_name : "N/A";
                    $nestedData['status'] = $x->signature;
                    $nestedData['description'] = $x->remarks;
                    
                    $nestedData['view'] = "<a href='/catalog/logs/show/".$x->id."?from=report' class='btn btn-success'><i class='fa fa-eye'></i></a>";
                   
                    // $nestedData['time'] = date('h:i a',strtotime($x->created_at));
                    $data[] = $nestedData;

                }
            }
            
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
                
            echo json_encode($json_data); 
    }

    public function exportReportFile() 
    {
        return Excel::download(new LogDetailsExport(), 'logs.xlsx');
    }
    
}
