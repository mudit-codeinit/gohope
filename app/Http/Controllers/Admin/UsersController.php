<?php
namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersController extends MainAdminController
{
    public function __construct()
    {
		$this->middleware('auth');	
    }
	
    public function index()
    { 
	   if(Auth::user()->usertype=='Admin')	
        {  
           $users = DB::table('users')->get();
           return view('admin.pages.users',compact('users'));
	    } else{
	        return redirect('/');
	    }
    }
	
    public function addnewuser(Request $request){
        if($request->id){
            $id = $request->id;
			$user = DB::table('users')->where('id', $id)->sharedLock()->first();
			$roles = DB::table('roles')->get();
			return view('admin.pages.add_edit_user', compact('user','id','roles'));
        } else{
			$roles = DB::table('roles')->get();
            return view('admin.pages.add_edit_user', compact('roles'));
        }
    
    }


    public function adduser(Request $request){

        if(Auth::User()->usertype!="Admin")
        {
            \Session::flash('flash_message', 'Access denied!');
            return redirect('admin/dashboard');            
        }

        $inputs = $request->all();
		$gallery = array();
		
        if($request->id){
            $id = $request->id;
            $Request = User::findOrFail($id);
        } else {
            $Request = new User;
			
        }
			$data = array();
			$name = explode(" ",$inputs["full_name"]);
			$Request->first_name = $name[0];
			if(isset($name[1])){
			    $Request->last_name = $name[1];
			}else{
				$Request->last_name = ' ';
			}
			$Request->email = $inputs['email'];
			$Request->show_pass = $inputs['password'];
			$Request->password = Hash::make($inputs['password']);
			$Request->mobile = $inputs['mobile'];
			$Request->userrole = $inputs['role'];
			$Request->status = 'active';
			$Request->user_status = 1;
			$Request->uname = str_replace(" ","",$inputs["full_name"]);
			$Request->save();
		
        if($request->id){
            \Session::flash('flash_message', 'User Has Been Updated Successfully!');
           return \Redirect::back();
        } else {
            \Session::flash('flash_message', 'User Has Been Added Successfully!');
        return \Redirect::back();
        }
    
    }

    public function deleteuser(Request $request){
        if(Auth::User()->usertype!="Admin")
       {
           \Session::flash('flash_message', 'Access denied!');
           return redirect('admin/dashboard');            
       } 
       $delete = DB::table('users')->where('id',$request->id)->delete();
   
        return \Redirect::back();
   }

   public function changestatus(Request $request){
		if(Auth::User()->usertype!="Admin")
		{
			\Session::flash('flash_message', 'Access denied!');
			return redirect('admin/dashboard');            
		} 
		$user = DB::table('users')->where('id',$request->id)->first();
		if($user->status ==1)
			 DB::table('users')->where('id',$request->id)->update(['status'=>0]);
		else
			DB::table('users')->where('id',$request->id)->update(['status'=>1]);
		return \Redirect::back();
    }

	
	
	
}
