<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Roles;
use App\Agencies;
use App\Subcategories;
use App\Conversations;
use App\ConversationReplies;
use App\LogDetails;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
      
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        }
        
        return redirect()->back();
    }
    
    public function register(Request $request)
    {
        User::create($request->all());
        
        $credentials = $request->only('email', 'password');
      
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        }
    }
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::where("status",1)->get();
        $agencies = Agencies::where("status",1)->get();
        $users = User::where("status",1)->paginate(15);
        return view('catalog.user.users',['users'=>$users,'roles'=>$roles,'agencies'=>$agencies]);
    }

    public function indexAdmin()
    {
        $users = User::where("status",1)->where('role_id','!=','4')->paginate(15);
        return view('catalog.user.users',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Roles::where("status",1)->get();
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.user.add')->with(["roles"=>$roles,"agencies"=>$agencies]);
    }

    public function createAdmin()
    {
        return view('catalog.user.add-admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'username' => 'required|unique:users',
                'employee_no' => 'required|unique:users',
                'agency_id' => 'required',
                'role_id' => 'required',
                'password' => 'required|min:8',
                'cpassword' => 'required|min:8|same:password',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $user = new User();
            $user->username = $input['username'];
            $user->employee_no = $input['employee_no'];
            $user->transaction_type = "";
            $user->firstname = "";
            $user->middlename = "";
            $user->lastname = "";
            $user->phone_number = "";
            $user->role_id = $input['role_id'];
            $user->agency_id = $input['agency_id'];   
            $user->status = 1;   
            $user->email = $input['username'] . "@thissite.com";
            $user->password = $input['password'];

            $user->save();
            
             #create conversation 1st user
            $convo = new Conversations();
            $convo->user_id_01 = $user->id;
            $convo->user_id_02 = 1;
            $convo->message = "";
            $convo->ip = "127.0.0.1";
            $convo->save();


            #create first conversation reply 1st user
            $fullname = $user['firstname'] . " " . $user['lastname'];
            $convoReply = new ConversationReplies();
            $convoReply->reply = 'You are connected now with the administrator';
            $convoReply->user_id_fk = $convo->user_id_01;
            $convoReply->ip = '127.0.0.1'; 
            $convoReply->c_id_fk = $convo->id;
            $convoReply->save();

            if($user){
                $data['message'] ="Successfully registered";
            }else{
                $data['message'] = "Failed to register";
            }
            
            return json_encode($data);
            
        }
        
        $messages = $validator->messages();
        return json_encode($messages);
    }

    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'username' => 'required|unique:users',
                'employee_no' => 'required|unique:users',
                'password' => 'required|min:8',
                'cpassword' => 'required|min:8|same:password',
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $user = new User();
            $user->username = $input['username'];
            $user->firstname = $input['employee_no'];
            $user->middlename = "";
            $user->lastname = "";
            $user->phone_number = "";
            $user->role_id = 2;
            $user->agency_id = 0;     
            $user->status = 1;      
            $user->email = $input['username'] . "@fhexpress.com";
            $user->password = $input['password'];

            $user->save();

            if($user){
                $data['message'] ="Successfully registered";
            }else{
                $data['message'] = "Failed to register";
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
        $user = User::find($id);
        $roles = Roles::where("status",1)->get();
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.user.show')->with(['user'=>$user,"roles"=>$roles,"agencies"=>$agencies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Roles::where("status",1)->get();
        $agencies = Agencies::where("status",1)->get();
        return view('catalog.user.edit')->with(['user'=>$user,"roles"=>$roles,"agencies"=>$agencies]);
    }

    public function updateQtyAssigned(Request $request){
        $id = $request['id'];
        $user = User::find($id);
        $user->role_id = $request['role_id'];
        $user->agency_id = $request['agency_id'];
        $user->update();
       
        $data['message'] = 'Successfully updated!';
        
        
        return json_encode($data);
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
                'username' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'role_id' => 'required',
                'agency_id' => 'required',
                'password' => 'required|min:8',
                'phone_number' => 'required|min:8',
                'cpassword' => 'required|min:8|same:password',
                'email' => 'required|email'
            ]
        );
        
        if(!$validator->fails()){
            
            $input = $request->all();
            $user = User::find($input['id']);
            $user->username = $input['username'];
            $user->firstname = $input['firstname'];
            $user->middlename = $input['middlename'];
            $user->lastname = $input['lastname'];
            $user->phone_number = $input['phone_number'];

            $user->role_id = $input['role_id'];

            $user->agency_id = $input['agency_id'];        
            $user->email = $input['email'];
            $user->password = $input['password'];

            $user->update();

            if($user){
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
        $user = User::find($id);
        $user->status = 0;
        $user->update();

        if($user->status     == 0){
            $data['message'] = 'Successfully deleted!';
        }
        
        
        return json_encode($data);
    }
    
     /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function updateApi(Request $request)
    {
        $token = Str::random(60);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email',$email)->where('password',Hash::make($password))->first();
        
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }
    
    public function test()
    {
        $user = User::find(3);
        $return = array();
        foreach ($user->notifications as $notification) {
            $notif_from = User::find($notification->data['notif_from']);
            $notif_to = User::find($notification->data['notif_to']);
            
            $data['notif_from'] = $notif_from['firstname'] . " " . $notif_from['lastname'];
            $data['notif_to'] = $notif_to['firstname'] . " " . $notif_to['lastname'];
            $data['notif_message'] = "You got notification from " . $data['notif_from'];
            array_push($return,$data);
        }
        
        return $return;
    }
}
