<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use Illuminate\Support\Facades\Hash;


class AdminLoginController extends Controller
{
    public function login(Request $request ){

    	if ($request->isMethod('post')) {
    		$data=$request->input();
    		if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])) {
                /*Session::put('admin_session',$data['email']);*/
    			return redirect('/dashboard');
    			
    		}else{

                return redirect('/admin')
                ->with('message','Email OR Password is Invalid');
    			
    		}
    		
    	}

    	return view('/admin.admin_login');
    }

    public function dashboard(){
        /*if (Session::has('admin_session')) {
           
        }else{
            return redirect('/admin')
            ->with('message','please login to access');
        }*/
    	return view('admin.dashboard');
    }
     public function logout(){

        Session::flush();
         return redirect('/admin')
         ->with('success','logout done successfully');
         
    }
     public function setting(){

        return view('admin.setting');

      
    }

      public function chkPassword(Request $request){
        $data = $request->all();  
        $current_password = $data['current_pwd'];
         $check_password = User::where(['admin'=>'1'])->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true"; die;
        }else {
            echo "false"; die;
        }
    }


      public function updatePassword(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $check_password = User::where(['email' => Auth::user()->email])->first();
            $current_password = $data['current_pwd'];
            if(Hash::check($current_password,$check_password->password)){
                $password = bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                return redirect('/admin_setting')->with('success','Password updated Successfully!');
            }else {
                return redirect('/admin_setting')->with('message','Incorrect Current Password!');
            }
        }
    }



}
