<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use App\Banner;

class BannerController extends Controller
{
    public function addBanner(Request $request){
    if($request->isMethod('post')){
    	$data=$request->all();
    	/*echo "<pre>"; print_r($data); echo "</pre>"; die;*/
    	$brand = new Banner;
            $brand->title = $data['title'];
            $brand->link = $data['link'];

            
            if(!empty($data['status'])){
                $status = '1';
            }else{
                $status = '0';            
            }
            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'frontend/images/banner/'.$filename;                  
                    // Resize Images                  
                    Image::make($image_tmp)->resize(1140,340)->save($large_image_path);
                    // Store image name in products table
                    $brand->image = $filename;
                    /* echo "<pre>"; print_r($filename); die;*/
                }
            }         
            $brand->status=$status;
            $brand->save();
            /*return redirect()->back()->with('flash_message_success','Product has been added successfully!');*/
            return redirect()->back()->with('flash_message_success','Banner has been added successfully!');
        }  	   
    return view('admin.banners.add_banner');
    }
      public function editBanner(Request $request,$id=null){
      	if($request->isMethod('post')){
      		$data=$request->all();

      		   if(!empty($data['status'])){
                $data['status'] = '1';
            }else{
                $status = '0';            
            }

               if(empty($data['title'])){
                $data['title'] = '';
            }
             if(empty($data['link'])){
                $data['link'] = '';
            }
      		// Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'frontend/images/banner/'.$filename;
                   
                    // Resize Images
                   
                    Image::make($image_tmp)->resize(1140,340)->save($large_image_path);                 
                }
            }else if(!empty($data['current_image'])){
            	$filename=$data['current_image'];

            }else{
            	$filename='';
            }

            Banner::where('id',$id)-> update(['status'=>$data['status'],'title'=>$data['title'],'link'=>$data['link'],'image'=>$filename]);
            return redirect()->back()->with('flash_message_success','Banner has been edited successfully');     		
      	}

      	$bannerDetails=Banner::where('id',$id)->first();
      	return view('admin.banners.edit_banner')->with(compact('bannerDetails')); 	
  }
    public function viewBanner(){
    	$banners=Banner::get();
    	return view('admin.banners.view_banner')->with(compact('banners'));


    }

    public function deleteBanner($id=null){
    	Banner::where('id',$id)->delete();
    	return redirect()->back()->with('flash_message_success','Banner has been deleted successfully'); 


    }




}
