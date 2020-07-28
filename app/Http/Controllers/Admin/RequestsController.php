<?php
namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\HelpRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsController extends MainAdminController
{
    public function __construct()
    {
	$this->middleware('auth');	
         
    }
    public function index()
    { 
	   if(Auth::user()->usertype=='Admin')	
        {  
            
           $requests = DB::table('requests')->select('*')->get();

            return view('admin.pages.requests',compact('requests'));
	    }else{
	        return redirect('/');
	    }
   
    }  

    public function addnewrequest(Request $request){
        if($request->id){
            $id = $request->id;
			$request=DB::table('requests')->where('id', $id)->sharedLock()->first();
			return view('admin.pages.add_edit_request', compact('request','id'));
        } else{

            return view('admin.pages.add_edit_request');
        }
    
    }


    public function addrequest(Request $request){

        if(Auth::User()->usertype!="Admin")
        {
            \Session::flash('flash_message', 'Access denied!');
            return redirect('admin/dashboard');            
        }

        $inputs = $request->all();
		$gallery = array();
		
        if($request->id){
            $id = $request->id;
            $Request = HelpRequest::findOrFail($id);
        } else {
            $Request = new HelpRequest;
			
        }
			$data = array();
			request()->validate([
				'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
			]);
			$imageName ='';
			if(request()->image){
				$imageName = time().'.'.request()->image->getClientOriginalExtension();		
				request()->image->move(public_path('admin_assets/img'), $imageName);
			} 
			$Request->name = $inputs['name'];
			$Request->description = $inputs['description'];
			$Request->bags = $inputs['bags'];
			$Request->male = $inputs['male'];
			$Request->female = $inputs['female'];
			$Request->kids = $inputs['kids'];
			$Request->pets = $inputs['pets'];
			$Request->street_address = $inputs['street_address'];
			$Request->city = $inputs['city'];
			$Request->other_notes = $inputs['other_notes'];
			
			
			if($imageName){
				$Request->photo = $imageName;
			}
			

			$Request->save();
		
        if($request->id){
            \Session::flash('flash_message', 'Request Has Been Updated Successfully!');
           return \Redirect::back();
        } else {
            \Session::flash('flash_message', 'Request Has Been Added Successfully!');
        return \Redirect::back();
        }
    
    }

    public function deleterequest(Request $request){
        if(Auth::User()->usertype!="Admin")
       {
           \Session::flash('flash_message', 'Access denied!');
           return redirect('admin/dashboard');            
       } 
       $delete = DB::table('requests')->where('id',$request->id)->delete();
   
        return \Redirect::back();
   }
   public function changestatus(Request $request){
		if(Auth::User()->usertype!="Admin")
		{
			\Session::flash('flash_message', 'Access denied!');
			return redirect('admin/dashboard');            
		} 
		$req = DB::table('requests')->where('id',$request->id)->first();
		if($req->status ==1)
			 DB::table('requests')->where('id',$request->id)->update(['status'=>0]);
		else
			DB::table('requests')->where('id',$request->id)->update(['status'=>1]);
		return \Redirect::back();
    }
}