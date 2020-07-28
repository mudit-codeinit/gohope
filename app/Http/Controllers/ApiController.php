<?php 
namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\HelpRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Use Exception;
//require 'PHPMailer-master/src/Exception.php';
//require 'PHPMailer-master/src/PHPMailer.php';
//require 'PHPMailer-master/src/SMTP.php';

class ApiController extends Controller
{
	
	
	public function social_login(Request $request){
		$first_name = $request->first_name;
		if($request->last_name){
			$last_name = $request->last_name;
		}else{
			$last_name = "";
		}
		$login_type = 'manual';
		$social_login_id = "";
		
		
		
		if($request->login_type && $request->social_login_id){
			$login_type = $request->login_type;
			$social_login_id = $request->social_login_id;
			$device_token = $request->device_token;

			$userexists = DB::table('users')->where('login_type',$login_type)->where('social_login_id',$social_login_id)->first();
			if($userexists){
			
				$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Registered Successfully","data"=>array("first_name"=>$userexists->first_name, "last_name"=>$userexists->last_name,"email"=>$userexists->email,"phone_number"=>$userexists->mobile,"role"=>$userexists->userrole,"user_id"=>$userexists->id,'device_token'=>$device_token));
				$response = json_encode($response);
				return $response;
			
			}
			else{
			

				$phone_number = $request->phone_number;
				$email = $request->email;
				$password = $request->password;
				$role = strtolower($request->role);
				$emailexists = DB::table('users')->where('email',$email)->first();
				if(!$emailexists){
					$roles = DB::table('roles')->where('name',$role)->first();
					$User = new User;
					if($first_name){
						$User->first_name = $first_name;
					}
					if($last_name){
						$User->last_name = $last_name;
					}
					if($email){
						$User->email = $email;
					}
					$User->show_pass = $password;
					$User->password = Hash::make($password);
					if($phone_number){
						$User->mobile = $phone_number;
					}
					$User->userrole = $roles->id;
					$User->status = 'active';
					$User->login_type = $login_type ;
					$User->social_login_id = $social_login_id ;
					$User->device_token =$device_token;
					$User->user_status = 1;
					if($first_name && $last_name){
						$User->uname = $first_name.$last_name;
					}else{
						$User->uname = '';
					}
					$User->save();
					$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Registered Successfully","data"=>array("first_name"=>$request->first_name, "last_name"=>$last_name,"email"=>$request->email,"phone_number"=>$request->phone_number,"role"=>$request->role,"user_id"=>$User->id,"device_token"=>$User->device_token));
					$response = json_encode($response);
					return $response;
				}else{
					$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Email Already exists, Please try with another email address");
					$response = json_encode($response);
					return $response; 
				}
			}
		}
	}
	public function login(Request $request){
		$email = $request->email;
		$password = $request->password;
		$device_token = $request->device_token;
		$user = DB::table('users')->where('email',$email)->where('show_pass',$password)->first();
		if($user){
			$role = DB::table('roles')->where('id',$user->userrole)->first();
			$data['email'] = $user->email;
			$data['first_name'] = $user->first_name;
			$data['last_name'] = $user->last_name;
			$data['phone_name'] = $user->mobile;
			$data['role'] = ucfirst($role->name);
			$data['user_id'] = $user->id;
			$Request = User::findOrFail($user->id);
			$Request->device_token = $request->device_token;
			$Request->save();
			
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Logged in successfully","data"=>$data);
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Please check the information you have entered");
			$response = json_encode($response);
			return $response;
		}
	}
	public function signup(Request $request){
		$first_name = $request->first_name;
		if($request->last_name){
			$last_name = $request->last_name;
		}else{
			$last_name = "";
		}
		$phone_number = $request->phone_number;
		$email = $request->email;
		$password = $request->password;
		$role = strtolower($request->role);
		$emailexists = DB::table('users')->where('email',$email)->first();
		if(!$emailexists){
			$roles = DB::table('roles')->where('name',$role)->first();
			$User = new User;			
			$User->first_name = $first_name;
			$User->last_name = $last_name;
			$User->email = $email;
			$User->show_pass = $password;
			$User->password = Hash::make($password);
			$User->mobile = $phone_number;
			$User->userrole = $roles->id;
			$User->status = 'active';
			$User->user_status = 1;
			$User->login_type = 'manual';
			$User->uname = $first_name.$last_name;
			$User->save();
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Registered Successfully","data"=>array("first_name"=>$request->first_name, "last_name"=>$last_name,"email"=>$request->email,"phone_number"=>$request->phone_number,"role"=>$request->role,"user_id"=>$User->id));
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Email Already exists, Please try with another email address");
			$response = json_encode($response);
			return $response; 
		}
	}
	
