<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertisements;
use Validator;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    public $advertisement_type = array([
            'id'=> 1,
            'name'=>'Announcement'
        ],[
            'id'=> 2,
            'name'=>'Urgent'
        ],[
            'id'=> 3,
            'name'=>'Etc..'
        ]);
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisements::where('status',1)->paginate(15);
        return view('catalog.announcements.announcements')->with('advertisements',$advertisements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalog.announcements.add');
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
                'ads_name' => 'required',
                'ads_description' => 'required',
                'ads_email' => 'email|required',
                'ads_type' => 'required',
                'ads_url' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $advertisements = new Advertisements();
            $advertisements->ads_name = $input['ads_name'];
            $advertisements->ads_description = $input['ads_description'];
            $advertisements->ads_email = $input['ads_email'];
            $advertisements->ads_type = $input['ads_type'];
            $advertisements->ads_url = $input['ads_url'];
            $advertisements->ads_status = 1;
            $advertisements->date_registered = Carbon::now();
            $advertisements->status = 1;
            $advertisements->save();

            if($advertisements){
                $data['id'] = $advertisements->id;
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
        $advertisements = Advertisements::where("status",1)->where('id',$id)->first();
        return view('catalog.announcements.show')->with(["advertisements"=>$advertisements,"advertisement_type"=>$this->advertisement_type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisements = Advertisements::where("status",1)->where('id',$id)->first();
        return view('catalog.announcements.edit')->with(["advertisements"=>$advertisements,"advertisement_type"=>$this->advertisement_type]);
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
                'ads_name' => 'required',
                'ads_description' => 'required',
                'ads_email' => 'email|required',
                'ads_type' => 'required',
                'ads_url' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $advertisements = Advertisements::find($input['id']);
            $advertisements->ads_name = $input['ads_name'];
            $advertisements->ads_description = $input['ads_description'];
            $advertisements->ads_email = $input['ads_email'];
            $advertisements->ads_type = $input['ads_type'];
            $advertisements->ads_url = $input['ads_url'];
            $advertisements->ads_status = 1;
            $advertisements->date_registered = Carbon::now();
            $advertisements->status = 1;
            
            $advertisements->update();

            if($advertisements){
                $data['id'] = $advertisements->id;
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
        $advertisements = Advertisements::find($id);
        $advertisements->status = 0;
        $advertisements->update();

        if($advertisements->status == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
    
    public function uploadAnnouncementFiles(Request $request){
        $input = $request;
        $validation = Validator::make($request->all(), [
          'ads_img' => 'required|max:20000'
        ]);
        
        if($validation->fails()){
            $error = "report not found";
            return json_encode($error);
        }



        $image = $request->file('ads_img');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/advertisements'), $new_name);

        $advertisement = Advertisements::find($input['advertisement_id_attachment']);
        $advertisement->ads_img = '/images/advertisements/'. $new_name;
        $advertisement->update();

        $return = array('message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="/ofw_admin/public'.$advertisement->ads_img.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success',
       'ads_img' => 'http://lattehub.com/flying_high/public'.$advertisement->ads_img );

        return json_encode($return);
    }
}
