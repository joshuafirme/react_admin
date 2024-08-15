<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\LogDetails;
use App\Conversations;
use App\ConversationReplies;
use App\NumberVerifications;
use Validator;
use Notification;
use App\Notifications\EmailNotification;
use App\Friends;

class AuthController extends ResponseController
{
     //create user
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
           // 'username' => 'required|string|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $input = $request->all();
        $input['password'] = $input['password'];
        
        $user = User::create($input);

        $response = [];

        if($user){
            $response['token'] =  $user->createToken('token')->accessToken;
            $response['message'] = "Registration success!";
            $response['success'] = true;
            $response['id'] = $user->id;

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

            return $this->sendResponse($response);
        }
        else{
            $response['message'] = "Something went wrong. Please try again.";
            $response['success'] = false;
            return $this->sendResponse($response);
        }
        
    }
    
    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $credentials = request(['email', 'password']);

        $response = [];

        if(!Auth::attempt($credentials)){
            $response['success'] = false;
            $response['message'] = "Wrong username or password!";
            return $this->sendResponse($response);
        }
        $user = $request->user();
        $response['success'] =  true;
        $response['token'] =  $user->createToken('token')->accessToken;
        $response['id'] =  $user->id;
        $response['firstname'] =  $user->firstname;
        $response['email'] =  $user->email;
        
        $response['username'] =  $user->username;
        $response['fullname'] =  $user->firstname . ' ' . $user->lastname;
        return $this->sendResponse($response);
    }

    //logout
    public function logout(Request $request)
    {
        
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
            
        
    }

    //getuser
    public function getUser(Request $request)
    {
        //$id = $request->user()->id;
        $user = $request->user();
        if($user){
            return $this->sendResponse($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }
    
    public function getProfileByID($id)
    {
        $user = User::find($id);
        if($user){
            return $this->sendResponse($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }
    
    //get code sms
    public function getCodeSMS(Request $request){
        
        $input = $request->all();
        // Authorisation details.
        $apicode = "TR-ELMIG277091_LZ2FX";

        // Config variables. Consult http://api.txtlocal.com/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = urlencode('TXTLCL'); // This is who the message appears to be from.
        $number = $input['phone_number']; // A single number or a comma-seperated list of numbers
        $code = $this->generatePIN(4);
        
        $updateNum = NumberVerifications::where('phone_number',$number)->get();
        foreach($updateNum as $val){
            $val->verified = 1;
            $val->update();
        }
        
        $numberVerification = new NumberVerifications();
        $numberVerification->verification_code = $code;
        $numberVerification->verified = 0;
        $numberVerification->phone_number = $number;
        $numberVerification->save();
        $message = "Your OTP(One Time Password) is: " . $code;
        // 612 chars or less
        // A single number or a comma-seperated list of numbers
        $ch = curl_init();
//        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
//        curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
//        curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, 
//                  http_build_query($itexmo));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $result = curl_exec ($ch);
//        curl_close ($ch);
//        
//        return $result;
        if($code){
            $data['messageSuccess'] = "OTP has been sent to your mobile number";
            $data['verification_code'] = $code;
            return $this->sendResponse($data);
        }else{
            $data['messageError'] = "Invalid phone number";
            return $this->sendResponse($data);
        }
    }
    
    //get code email
    public function getCodeEmail(Request $request){
        
        $input = $request->all();
        
        $test = "0";

        $email = $input['email']; 
        $username = $input['username']; 
        
        $checkMail = User::where('email',$email)->first();
        $checkUsername = User::where('username',$username)->first();
        
        if(!empty($checkMail) || !empty($checkUsername)){
            $data['messageError'] = "Email/Username Already Exist!";
            return $this->sendResponse($data);
        }
        
        
        $code = $this->generatePIN(4);
        
        $updateNum = NumberVerifications::where('phone_number',$email)->get();
        foreach($updateNum as $val){
            $val->verified = 1;
            $val->update();
        }
        
        $numberVerification = new NumberVerifications();
        $numberVerification->verification_code = $code;
        $numberVerification->verified = 0;
        $numberVerification->phone_number = $email;
        $numberVerification->save();
        $message = "Your OTP(One Time Password) is: " . $code;
        
      
        
        $user = new User();
        $user->email = $email;
            
        $details = [
            'subject' => 'OFW App',
            'greeting' => 'One Time Password',
            'body' => $message,
            'thanks' => 'Thank you for using OFW App',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'notification_id' => 108
        ];

        Notification::route('mail', $email)
            ->route('nexmo', '5555555555')
            ->notify(new EmailNotification($details));
        
  
    
        
        if($code){
            $data['messageSuccess'] = "OTP has been sent to your mobile number";
            $data['verification_code'] = $code;
            return $this->sendResponse($data);
        }else{
            $data['messageError'] = "Failed to send";
            return $this->sendResponse($data);
        }
    }
    
    public function verifyNumber(Request $request){
        $input = $request->all();
        
        $verifyNum = NumberVerifications::where('verification_code',$input['verification_code'])->where('verified',0)->first();
        
        $data = array();
        
        
        if(!empty($verifyNum)){
            $verifyNum->verified = 1;
            $verifyNum->update();
            $data['messageSuccess'] = "Successfully verified";
            $data['verified'] = $verifyNum->verified;
            return $this->sendResponse($data);
        }else{
            $data['messageError'] = "Invalid code or code has been expired";
            return $this->sendResponse($data);
        }
        
        
    }
    
    public function uploadProfilePhoto(Request $request){
         $input = $request;
        $validation = Validator::make($request->all(), [
          'profile_photo' => 'required|max:20000'
         ]);
        
        if($validation->fails()){
            $error = "profile photo not found";
            return $this->sendResponse($error);
        }



        $image = $request->file('profile_photo');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/profilephotos/'), $new_name);

        $user = User::find($input['user_id_attachment']);
        $user->profile_photo = '/images/profilephotos/'. $new_name;
        $user->update();

        $return = array('message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success');

        return $this->sendResponse($return);
    }

    public function uploadReportFiles(Request $request){
        $input = $request;
       $validation = Validator::make($request->all(), [
         'attachment' => 'required|max:20000'
        ]);
       
       if($validation->fails()){
           $error = "image not found";
           return $this->sendResponse($error);
       }



       $image = $request->file('attachment');
       $new_name = rand() . '.' . $image->getClientOriginalExtension();
       $image->move(public_path('images/attachments/'), $new_name);

       $logdetails = LogDetails::find($input['incident_id_attachment']);
       $logdetails->attachment = '/images/attachments/'. $new_name;
       $logdetails->update();

       $return = array('message'   => 'Image Upload Successfully',
      'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
      'class_name'  => 'alert-success');

       return $this->sendResponse($return);
   }

   public function getReportById($id){
    $logdetails = LogDetails::with('agencies','categories')->find($id);
    

    return $this->sendResponse($logdetails);
   }
    
    public function generatePIN($digits = 4){
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while($i < $digits){
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
    
    public function check_user(Request $request)
    {
        
        $return = array();
        if (Auth::guard('api')->check()) {
            // Here you have access to $request->user() method that
            // contains the model of the currently authenticated user.
            //
            // Note that this method should only work if you call it
            // after an Auth::check(), because the user is set in the
            // request object by the auth component after a successful
            // authentication check/retrival
            $return['auth'] = true;
            $return['message'] = 'Authenticated user';
            return $this->sendResponse($return);
        }

        // alternative method
        if (($user = Auth::user()) !== null) {
            // Here you have your authenticated user model
            $return['auth'] = true;
            $return['message'] = 'Authenticated user';
            return $this->sendResponse($return);
        }

        // return general data
        $return['auth'] = false;
        $return['message'] = 'Unauthenticated user';
        return $this->sendResponse($return);
    }
    
    public function getAboutApp(){
        
        $about = "Test About App";
        
        return $this->sendResponse($about); 
    }

    public function getUsers(Request $request){
        
       $users = User::where('status', 1)->where('id','!=',$request['auth_id'])->get();
        
        return $this->sendResponse($users); 
    }
    
   
}