	public function forgotpassword(Request $request){
		$email = $request->email;
		$emailexists = DB::table('users')->where('email',$email)->first();
		if($emailexists){
			$user_id = $emailexists->id;
			$pass= rand(100,100000);
		
			$password = Hash::make($pass);
			$user = DB::table('users')
            ->where('email',$email)
            ->update(['password' => $password, "show_pass"=>$pass]);
			if($user){
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Mailer = "smtp";
				$mail->SMTPDebug  = 1;  
				$mail->SMTPAuth   = TRUE;
				$mail->SMTPSecure = "tls";
				$mail->Port       = 587;
				$mail->Host       = "smtp.gmail.com";
				$mail->Username   = "gohopeforapp@gmail.com";
				$mail->Password   = "admin#240";
				$mail->IsHTML(true);
				$mail->AddAddress($email);
				$mail->SetFrom("gohopeforapp@gmail.com", "Gohope");
				//$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
				//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
				$mail->Subject = "Forgot password (Gohope)";
				$content = "Hello,<br> This is your temporary password please change your password after logging in..  Password: ".$pass;
				$mail->MsgHTML($content); 
				if(!$mail->Send()){
				 $response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Message not sent");
				$response = json_encode($response);
				return $response;
				}else{
				  $response = array('Status'=>'success', 'Code'=>200,"Message"=>"Message sent successfully");
				$response = json_encode($response);
				return $response;
				}
				
				
			}else{
				$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Message Not Sent, Please try again later");
				$response = json_encode($response);
				return $response;
			}
		}else{
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Email not exists, Please try with another email address");
			$response = json_encode($response);
			return $response; 
		}
	}
	public function changepassword(Request $request){
		$user_id = $request->user_id;
		$opwd = $request->old_password;
		$npwd = $request->new_password;
		$cpwd = $request->confirm_password; 
		$user = DB::table('users')->where('id',$user_id)->first();
		if($npwd != $cpwd ){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Password Doesn't Matched");
			$response = json_encode($response);
			return $response;
		}elseif($user->show_pass != $opwd){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Your Old Password is not correct");
			$response = json_encode($response);
			return $response;
		}else{
			$password = Hash::make($npwd ); 
			$user = DB::table('users')->where('id',$user_id)->update(['password' => $password, "show_pass"=>$npwd ]);
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Password has been changed successfully");
			$response = json_encode($response);
			return $response; 	 
		}
	}
	public function pickup_request(Request $request){
		$Request = new HelpRequest;
		$photo = $request->photo;
		$file_name = "";
		if($request->hasFile('photo')){	
			$file = $request->file('photo');
			if(!empty($file)){
			$path = public_path() . '/admin_assets/img/';
			$file_name = time().'.'.$file->getClientOriginalExtension();
			// $file_name =   $file->getClientOriginalName());
			// $file_url = $path.$file_name;
			$file->move($path, $file_name);
			}else{
				$file_name = "default.png";
			}
		}
		$Request->created_by = $request->user_id;
		$Request->photo = $file_name;
		$Request->name = $request->name;
		$Request->description = $request->description; 
		$Request->bags = $request->bags; 
		$Request->male = $request->male; 
		$Request->female = $request->female; 
		$Request->kids = $request->kids; 
		$Request->pets = $request->pets; 
		$Request->lat = $request->lat; 
		$Request->add_long = $request->add_long; 
		$Request->street_address = $request->street_address; 
		$Request->city = $request->city; 
		$Request->other_notes = $request->other_notes; 
		$Request->assigned_driver = 10; 
		$Request->save();
		$driver = DB::table('users')->where('id',10)->first();
		
		$message = "New Pickup Request Generated";
		if(isset($driver->device_token) && !empty($driver->device_token) )
		push_driver_notification_android($driver->device_token,$message);
		if($Request->id ){
			$pickup_data = DB::table('requests')->where('id',$Request->id)->first();
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Pickup request created successfully","data"=>$pickup_data);
			$response = json_encode($response);
			return $response; 	 
		}else{
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Pickup request not created");
			$response = json_encode($response);
			return $response;
		}
	}
	
