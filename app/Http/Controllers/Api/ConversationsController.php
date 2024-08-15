<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Friends;
use App\NumberVerifications;
use Validator;
use App\Notifications\AllNotifications;
use Pusher\Pusher;
use App\Conversations;
use App\ConversationReplies;
use Carbon\Carbon;

class ConversationsController extends ResponseController
{
    
    public function sendNotification(){
        //Remember to change this with your cluster name.
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

        $message= "Hello Cloudways";

        //Send a message to notify channel with an event name of notify-event
        $pusher->trigger('friend-request-sent', 'notification-event', $message);
    }
    
    public function getConversationsByUserId(Request $request){
        
        $input = $request;
        $id = $input['user_id'];
        $userData = array();
        $user = Conversations::where('user_id_01',$id)->get();
        $isConversationIDExist = array();
        
        foreach($user as $n){
            $get_user = User::find($n->user_id_02);
            
            $data['id'] = $get_user->id;
            $data['conversation_id'] = $n->id;
            $data['username'] = $get_user->username;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            
            $data['message'] = "View Message";
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            $data['updated_at'] =  date('d-m-Y', strtotime($n->updated_at)); 
            array_push($userData,$data);
            array_push($isConversationIDExist,$n->id);
         
        }
        
        $user = Conversations::where('user_id_02',$id)->get();
        foreach($user as $n){
            $get_user = User::find($n->user_id_01);
            if(in_array($n->id,$isConversationIDExist)){
                continue;
            }
            $data['id'] = $get_user->id;
            $data['conversation_id'] = $n->id;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            
            $data['message'] = "View Message";
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            $data['updated_at'] =  date('d-m-Y', strtotime($n->updated_at)); 
            array_push($userData,$data);
         
        }
        
        return $this->sendResponse($userData); 
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

        
        return $this->sendResponse($userData); 
    }
    
    public function getFriendsByUserId(Request $request){
        $input = $request;
        $id = $input['auth_id'];
        $user = User::find($id);
        $userData = array();
        $Accepted = $user->friendsOfMine()->get(); 
        foreach($Accepted as $n){
            $get_user = User::find($n->pivot['user_id_02']);
            
            $data['id'] = $get_user->id;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            $data['accept_status'] = $n->pivot['action_user_id'];
            array_push($userData,$data);
         
        }
        
        return $this->sendResponse($userData); 
    }
    
    public function getNotificationByUserId($id){
        $user = User::find($id);
        $return = array();
        foreach ($user->notifications as $notification) {
            $notif_from = User::find($notification->data['notif_from']);
            $notif_to = User::find($notification->data['notif_to']);
            
            $data['notif_from'] = $notif_from['firstname'] . " " . $notif_from['lastname'];
            $data['notif_to'] = $notif_to['firstname'] . " " . $notif_to['lastname'];
            $data['notif_message'] = "You got friend request from " . $data['notif_from'];
            $data['read_at'] = $notification->read_at;
            $data['notif_type'] = $notification->data['notif_type'];
            array_push($return,$data);
        }
        
        return $this->sendResponse($return); 
    }
    
     public function searchUsers(Request $request){
        
        $input = $request;
        $userData = array();
        $sentRequest = array();
        $getUserId = array();
        
        if(empty($input['query'])){
            $error['message'] = "No results found";
            return $this->sendResponse($error); 
        }
        $users = User::whereLike(['firstname', 'middlename', 'lastname'], $input['query'])->where('role_id',3)->where('status',1)->get();
        foreach($users as $u){
            array_push($getUserId,$u->id);
        }
        
        $authUser = User::find($input['auth_id']);
        $notAccepted = $authUser->notYetAcceptFriend()->get(); 
        
        $friendsAdded = $authUser->friendsOfMine()->get(); 
        $pendingRequest = $authUser->pendingRequest()->get(); 
        
        foreach($friendsAdded as $x_check){
            if(in_array($x_check->pivot['user_id_02'],$getUserId)){
                array_push($sentRequest,$x_check->pivot['user_id_02']);
            }
        } 
         
        foreach($pendingRequest as $x_check){
            if(in_array($x_check->pivot['user_id_01'],$getUserId)){
                array_push($sentRequest,$x_check->pivot['user_id_01']);
            }
        } 
        
        foreach($notAccepted as $n){
            if(in_array($n->pivot['user_id_02'],$getUserId)){
                    $get_user = User::find($n->pivot['user_id_02']);
                    if($get_user->id ==  $input['auth_id'])
                        continue;
                        
                    $data['id'] = $get_user->id;
                    $data['firstname'] = $get_user->firstname;
                    $data['middlename'] = $get_user->middlename;
                    $data['lastname'] = $get_user->lastname;
                    $data['email'] = $get_user->email;
                    $data['username'] = $get_user->username;
                    $data['profile_photo'] = $get_user->profile_photo;
                    $data['accept_status'] = $n->pivot['action_user_id'];
                    array_push($userData,$data);
                    array_push($sentRequest,$get_user->id);
            }
        }
         
        foreach($users as $user){
            if(!in_array($user->id,$sentRequest)){
                
                if($user->id ==  $input['auth_id'])
                        continue;
                
                
                $data['id'] = $user->id;
                $data['firstname'] = $user->firstname;
                $data['middlename'] = $user->middlename;
                $data['lastname'] = $user->lastname;
                $data['email'] = $user->email;
                $data['username'] = $user->username;
                $data['profile_photo'] = $user->profile_photo;
                $data['accept_status'] = 9;
                array_push($userData,$data);        
            }
        }
         
        if(count($userData) < 1){
            $error['message'] = "No results found";
            return $this->sendResponse($error); 
        }
         
        return $this->sendResponse($userData); 
    }
    
