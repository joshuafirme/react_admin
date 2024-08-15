<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agencies;
use Validator;
use Carbon\Carbon;

class AgenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agencies = Agencies::where('status',1)->paginate(15);
        return view('catalog.agency.agencies')->with('agencies',$agencies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalog.agency.add');
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
                'agency_name' => 'required',
                'agency_description' => 'required',
                'agency_email' => 'email|required',
                'agency_type' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $agency = new Agencies();
            $agency->agency_name = $input['agency_name'];
            $agency->agency_description = $input['agency_description'];
            $agency->agency_email = $input['agency_email'];
            $agency->agency_type = $input['agency_type'];
            $agency->date_registered = Carbon::now();
            $agency->status = 1;
            $agency->save();

            if($agency){
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
        $agency = Agencies::where("status",1)->where('id',$id)->first();
        return view('catalog.agency.show')->with(["agencies"=>$agency]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agency = Agencies::where("status",1)->where('id',$id)->first();
        return view('catalog.agency.edit')->with(["agencies"=>$agency]);
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
                'agency_name' => 'required',
                'agency_description' => 'required',
                'agency_email' => 'email|required',
                'agency_type' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $agency = Agencies::find($input['id']);
            $agency->agency_name = $input['agency_name'];
            $agency->agency_description = $input['agency_description'];
            $agency->agency_email = $input['agency_email'];
            $agency->agency_type = $input['agency_type'];
            $agency->date_registered = Carbon::now();
            
            $agency->update();

            if($agency){
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
        $agency = Agencies::find($id);
        $agency->status = 0;
        $agency->update();

        if($agency->status == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
}