	public function accept_reject_request(Request $request){
		$Request = HelpRequest::findOrFail($request->id);
		$Request->status = $request->status;
		$Request->cancel_reason = $request->cancel_reason;
		$Request->estimated_time = $request->estimated_time;
		if($request->status == 1){
			$Request->request_status = 2;
		}
		$a_req = DB::table('requests')->where('assigned_driver',10)->where('request_status',2)->first();
		if($a_req){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"You have already active request. Please complete active request first");
			$response = json_encode($response);
			return $response;
		}
		$Request->save();
		$user = DB::table('users')->where('id',$Request->created_by)->first();
		$message = "Pickup request has been ";
		if($request->status == 1){
			$message .= "Accepted";
		}else{
			$message .= "Cancelled";
		}
		if(isset($user->device_token) && !empty($user->device_token) )
		push_repoter_notification_android($user->device_token,$message ); 
		
		if($Request->status == 0){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Request has been cancelled by the driver","data"=>array("cancel_reason"=> $request->cancel_reason));
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Pickup request has been accepted","data"=>array("estimated_time"=> $request->estimated_time));
			$response = json_encode($response);
			return $response;
		}
		
		
	}
	public function get_pickup_details(Request $request){
		 
		  $data = DB::table('requests')
		  ->select('id','estimated_time' , 'lat' , 'add_long','created_by')
		  ->where('created_by',$request->id)
		  ->where('request_status',2)
		  ->where('assigned_driver',10)
		  ->first();
		  if(isset($data->add_long) && !empty($data->add_long) && isset($data->lat) && !empty($data->lat)){
		  $data->address  = $this->get_pickup_address_from_lat_long($data->lat,$data->add_long);
		 
		if(!$data){
			$response = array('Status'=>'Failure', 'Code'=>400,"Message"=>"Pickup details not found");
			$response = json_encode($response); 
			return $response;
		}else{
			$response = array('Status'=>'Success', 'Code'=>200,"Message"=> 'Pickup details fetched successfully' , 'data' => $data );
			$response = json_encode($response);
			return $response;
		  }	}else{
			  $response = array('Status'=>'Failure', 'Code'=>400,"Message"=>"Lat/Long  not found");
			$response = json_encode($response); 
			return $response;
		  }
				
	}
	public function update_request_status(Request $request){
		$Request = HelpRequest::findOrFail($request->id);
		
		DB::table('requests')
            ->where('id',$request->id)
            ->update(['request_status' => $request->status , 'reason' => $request->reason ]);
		
		
		$user = DB::table('users')->where('id',$Request->created_by)->first();
		$message = "Pickup request has been ";
		if($request->status == 1){
			$message .= "Completed";
		}else{
			$message .= "Cancelled";
		}
		if(isset($user->device_token) && !empty($user->device_token) )
		push_repoter_notification_android($user->device_token,$message ); 
		
		if($Request->request_status == 0){
			$response = array('Status'=>'Failure', 'Code'=>400,"Message"=>$message,"data"=>array("reason"=> $request->reason));
			$response = json_encode($response); 
			return $response;
		}else{
			$response = array('Status'=>'Success', 'Code'=>400,"Message"=>$message,"data"=>array("reason"=> $request->reason));
			$response = json_encode($response);
			return $response;
		}		
	}
	public function assigned_requests(Request $request){ 
		$id =  $request->id;
		$p_requests = DB::table('requests')->where('assigned_driver',$id)->where('status', NULL)->orderBy('id', 'desc')->get();
		$p_req = [];
		$i = 0;
		foreach($p_requests as $p){
			$p_req[$i]['id'] = $p->id;
			$p_req[$i]['name'] = $p->name;
			$p_req[$i]['description'] = $p->description;
			$p_req[$i]['pets'] = $p->pets;
			$p_req[$i]['bags'] = $p->bags;
			$p_req[$i]['male'] = $p->male;
			$p_req[$i]['female'] = $p->female;
			$p_req[$i]['kids'] = $p->kids;
			$p_req[$i]['street_address'] = $p->street_address;
			$p_req[$i]['city'] = $p->city;
			$p_req[$i]['other_notes'] = $p->other_notes;
			$p_req[$i]['lat'] = $p->lat;
			$p_req[$i]['long'] = $p->add_long;
			$p_req[$i]['created_by'] = $p->created_by;
			$p_req[$i]['photo'] = 'http://3.6.109.8/gohope/public/admin_assets/img/'.$p->photo;
			$p_req[$i]['status'] = $p->status;
			$p_req[$i]['assigned_driver'] = $p->assigned_driver;
			$p_req[$i]['cancel_reason'] = $p->cancel_reason;
			$p_req[$i]['estimated_time'] = $p->estimated_time;
			$p_req[$i]['request_status'] = $p->request_status;
			$p_req[$i]['reason'] = $p->reason;
			$i++;
		}
		
		$c_requests = DB::table('requests')->where('assigned_driver',$id)->where('status',0)->orderBy('id', 'desc')->get();
		$c_req = [];
		$i = 0;
		foreach($c_requests as $p){
			$c_req[$i]['id'] = $p->id;
			$c_req[$i]['name'] = $p->name;
			$c_req[$i]['description'] = $p->description;
			$c_req[$i]['pets'] = $p->pets;
			$c_req[$i]['bags'] = $p->bags;
			$c_req[$i]['male'] = $p->male;
			$c_req[$i]['female'] = $p->female;
			$c_req[$i]['kids'] = $p->kids;
			$c_req[$i]['street_address'] = $p->street_address;
			$c_req[$i]['city'] = $p->city;
			$c_req[$i]['other_notes'] = $p->other_notes;
			$c_req[$i]['lat'] = $p->lat;
			$c_req[$i]['long'] = $p->add_long;
			$c_req[$i]['created_by'] = $p->created_by;
			$c_req[$i]['photo'] = 'http://3.6.109.8/gohope/public/admin_assets/img/'.$p->photo;
			$c_req[$i]['status'] = $p->status;
			$c_req[$i]['assigned_driver'] = $p->assigned_driver;
			$c_req[$i]['cancel_reason'] = $p->cancel_reason;
			$c_req[$i]['estimated_time'] = $p->estimated_time;
			$c_req[$i]['request_status'] = $p->request_status;
			$c_req[$i]['reason'] = $p->reason;
			$i++;
		}
		$a_requests = DB::table('requests')->where('assigned_driver',$id)->where('request_status', '=', 2)->orderBy('id', 'desc')->get();
		$a_req = [];
		$i = 0;
		foreach($a_requests as $p){
			$a_req[$i]['id'] = $p->id;
			$a_req[$i]['name'] = $p->name;
			$a_req[$i]['description'] = $p->description;
			$a_req[$i]['pets'] = $p->pets;
			$a_req[$i]['bags'] = $p->bags;
			$a_req[$i]['male'] = $p->male;
			$a_req[$i]['female'] = $p->female;
			$a_req[$i]['kids'] = $p->kids;
			$a_req[$i]['street_address'] = $p->street_address;
			$a_req[$i]['city'] = $p->city;
			$a_req[$i]['other_notes'] = $p->other_notes;
			$a_req[$i]['lat'] = $p->lat;
			$a_req[$i]['long'] = $p->add_long;
			$a_req[$i]['created_by'] = $p->created_by;
			$a_req[$i]['photo'] = 'http://3.6.109.8/gohope/public/admin_assets/img/'.$p->photo;
			$a_req[$i]['status'] = $p->status;
			$a_req[$i]['assigned_driver'] = $p->assigned_driver;
			$a_req[$i]['cancel_reason'] = $p->cancel_reason;
			$a_req[$i]['estimated_time'] = $p->estimated_time;
			$a_req[$i]['request_status'] = $p->request_status;
			$a_req[$i]['reason'] = $p->reason;
			$i++;
		}
		$cl_requests = DB::table('requests')->where('assigned_driver',$id)->where('request_status', '=', 1)->orderBy('id', 'desc')->get();
		$cl_req = [];
		$i = 0;
		foreach($cl_requests as $p){
			$cl_req[$i]['id'] = $p->id;
			$cl_req[$i]['name'] = $p->name;
			$cl_req[$i]['description'] = $p->description;
			$cl_req[$i]['pets'] = $p->pets;
			$cl_req[$i]['bags'] = $p->bags;
			$cl_req[$i]['male'] = $p->male;
			$cl_req[$i]['female'] = $p->female;
			$cl_req[$i]['kids'] = $p->kids;
			$cl_req[$i]['street_address'] = $p->street_address;
			$cl_req[$i]['city'] = $p->city;
			$cl_req[$i]['other_notes'] = $p->other_notes;
			$cl_req[$i]['lat'] = $p->lat;
			$cl_req[$i]['long'] = $p->add_long;
			$cl_req[$i]['created_by'] = $p->created_by;
			$cl_req[$i]['photo'] = 'http://3.6.109.8/gohope/public/admin_assets/img/'.$p->photo;
			$cl_req[$i]['status'] = $p->status;
			$cl_req[$i]['assigned_driver'] = $p->assigned_driver;
			$cl_req[$i]['cancel_reason'] = $p->cancel_reason;
			$cl_req[$i]['estimated_time'] = $p->estimated_time;
			$cl_req[$i]['request_status'] = $p->request_status;
			$cl_req[$i]['reason'] = $p->reason;
			$i++;
		}
		if(!$p_req && !$c_req && $a_req){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"No Assigned Requests found");
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Fetched all assigned requests","data"=>["pending_requests"=>$p_req,'complete_requests'=>$cl_req,'active_requests'=>$a_req,"cancelled_requests"=>$c_req]);
			$response = json_encode($response);
			return $response;
		}
		
		
	}
	public function single_request(Request $request){ 
		$id =  $request->id;
		$requests = DB::table('requests')->where('id',$id)->get();
		if(!$requests){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Request doesn't exists");
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Fetched request Successfully","data"=>$requests);
			$response = json_encode($response);
			return $response;
		}
		
		
	}
	
	public function update_profile(Request $request){
		  try{
				 if($request->column == "password"){
					$password= Hash::make($request->column_value );
					$update_data = array( $request->column =>  $password , 'show_pass' => $request->column_value );
				 }else{
					$update_data = array( $request->column => $request->column_value);
				 }
		 
		
				$update = DB::table('users')
							->where('id',$request->id)
							->update($update_data);

						 
						$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Record updated Successfully");
						$response = json_encode($response);
						return $response;
						 
		 }catch(\Illuminate\Database\QueryException $e  ){
			 
			 
							$response = array('Status'=>'failure', 'Code'=>400,"Message"=> $e->getMessage());
							$response = json_encode($response);
							return $response;
						 
		 }
		
				
	}
	
	public function get_profile(Request $request){
		 
		
		$data = DB::table('users')
            		->where('id',$request->id)
           				 ->first();
		
		 if(!$data){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"User doesn't exists");
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Fetched profile Successfully", "data" => $data);
			$response = json_encode($response);
			return $response;
		}
				
	}
	
	 public function get_lat_long_from_address(Request $request){ 
			$address = $request->address ?: 'BTM 2nd Stage, Bengaluru, Karnataka 560076'; // Address
			$apiKey = 'AIzaSyA_jNaoLniF50aAyM-qWXu2d6i5-pCEmxc'; // Google maps now requires an API key.
			// Get JSON results from this request
			$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
			$geo = json_decode($geo, true); // Convert the JSON to an array

			if (isset($geo['status']) && ($geo['status'] == 'OK')) {
			$latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
			$longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
			$data = array('latitude' => $latitude , 'longitude' => $longitude);
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Lat/Long fetched Successfully", "data" => $data);
			$response = json_encode($response);
			return $response;
			}else{
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"Lat/long didn't Find , Please try another address");
			$response = json_encode($response);
 			return $response;
			}
	}
	 public function get_pickup_address_from_lat_long($lat , $long){ 
			//$lat = $request->lat;
			//$long = $request->long;
			
			$apiKey = 'AIzaSyA_jNaoLniF50aAyM-qWXu2d6i5-pCEmxc'; // Google maps now requires an API key.
			// Get JSON results from this request
 $geo = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=".$apiKey);
			$geo = json_decode($geo, true); // Convert the JSON to an array

			if (isset($geo['status']) && ($geo['status'] == 'OK')) {
				return $geo['results'][0]; // formatted_address
			}else{
				return "Address didn't Find , Please try another Lat/Long";
			} 
	}
		 public function get_address_from_lat_long(Request $request){ 
			 $lat = $request->lat;
			 $long = $request->long;
			
			$apiKey = 'AIzaSyA_jNaoLniF50aAyM-qWXu2d6i5-pCEmxc'; // Google maps now requires an API key.
			// Get JSON results from this request
 $geo = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=".$apiKey);
			$geo = json_decode($geo, true); // Convert the JSON to an array

			if (isset($geo['status']) && ($geo['status'] == 'OK')) {
				return $geo['results'][0]; // formatted_address
			}else{
				return "Address didn't Find , Please try another Lat/Long";
			} 
	} 
	public function get_estimated_time(Request $request){ 
			$user_id = $request->user_id;
			$data = DB::table('requests')
            		->where('created_by',$request->user_id)->where('request_status',2)
           				 ->first();
		
		 if(!$data){
			$response = array('Status'=>'failure', 'Code'=>400,"Message"=>"No active request for current user");
			$response = json_encode($response);
			return $response;
		}else{
			$response = array('Status'=>'success', 'Code'=>200,"Message"=>"Fetched Active Request Successfully", "data" => $data);
			$response = json_encode($response);
			return $response;
		}
			
	}
		
	public function push_notification(Request $request){ 
		  //API URL of FCM
		    $url = 'https://fcm.googleapis.com/fcm/send';

		    /*api_key available in:
		    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
			
		 $api_key = isset($request->api_key) && !empty($request->api_key) ? $request->api_key :'AAAAmgHa4eM:APA91bF0cMs1LiRD7TuF1YJHcUkR2nnrDWLaWde6z48f-al05jkEnBieEN_DhsHh4Yw_gBZ0rNU_OIxsynAi1s2ATR5hXHmOIpMxyv2MqcRhz5xtdgY9CLIj6nCNFC6TXZhpqC4CV0k9';
			 
		    
			
		 $message = isset($request->message) && !empty($request->message) ? $request->message :'this is a test';
		    $fields = array (
			'registration_ids' => array (
			     $request->device_token
			),
			'data' => array (
				"message" => $message
			)
		    );

		    //header includes Content type and api key
		    $headers = array(
			'Content-Type:application/json',
			'Authorization:key='.$api_key
		    );
				
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		    $result = curl_exec($ch);
		    if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		    }
		    curl_close($ch);
		    return $result;
		
		
	}
	
}