    public function sendRequest(Request $request){
        
        $input = $request;
        
        $checkIfExist = Friends::where('user_id_01',$input['auth_id'])->where('user_id_02',$input['user_id'])->get();
        
        $countExist = count($checkIfExist);
        
        if($countExist > 0){
            $success['message'] = "Something went wrong!";
            return $this->sendResponse($success); 
        }
            
        
        $friends = new Friends();
        $friends->user_id_01 = $input['auth_id'];
        $friends->user_id_02 = $input['user_id'];
        $friends->status = 0;
        $friends->action_user_id = 0;
        $friends->save();
        
        
        if(!empty($friends)){
            $success['message'] = "Friend request sent!";
            
            $user = User::find($input['auth_id']);
            
            $sent_to_user = User::find($input['user_id']);
             // add this to send a notification
            $sent_to_user->sendClientAddedNotification($friends); 
            
            //Remember to change this with your cluster name.
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

            $data['auth_id'] = $input['user_id'];
            $data['sent_by'] = $input['auth_id'];
            $fullname = $user['firstname'] . " " . $user['lastname'];
            $data['message'] = $fullname . " has sent you a friend request";

            //Send a message to notify channel with an event name of friend-request-sent
            $pusher->trigger('friend-request-sent', 'notification-event', json_encode($data));
            $pusher->trigger('pending-request', 'pending-request-event', json_encode($data));
        }else{
            $success['message'] = "Something went wrong!";
        }
        
        return $this->sendResponse($success); 
    }
    
    public function getPendingRequest(Request $request){
        $input = $request;
        $userData = array();
        
        if(empty($input['auth_id'])){
            $error['message'] = "No results found";
            return $this->sendResponse($error); 
        }
     
        
        $authUser = User::find($input['auth_id']);
        $pendingRequest = $authUser->pendingRequest()->get(); 
        
        if(count($pendingRequest) < 1){
            $error['message'] = "";
            return $this->sendResponse($error); 
            
        }
        foreach($pendingRequest as $n){
            
            $get_user = User::find($n->pivot['user_id_01']);
            
            $data['id'] = $get_user->id;
            $data['firstname'] = $get_user->firstname;
            $data['middlename'] = $get_user->middlename;
            $data['lastname'] = $get_user->lastname;
            $data['email'] = $get_user->email;
            $data['username'] = $get_user->username;
            $data['profile_photo'] = $get_user->profile_photo;
            $data['accept_status'] = $n->pivot['action_user_id'];
            array_push($userData,$data);
        }
        
        return $this->sendResponse($userData); 
    }
    
    public function acceptRequest(Request $request){
        
        $input = $request;
        $friends = Friends::where('user_id_01',$input['user_id'])->where('user_id_02',$input['auth_id'])->first();
        $friends->action_user_id = 1;
        $friends->status = 1;
        $friends->update();
        
        if($friends){
            $acceptedFR = new Friends();
            $acceptedFR->user_id_01 = $input['auth_id'];
            $acceptedFR->user_id_02 = $input['user_id'];
            $acceptedFR->status = 1;
            $acceptedFR->action_user_id = 1;
            $acceptedFR->save();
        }
        
        
        $user = User::find($input['user_id']);
        $sent_to_user = User::find($input['auth_id']);
        
        
        #create conversation 1st user
        $convo = new Conversations();
        $convo->user_id_01 = $input['auth_id'];
        $convo->user_id_02 = $input['user_id'];
        $convo->ip = "127.0.0.1";
        $convo->save();
        
        
        #create first conversation reply 1st user
        $fullname = $user['firstname'] . " " . $user['lastname'];
        $convoReply = new ConversationReplies();
        $convoReply->reply = 'You are connected now with ' . $fullname;
        $convoReply->user_id_fk = $convo->user_id_01;
        $convoReply->ip = '127.0.0.1'; 
        $convoReply->c_id_fk = $convo->id;
        
        
        
        $success['message'] = "Friend request accepted!";
        
        //Remember to change this with your cluster name.
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
        
         // add this to send a notification
        $sent_to_user->sendClientAddedNotification($friends); 

        
        $data['auth_id'] = $input['auth_id'];
        $data['sent_by'] = $input['user_id'];
       
        $data['message'] = $fullname . " accept your friend request";
        //Send a message to notify channel with an event name of friend-request-sent
        $pusher->trigger('accept-request-sent', 'accept-request-event', json_encode($data));
        
        
        return $this->sendResponse($success); 
        
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
        
        
        return $this->sendResponse($success); 
        
    }
    
     public function deleteReply(Request $request){
        
        $input = $request;
        
        #create first conversation reply 1st user
        $convoReply = ConversationReplies::find($input['id']);
        $convoReply->delete();
        
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
        
         // add this to send a notification
        $sent_to_user->sendClientAddedNotification($friends); 

        
        $success['message'] = "Reply sent";
         
        $data['auth_id'] = $input['auth_id'];
        $data['new_reply'] = 1;
        //Send a message to notify channel with an event name of friend-request-sent
        $pusher->trigger('reply-sent', 'reply-sent-event', json_encode($data));
        
        
        return $this->sendResponse($success); 
        
    }
    
    public function checkIfTyping($id){
        
        //Remember to change this with your cluster name.
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

        //Send a message to notify channel with an event name of friend-request-sent
        $pusher->trigger('check-if-typing', 'check-if-typing-event', json_encode($id));
        
        return $this->sendResponse($success); 
    }
}
