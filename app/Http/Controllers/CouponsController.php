<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\coupon;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){
    	if($request->isMethod('post')){
    		$data=$request->all();
    		$coupon=new coupon;
    		$coupon->coupon_code=$data['coupon_code'];
    		$coupon->amount=$data['amount'];
    		$coupon->amount_type=$data['amount_type'];
    		$coupon->expiry_date=$data['expiry_date'];
    		$coupon->status=$data['status'];
    		$coupon->save();
    		 return redirect()->action('CouponsController@viewCoupons')->with('flash_message_success','coupon has been added succsessfully!');

    		/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    	}
    	return view('admin.coupons.add_coupon');
    }
    public function editCoupon(Request $request,$id=null){

    	//$couponDetails=coupon::find($id);
    	if($request->isMethod('post')){
    		$data=$request->all();
    		$coupon=coupon::find($id);
    		$coupon->coupon_code=$data['coupon_code'];
    		$coupon->amount=$data['amount'];
    		$coupon->amount_type=$data['amount_type'];
    		$coupon->expiry_date=$data['expiry_date'];
    		if(empty($data['status'])){
    			$data['status']=0;
    		}
    		$coupon->status=$data['status'];
    		$coupon->save();
    		 return redirect()->action('CouponsController@viewCoupons')->with('flash_message_success','coupon has been updated succsessfully!');
    	/*$couponDetails=json_decode(json_encode($couponDetails));
    	echo "<pre>"; print_r($couponDetails); echo "</pre>"; die;*/
    }
    	$couponDetails=coupon::find($id);
    	return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));


    }

    public function viewCoupons(){
    	$coupons=coupon::get();
    	return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }

    public function deleteCoupon($id){
       coupon::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_message_success','coupon has been deleted succsessfully!');

    }
}
