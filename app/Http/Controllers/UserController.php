<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\country;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
	public function UserloginRegister(){
		return view('users.login_register');

	}

	public function login(Request $request){
		if($request->isMethod('post')){
			$data=$request->all();

			

			/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
			if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
				Session::put('frontSession',$data['email']);
    			return redirect('/cart');

    		}else{
    			return redirect()->back()->with('flash_message_error','Invalid email or Password');
    		}

		}
	}
    public function register(Request $request){
    	if($request->isMethod('post')){
    		$data=$request->all();
    		/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    		if (empty($data['address'])) {
    			$data['address']='';
    	  			
    		}
    		if (empty($data['city'])) {
    		$data['city']='';
    		}
    		if (empty($data['state'])) {
    		$data['state']='';  			
    		}
    		if (empty($data['country'])) {
    		$data['country']="";  			
    		}
    		if (empty($data['pincode'])) {
    		$data['pincode']='';  			
    		}
    		if (empty($data['mobile'])) {
    		$data['mobile']='';
    		}
    	
    		//check if user is exists..........
    		$userCount=User::where('email',$data['email'])->count();
    		/*echo "<pre>"; print_r($userCount); echo "</pre>"; die;*/

    		if($userCount>0){
    			return redirect()->back()->with('flash_message_error','Email already exists');

    		}else{
    		$user=new User;
    		$user->name=$data['name'];
    		$user->address=$data['address'];
    		$user->city=$data['city'];
    		$user->state=$data['state'];
    		$user->country=$data['country'];
    		$user->pincode=$data['pincode'];
    		$user->mobile=$data['mobile'];
    		$user->email=$data['email'];
    		$user->password=bcrypt($data['password']);
    		$user->save();
    		if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
    			Session::put('frontSession',$data['email']);
    			return redirect('/cart');

    		}
    	   }  		
    	}  	
    }
    public function account(Request $request){
    	$user_id=Auth::user()->id;
    	$userDetails=User::find($user_id);
    	/*echo "<pre>"; print_r($userDetails); echo "</pre>"; die;*/
    	$countries=country::get();

    	if($request->isMethod('post')){
    		$data=$request->all();

    		if (empty($data['name'])) {
    			return redirect()->back()->with('flash_message_error',' please enter your name to update your account details');
    			
    		}
    		if (empty($data['address'])) {
    			$data['address']='';
    	  			
    		}
    		if (empty($data['city'])) {
    		$data['city']='';
    		}
    		if (empty($data['state'])) {
    		$data['state']='';  			
    		}
    		if (empty($data['country'])) {
    		$data['address']="";  			
    		}
    		if (empty($data['pincode'])) {
    		$data['country']='';  			
    		}
    		if (empty($data['mobile'])) {
    		$data['mobile']='';
    		}
    		/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    		$user=User::find($user_id);
    		$user->name=$data['name'];
    		$user->address=$data['address'];
    		$user->city=$data['city'];
    		$user->state=$data['state'];
    		$user->country=$data['country'];
    		$user->pincode=$data['pincode'];
    		$user->mobile=$data['mobile'];
    		$user->save();
    		return redirect()->back()->with('flash_message_success',' Your Account Details has been updated successfully');
    	}
    	return view('users.account')->with(compact('userDetails','countries'));
    }
    public function chkUserPassword(Request $request){
    	//check if user is already exists
    	$data=$request->all();
    	/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    	$current_password=$data['current_pwd'];
    	$user_id=Auth::User()->id;
    	$check_password=User::where('id',$user_id)->first();
    	if(Hash::check($current_password,$check_password->password)){
    		echo "true";die;
    	}else{
    		echo "false";die;
    	}
    }
    public function updateUserPassword(Request $request){
    	if($request->isMethod('post')){
    		$data=$request->all();
    		/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    		$old_pwd=User::where('id',Auth::User()->id)->first();
    		$current_pwd=$data['current_pwd'];
    	if(Hash::check($current_pwd,$old_pwd->password)){
    		//update password
    		$new_pwd=bcrypt($data['new_pwd']);
    		/*echo "<pre>"; print_r($new_pwd); echo "</pre>"; die;*/

    		User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
    		return redirect()->back()->with('flash_message_success','password is updated');

    	   }else{
    	return redirect()->back()->with('flash_message_error',' current password is incorrect');
    	}



    	}

    }
    public function logout(){
    	Auth::logout();
    	Session::forget('frontSession');
    	return redirect('/');
    }



    public function checkEmail(Request $request){
    	$data=$request->all();
    	//check if user is exists..........
    	$userCount=User::where('email',$data['email'])->count();
    		/*echo "<pre>"; print_r($userCount); echo "</pre>"; die;*/

    	if($userCount>0){
    	echo "false";

    	}else{
    			echo "true";die;
    	}


    }
}
