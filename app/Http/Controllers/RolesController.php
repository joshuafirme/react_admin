<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::where('status',1)->paginate(15);
        return view('catalog.roles.roles')->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalog.roles.add');
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
                'role_name' => 'required',
                'role_description' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $role = new Roles();
            $role->role_name = $input['role_name'];
            $role->role_description = $input['role_description'];

            $role->save();

            if($role){
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
    public function show($id)
    {
        $roles = Roles::where("status",1)->where('id',$id)->first();
        return view('catalog.roles.show')->with(["roles"=>$roles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Roles::where("status",1)->where('id',$id)->first();
        return view('catalog.roles.edit')->with(["roles"=>$roles]);
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
                'role_name' => 'required',
                'role_description' => 'required',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $role = Roles::find($input['id']);
            $role->role_name = $input['role_name'];
            $role->role_description = $input['role_description'];

            $role->update();

            if($role){
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
        $role = Roles::find($id);
        $role->status = 0;
        $role->update();

        if($role->status     == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
}
