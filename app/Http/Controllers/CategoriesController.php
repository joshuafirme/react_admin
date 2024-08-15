<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Agencies;
use Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::where('status',1)->paginate(15);
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.category.categories')->with(['categories'=>$categories,'agencies'=>$agencies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.category.add',['agencies'=>$agencies]);
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
                'category_name' => 'required',
                'category_description' => 'required'
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $category = new Categories();
            $category->category_name = $input['category_name'];
            $category->category_description = $input['category_description'];
            $category->code_color = $input['code_color'];
            $category->agency_id = $input['agency_id'];
            $category->status = 1;
            $category->save();

            if($category){
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
        $category = Categories::where("status",1)->first();
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.category.show')->with(["categories"=>$category,'agencies'=>$agencies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::where("status",1)->where('id',$id)->first();
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.category.edit')->with(["categories"=>$category,'agencies'=>$agencies]);
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
                'category_name' => 'required',
                'category_description' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $category = Categories::find($input['id']);
            $category->category_name = $input['category_name'];
            $category->category_description = $input['category_description'];
            $category->code_color = $input['code_color'];
            $category->agency_id = $input['agency_id'];
            
            $category->update();

            if($category){
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
        $category = Categories::find($id);
        $category->status = 0;
        $category->update();

        if($category->status == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
}
