<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\SubCategories;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class SubCategoriesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subcategory = SubCategories::where('status',1);
        $getSubcategories = $subcategory->get();
        $dataArr = array();
        foreach($getSubcategories as $key => $data){
            $getCat = array();
            $subcategory = SubCategories::with('categories')->where('category_id',$data->category_id)->first();
           
            $subcategories['id'] = $data->id;   
            $subcategories['subcategory_name'] = $data->subcategory_name;   
            $subcategories['subcategory_description'] = $data->subcategory_description;  
            $subcategories['category_id'] = $data->category_id;
            $subcategories['category_name'] =$subcategory->categories[0]->category_name;
            array_push($dataArr,$subcategories);
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
        
        return view('catalog.subcategory.subcategories')->with('subcategories',$paginatedItems);
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
        $subcategory = SubCategories::where("status",1)->where('id',$id)->first();
        return view('catalog.subcategory.show')->with(["subcategories"=>$subcategory,"categories"=>$categories]);
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
        $subcategory = SubCategories::where("status",1)->where('id',$id)->first();
        return view('catalog.subcategory.edit')->with(["subcategories"=>$subcategory,"categories"=>$categories]);
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
        $subcategory = SubCategories::find($id);
        $subcategory->status = 0;
        $subcategory->update();

        if($subcategory->status == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
}
