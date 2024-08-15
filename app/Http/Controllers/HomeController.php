<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Categories;
use App\Subcategories;
use App\Logs;
use App\LogDetails;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Categories::where('status',1)->get();
        return view('home')->with('categories',$categories);
    }

    public function loadDataDashboard(Request $request){
         $qty_assigned = 0;
         $qty_dropped = 0;
         $total_cases_open = 0;
         $id = $request['category_id'];
         $date = $request['date'];
         $dateNow = Carbon::now()->format('Y-m-d');
         if($id == 0){
             
             if(empty($date)){
                $date = $dateNow;   
             }
             $total_cases_open = LogDetails::where('signature','Open')->where('created_at','like',$date.'%')->get()->count();
             $case_report_today = LogDetails::whereIn('signature',['Open','In Progress'])->where('created_at','like',$dateNow.'%')->get()->count();
         }else{
             if(empty($date)){
                $date = $dateNow;   
             }
             $total_cases_open = LogDetails::where('category_id',$id)->where('signature','Open')->where('created_at','like',$date.'%')->get()->count();
             
             $case_report_today = LogDetails::where('category_id',$id)->whereIn('signature',['Open','In Progress'])->where('created_at','like',$dateNow.'%')->get()->count();
         }
        
        
        
         return json_encode(['qty_assigned'=>$total_cases_open,'qty_dropped'=>$case_report_today]);
    }
    
    public function update(Request $request)
    {
        $user = User::get();
        foreach($user as $val){
            $val->qty_assigned =0;
            $val->update();
        }

        if($user){
            $data['message'] ="Successfully updated";
        }else{
            $data['message'] = "Failed to updated";
        }

        return json_encode($data);
          
    }
    
    public function test()
    {
        return view('test');
    }
}
