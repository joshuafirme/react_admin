<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\NumberVerifications;
use Validator;
use App\Notifications\AllNotifications;
use Pusher\Pusher;
use App\Conversations;
use App\ConversationReplies;
use Carbon\Carbon;



class ConversationsController extends Controller
{
    public function index(Request $request)
    {
        $input = $request;
        $id = Auth::user()->id;
        $userData = array();
        $user = Conversations::where('user_id_01',$id)->get();
        $isConversationIDExist = array();
        
        foreach($user as $n){
            $get_user = User::find($n->user_id_02);
            $getLastMessage = ConversationReplies::where('c_id_fk',$n->id)->orderBy('id','ASC')->first();
            $data['id'] = $get_user->id;
            $data['conversation_id'] = $n->id;
            $data['username'] = $get_user->username;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            
            $data['message'] = $getLastMessage['reply'];
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            $data['created_at'] =  date('M d Y', strtotime($n->created_at)); 
            $data['updated_at'] =  date('M d Y', strtotime($n->updated_at)); 
            array_push($userData,$data);
            array_push($isConversationIDExist,$n->id);
         
        }
        
        $user = Conversations::where('user_id_02',$id)->get();
        foreach($user as $n){
            $get_user = User::find($n->user_id_01);
            $getLastMessage = ConversationReplies::where('c_id_fk',$n->id)->orderBy('id','DESC')->first();
            if(in_array($n->id,$isConversationIDExist)){
                continue;
            }
            $data['id'] = $get_user->id;
            $data['conversation_id'] = $n->id;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            
            $data['message'] = isset($getLastMessage['reply']) ? $getLastMessage['reply'] : ' ';
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            
            $data['created_at'] =  date('M d Y', strtotime($n->created_at)); 
            $data['updated_at'] =  date('M d Y', strtotime($n->updated_at)); 
            array_push($userData,$data);
         
        }
        
        return view('catalog.messaging.messages')->with('messages',$userData);
    }

    public function getConversationById(Request $request){
        
        $input = $request;
        $id = $input['conversation_id'];
        $last_id = $input['last_id'];
        $userData = array();
        $last_load_id = 0;
        if(!empty($last_id) && $last_id != 0){
            $conversation = ConversationReplies::where('c_id_fk',$id)->where('id','<',$last_id)->orderBy('id','DESC')->take(10)->get();
        }else{
            $conversation = ConversationReplies::where('c_id_fk',$id)->orderBy('id','DESC')->take(10)->get();
        }
        
        $userData = array();
         
        foreach($conversation as $n){
            $get_user = User::find($n->user_id_fk);
            
            $data['user_id'] = $get_user->id;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            $data['username'] = $get_user->username;
            $data['reply'] = $n->reply;
            $data['conversation_id'] = $n->id;
            $data['created_at'] = $n->created_at;
            $data['user_id_fk'] = $n->user_id_fk;
            $data['profile_photo'] = $get_user->profile_photo;
            array_push($userData,$data);
            $last_load_id = $n->id;
            
        }

        
        return json_encode($userData); 
    }

    public function addReply(Request $request){
        
        $input = $request;
        
        $getConversation = Conversations::find($input['conversation_id']);
        
        #create first conversation reply 1st user
        $convoReply = new ConversationReplies();
        $convoReply->reply = $input['message'];
        $convoReply->user_id_fk = $input['auth_id'];
        $convoReply->ip = '127.0.0.1'; 
        $convoReply->c_id_fk = $input['conversation_id'];
        $convoReply->save();
        //Remember to change this with your cluster name3.
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        //Remember to set your credentials below.
        $pusher = new Pusher(
            '727ae9a0b76b78743c14',
            'a876a6ef4056200cbe82',
            '976615', $options
        );
        
        
        $success['message'] = "Reply sent";
        
        $data['auth_id'] = $input['auth_id'];
        $data['conversation_id'] = $input['conversation_id'];
        $user = User::find($input['auth_id']);
        $data['sent_from_name'] = $user->firstname . ' ' . $user->lastname;
        $data['sent_to'] = $getConversation->user_id_01 == $input['auth_id'] ? $getConversation->user_id_02 : $getConversation->user_id_01;
        $data['new_reply'] = 1;
        $data['message'] = $input['message'];
        //Send a message to notify channel with an event name of friend-request-sent
        $pusher->trigger('reply-sent', 'reply-sent-event', json_encode($data));
        
        
        return json_encode($success); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    
}
