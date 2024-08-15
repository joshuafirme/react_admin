<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incidents;
use App\Categories;
use App\SubCategories;
use App\Agencies;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class IncidentsController extends Controller
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
//        $searchTerm = 'Emp';
//        $x = Incidents::whereLike(['categories.category_name'], $searchTerm)->get();
//        die(var_dump($x));
        
        //$subcategory = Categories::with('subcategories')->get();
        
        //die($subcategory);
        
        $incident = Incidents::where('status',1);
        $getIncidents = $incident->get();
        $dataArr = array();
        
       
        
        foreach($getIncidents as $key => $data){
            $incident = Incidents::where('status',1);
            $getDataIncidents = $incident->where('id',$data->id)->first();
            //die(var_dump($getCat->categories['category_name']));
            $incidents['id'] = $data->id;   
            $incidents['case_no'] = str_pad($data->id, 5, "0", STR_PAD_LEFT);;   
            $incidents['incident_name'] = $data->incident_name;   
            $incidents['incident_description'] = $data->incident_description;   
            $incidents['location'] = $data->location;   
            $incidents['attachment'] = $data->attachment;   
            $incidents['incident_status'] = $this->incident_statuses[$data->incident_status];
            $incidents['firstname'] = $getDataIncidents['user']['firstname'];  
            $incidents['middlename'] = $getDataIncidents['user']['middlename'];
            $incidents['lastname'] = $getDataIncidents['user']['lastname'];
            $incidents['category_name'] = $getDataIncidents['categories']['category_name'];
            $incidents['subcategory_name'] = $getDataIncidents['subcategories']['subcategory_name'];
            $incidents['agency_name'] = $getDataIncidents['agencies']['agency_name'];
            array_push($dataArr,$incidents);
        }
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($dataArr);
 
        // Define how many items we want to be visible in each page
        $perPage = 15;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
        
        return view('catalog.logs.incidents')->with('incidents',$paginatedItems);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Categories::where('status',1)->get();
        $subcategories = SubCategories::where("status",1)->get();
        $agencies = Agencies::where('status',1)->get();
        
        $incident = Incidents::where('status',1);
        $getDataIncidents = $incident->where('id',$id)->first();
        
        $incidents['id'] = $getDataIncidents->id;   
        $incidents['case_no'] = str_pad($getDataIncidents->id, 5, "0", STR_PAD_LEFT);;   
        $incidents['incident_name'] = $getDataIncidents->incident_name;   
        $incidents['incident_description'] = $getDataIncidents->incident_description;   
        $incidents['location'] = $getDataIncidents->location;   
        $incidents['attachment'] = $getDataIncidents->attachment;
        $incidents['category_id'] = $getDataIncidents->category_id;   
        $incidents['subcategory_id'] = $getDataIncidents->subcategory_id;
        $incidents['incident_status'] = $this->incident_statuses[$getDataIncidents->incident_status];
        $incidents['firstname'] = $getDataIncidents['user']['firstname'];  
        $incidents['middlename'] = $getDataIncidents['user']['middlename'];
        $incidents['lastname'] = $getDataIncidents['user']['lastname'];
        $incidents['category_name'] = $getDataIncidents['categories']['category_name'];
        $incidents['subcategory_name'] = $getDataIncidents['subcategories']['subcategory_name'];
        $incidents['agency_name'] = $getDataIncidents['agencies']['agency_name'];
        $incidents['agency_id'] = $getDataIncidents->agency_id;  
        
        return view('catalog.incidents.show')->with(["incidents"=>$incidents,"subcategories"=>$subcategories,"categories"=>$categories,"agencies"=>$agencies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Categories::where('status',1)->get();
        $subcategories = SubCategories::where("status",1)->get();
        $agencies = Agencies::where('status',1)->get();
        
        $incident = Incidents::where('status',1);
        $getDataIncidents = $incident->where('id',$id)->first();
        
        $incidents['id'] = $getDataIncidents->id;   
        $incidents['case_no'] = str_pad($getDataIncidents->id, 5, "0", STR_PAD_LEFT);;   
        $incidents['incident_name'] = $getDataIncidents->incident_name;   
        $incidents['incident_description'] = $getDataIncidents->incident_description;   
        $incidents['location'] = $getDataIncidents->location;   
        $incidents['attachment'] = $getDataIncidents->attachment;
        $incidents['category_id'] = $getDataIncidents->category_id;   
        $incidents['subcategory_id'] = $getDataIncidents->subcategory_id;
        $incidents['incident_status'] = $this->incident_statuses[$getDataIncidents->incident_status];
        $incidents['firstname'] = $getDataIncidents['user']['firstname'];  
        $incidents['middlename'] = $getDataIncidents['user']['middlename'];
        $incidents['lastname'] = $getDataIncidents['user']['lastname'];
        $incidents['category_name'] = $getDataIncidents['categories']['category_name'];
        $incidents['subcategory_name'] = $getDataIncidents['subcategories']['subcategory_name'];
        $incidents['agency_name'] = $getDataIncidents['agencies']['agency_name'];
        $incidents['agency_id'] = $getDataIncidents->agency_id; 
        
        return view('catalog.incidents.edit')->with(["incidents"=>$incidents,"subcategories"=>$subcategories,"categories"=>$categories,"agencies"=>$agencies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
            $subcategory = SubCategories::find($input['id']);
            $subcategory->category_id = $input['category_id'];
            $subcategory->subcategory_name = $input['subcategory_name'];
            $subcategory->subcategory_description = $input['subcategory_description'];
            
            $subcategory->update();

            if($subcategory){
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Incidents::find($id);
        $subcategory->status = 0;
        $subcategory->update();

        if($subcategory->status == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
     
    public function updateStatus(Request $request)
    {
        $input = $request->all();
        $incident = Incidents::find($input['incident_id']);
        $incident->incident_status = $input['incident_status'];
        $incident->update();

        
        $data['message'] = 'Incident Status Updated!';
        
        
        
        return json_encode($data);
    }
}
