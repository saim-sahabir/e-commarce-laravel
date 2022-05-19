<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use Alert;
use App\ProductsAttribute;
use App\ProductsImage;
use App\coupon;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use DB;

class ProductsController extends Controller
{ 
 public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Under Category is missing!');    
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';             
            }

              if(!empty($data['care'])){
                $product->care = $data['care'];
            }else{
                $product->care = '';             
            }


            $product->price = $data['price'];

            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'backend/images/products/large/'.$filename;
                    $medium_image_path = 'backend/images/products/medium/'.$filename;
                    $small_image_path = 'backend/images/products/small/'.$filename;
                    // Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // Store image name in products table
                    $product->image = $filename;
                    /* echo "<pre>"; print_r($filename); die;*/
                }
            }

            if(empty($data['status'])){
                $status=0;
            }else{
                $status=1;             
            }
            $product->status=$status;

            $product->save();
            /*return redirect()->back()->with('flash_message_success','Product has been added successfully!');*/
            return redirect('/admin/view-products')->with('flash_message_success','Product has been added successfully!');
        }
        

        /////............category dropdown start..........
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        /////............category dropdown end..........


        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }
    public function viewProducts(){     
        $products = Product::OrderBy('id','DESC')->get();
        /*$products = json_decode(json_encode($products));*/
        foreach($products as $key => $val){   
          $category_name = Category::where(['id'=>$val->category_id])->first();         
            $products[$key]->category_name = $category_name->name;
        }
       /* echo "<pre>"; print_r($products); die;*/
        return view('admin.products.view_products')->with(compact('products'));
    }  
    public function editProduct(Request $request,$id = null){
         if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

               // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'backend/images/products/large/'.$filename;
                    $medium_image_path = 'backend/images/products/medium/'.$filename;
                    $small_image_path = 'backend/images/products/small/'.$filename;
                    // Resize Images
                    Image::make($image_tmp)->save($large_image_path);                   
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);                   
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);


                    // Store image name in products table
                    //$product->image = $filename;
                    /* echo "<pre>"; print_r($filename); die;*/
                }
            }else{
                    $filename=$data['current_image'];
                }

                if (empty($data['description'])) {
                    $data['description']="";
                }
                 if (empty($data['care'])) {
                    $data['care']="";
                }
                if(empty($data['status'])){
                    $status=0;
                }else{
                    $status=1;             
                }
               

                 Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$filename,'status'=>$status]);
              return redirect()->back()->with('flash_message_success','product has been updated Successfully!');
         
            }       
        //........GET product details..........

        $productDetails=Product::where(['id'=>$id])->first();      
            /////............category dropdown start..........
         $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){

            if($cat->id==$productDetails->category_id){
                $selected="selected";

            }else{
                $selected="";

            }

            $categories_dropdown .= "<option value='".$cat->id."'".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {

              if($sub_cat->id==$productDetails->category_id){
                $selected="selected";

            }else{
                $selected="";

            }

                $categories_dropdown .= "<option value = '".$sub_cat->id."'".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
         /////............category dropdown end..........
        return view('admin.products.edit_products')->with(compact('productDetails','categories_dropdown'));
    }
      public function deleteProduct($id=null){

       Product::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_message_success','product has been deleted Successfully!');
    }
    public function deleteProductsImage($id=null){
        // get product image name
       $ProductImage=Product::where(['id'=>$id])->first();
      // get product image path
       $large_image_path='backend/images/products/large/';
       $medium_image_path='backend/images/products/medium/';
       $small_image_path='backend/images/products/small/';
       //delete large image if not exist in folder........
       if (file_exists($large_image_path.$ProductImage->image)) {
        unlink($large_image_path.$ProductImage->image);
          
       }
        //delete medium image if not exist in folder........
       if (file_exists($medium_image_path.$ProductImage->image)) {
        unlink($medium_image_path.$ProductImage->image);
          
       }
        //delete small image if not exist in folder........
       if (file_exists($small_image_path.$ProductImage->image)) {
        unlink($small_image_path.$ProductImage->image);
          
       }

      // //delete  image from product table.......
       Product::where(['id'=>$id])->update(['image'=>'']);
     return redirect()->back()->with('flash_message_success','image has been deleted Successfully!');
    }



     public function deleteAltImage($id=null){
        // get product image name
       $ProductImage=ProductsImage::where(['id'=>$id])->first();
      // get product image path
       $large_image_path='backend/images/products/large/';
       $medium_image_path='backend/images/products/medium/';
       $small_image_path='backend/images/products/small/';
       //delete large image if not exist in folder........
       if (file_exists($large_image_path.$ProductImage->image)) {
        unlink($large_image_path.$ProductImage->image);
          
       }
        //delete medium image if not exist in folder........
       if (file_exists($medium_image_path.$ProductImage->image)) {
        unlink($medium_image_path.$ProductImage->image);
          
       }
        //delete small image if not exist in folder........
       if (file_exists($small_image_path.$ProductImage->image)) {
        unlink($small_image_path.$ProductImage->image);
          
       }

      // delete  image from product table.......
     ProductsImage::where(['id'=>$id])->delete();

     return redirect()->back()->with('flash_message_success','alternate image(s) has been deleted Successfully!');
    }


    public function addAttributes(Request $request, $id = null){
   

        $productsDetails=Product::with('attributes')->where(['id'=>$id])->first();
        /*$productsDetails = json_decode(json_encode($productsDetails));*/

      /*echo "<pre>";print_r($productsDetails);echo "</pre>";die;*/

        if($request->isMethod('post')){
            $data = $request->all();          
             /*echo "<pre>";print_r($data);echo "</pre>";die;*/
             foreach ($data['sku'] as $key =>$val) {
                if (!empty($val)) { 
                //prevent  duplicate sku check.........
                    $attrCountSKU=ProductsAttribute::where('sku',$val)->count();
                    if ($attrCountSKU>0) {
                       return redirect('admin/add-attribute/'.$id)->with('flash_message_error','sku is already exists! please add another sku');

                   }  
                    //prevent  duplicate size check.........
                   $attrCountSizes=ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                   if ($attrCountSizes>0) {
                       return redirect('admin/add-attribute/'.$id)->with('flash_message_error',''.$data['size'][$key].' size is already exists! please add another size');

                   } 


                $attribute= new ProductsAttribute;
                $attribute->product_id = $id;
                $attribute->sku = $val;
                $attribute->size = $data['size'][$key];
                $attribute->price = $data['price'][$key];
                $attribute->stock = $data['stock'][$key];
                $attribute->save();
              }
             }
             return redirect()->back()->with('flash_message_success','Product Attribute has been added Successfully!');
         }
        return view('admin.products.add_attributes')->with(compact('productsDetails'));
    }


    public function editAttributes(Request $request,$id = null){

      if($request->isMethod('post')){
         
            $data=$request->all();
            //echo "<pre>";print_r($data);echo "</pre>";die;
            foreach ($data['idAttr'] as $key => $attr) {
              ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
            
            }

            return redirect()->back()->with('flash_message_success','Attribute has been updated Successfully!');


    }

  }




     public function deleteAttribute($id=null){     
       ProductsAttribute::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_message_success','Attribute has been deleted Successfully!');
    }

     public function addImages(Request $request,$id = null){
        $productsDetails=Product::with('attributes')->where(['id'=>$id])->first();   
        if($request->isMethod('post')){
           //add images
            $data=$request->all();
            /*echo "<pre>"; print_r($data); die;*/                     
            if($request->hasFile('image')){
                $files =$request->file('image');
                /* echo "<pre>"; print_r($files); echo "</pre>"; die;*/
                //upload image after image resize..........              
                foreach($files as $file) {
               
                   $image = new ProductsImage;

                   /* echo "pre"; print_r($image); echo "</pre>"; die;*/
               
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'backend/images/products/large/'.$filename;
                    $medium_image_path = 'backend/images/products/medium/'.$filename;
                    $small_image_path = 'backend/images/products/small/'.$filename;
                    // Resize Images
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);
                    // Store image name in products table
                    $image->image = $filename;
                      /*echo "<pre>"; print_r($filename); die;*/
                   $image->product_id = $data['product_id'];
                    $image->save();                
                    
                }
                return redirect('admin/add-images/'.$id)->with('flash_message_success','Images has been added Successfully!');
             
                }
            } 

            $productsImages=ProductsImage::where(['product_id'=>$id])->get();    
         
        return view('admin.products.add_images')->with(compact('productsDetails','productsImages'));
    }

    public function products($url=null){
        //.........shoe 404 page if category url does not exist...........
        $countCategory=category::where(['url'=>$url,'status'=>1])->count();
        if ($countCategory==0) {
           return view('404');
        }
       /* echo $countCategory; die;*/
       //.........get all categories and sub category..........
         $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        $categoryDetails=category::where(['url'=>$url])->first();     
        if ($categoryDetails->parent_id==0) {
          // if url is main category url..........
            $subcategories=category::where(['parent_id'=>$categoryDetails->id])->get();  
            
            foreach ($subcategories as $subcat) {
             $cat_ids[]=$subcat->id;                  
            }             
               $productsAll=Product::whereIn('category_id',$cat_ids)->where('status',1)->get();
        }else{
            //.........if url is sub category url..........
             $productsAll=Product::where(['category_id'=>$categoryDetails->id])->where('status',1)->get();     
    }           
       /* $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        $categoryDetails=category::where(['url'=>$url])->first();
        
        $productsAll=Product::where(['category_id'=>$categoryDetails->id])->get();*/
        return view('products.listing')->with(compact('categories','categoryDetails','productsAll'));
     
    }

    public function product($id=null){
      //show 404 page if products is disabled
      $productscount=Product::where(['id'=>$id,'status'=>1])->count();
      if($productscount==0){
        return view(404);


      }
        //.........get  product details..........
         $productsDetails=Product::where('id',$id)->first();
         /*$productsDetails=json_decode(json_encode($productsDetails));*/
       /*  echo "<pre>";print_r($productsDetails);echo "</pre>";die;*/
        $releteProducts=Product::where('id','!=',$id)->where(['category_id'=>$productsDetails->category_id])->get();
        /*$releteProducts=json_decode(json_encode($releteProducts));*/
     /*   foreach ($releteProducts->chunk(3) as $chunk) {
           foreach($chunk as $item){

            echo $item; echo "<br>";
           }
           echo "<br><br><br>";
         
        }
        die;*/



        /*echo "<pre>";print_r($releteProducts);echo "</pre>";die;*/


         //.........get all categories and sub category..........
         $categories = Category::with('categories')->where(['parent_id'=>0])->get();
          //.........get alternate product image..........

         $ProductAltImages=ProductsImage::where(['product_id'=>$id])->get();
         /*$ProductAltImages=json_decode(json_encode($ProductAltImages));
          echo "<pre>";print_r($ProductAltImages);echo "</pre>";die;*/
          //.........get all stock ..........
         $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');      
        return view('products.detail')->with(compact('productsDetails','categories','ProductAltImages','total_stock','releteProducts'));
    }
    public function getProductPrice(Request $request){
        $data=$request->all();
       /* echo "<pre>"; print_r($data);echo "</pre>";die;*/
       $proArr=explode("-",$data['selSize']);
       /*echo $proArr[0];echo$proArr[1];die;*/

       $proArr=ProductsAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr['1']])->first();
       echo $proArr->price;
       echo "#";
       echo $proArr->stock;
      
    }
    public function addtoCart(Request $request){
            Session::forget('couponAmount');
            Session::forget('coupon_code');
           $data=$request->all();
           /*echo "<pre>"; print_r($data);echo "</pre>";die;*/
           if(empty(Auth::User()->email)){
            $data['user_email']='';
           }else{
            $data['user_email']=Auth::User()->email;
           }
           $session_id=Session::get('session_id');
           if(empty($session_id)){
            $session_id=str_random(40);
            Session::put('session_id',$session_id);
           }
            
            $sizeArr=explode("-",$data['size']);
            $countProducts=  DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],'size'=>$sizeArr[1],'session_id'=>$session_id])->count();
            if($countProducts>0){
              return redirect()->back()->with('flash_message_error','product already exists in cart!');

            }else{
              $getSKU=ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$sizeArr[1]])->first();


              DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'product_code'=>$getSKU->sku,'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$sizeArr[1],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
            }        

        return redirect('cart')->with('flash_message_success','product has been added in cart Successfully!');

    }

    public function cart(){
      if(Auth::check()){
         $user_email=Auth::user()->email;
      $usercart=DB::table('cart')->where(['user_email'=>$user_email])->get();
    }else{
      $session_id=Session::get('session_id');
      $usercart=DB::table('cart')->where(['session_id'=>$session_id])->get();
    }
     
      foreach ($usercart as $key => $product) {
        $productDetails=Product::where('id',$product->product_id)->first();
        // $usercart[$key]->image="test";
         $usercart[$key]->image=$productDetails->image;
       
      }
      /*echo "<pre>"; print_r($usercart);echo "</pre>";die;*/

      return view('products.cart')->with(compact('usercart'));
    }

    public function deletecartProduct($id=null){
       Session::forget('couponAmount');
      Session::forget('coupon_code'); 

      DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','product has been deleted from cart in Successfully!');
    }

    public function updatequantityCart($id=null,$quantity=null){
       Session::forget('couponAmount');
      Session::forget('coupon_code');
      $getCartDetails=DB::table('cart')->where('id',$id)->first();
      $getAttbuteStock=ProductsAttribute::where('sku',$getCartDetails->product_code)->first();
      echo $getAttbuteStock->stock; echo "--";
      echo $updated_quantity=$getCartDetails->quantity+$quantity;
     if($getAttbuteStock->stock >=$updated_quantity){
       DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
       return redirect('cart')->with('flash_message_success','quantity has been updated in Successfully!');

     }else{
        return redirect('cart')->with('flash_message_error','Required product quantity are not available');
     }

    }

    public function applyCoupon(Request $request){
      Session::forget('couponAmount');
      Session::forget('coupon_code');
      $data=$request->all();
      /*echo "<pre>"; print_r($data);echo "</pre>";die;*/
      $couponCount=coupon::where('coupon_code',$data['coupon_code'])->count();
      if($couponCount==0){
        return redirect()->back()->with('flash_message_error','coupon is not exists.');


      }else{
       //get coupon details
        $couponDetails=coupon::where('coupon_code',$data['coupon_code'])->first();
         //if coupon is active
        if($couponDetails->status==0){
        return redirect()->back()->with('flash_message_error','coupon is not active.');      
        }
        //if coupon is expired..
         $expiry_date=$couponDetails->expiry_date;
         $current_date=date('Y-m-d');
         if($expiry_date < $current_date){
          return redirect()->back()->with('flash_message_error','date is expired.');
         }
         //coupon is valid for discount....
        $session_id=Session::get('session_id');
        $usercart=DB::table('cart')->where(['session_id'=>$session_id])->get();
         //get user address for coupon....
        if(Auth::check()){
             $user_email=Auth::user()->email;
          $usercart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
          $session_id=Session::get('session_id');
          $usercart=DB::table('cart')->where(['session_id'=>$session_id])->get();
        }


          $total_amount=0;
         foreach ($usercart as $item) {
            $total_amount=$total_amount+($item->price*$item->quantity);     
      }

      //check amount type is fixed or percentage.........

      if($couponDetails->amount_type=="Fixed"){

        $couponAmount=$couponDetails->amount;
      }else{

         $couponAmount=$total_amount*($couponDetails->amount/100);
      }
      /*echo $couponAmount;die;*/
      Session::put('couponAmount',$couponAmount);
      Session::put('coupon_code',$data['coupon_code']);
    return redirect()->back()->with('flash_message_success','coupon code is successfully applied. You are availing for discount');

      }
      }


      public function checkout(Request $request,$id=null){
        $user_id=Auth::user()->id;
        $user_email=Auth::user()->email;
        $userDetails=User::find($user_id);
        $countries=Country::get();

        //check if shipping address exists
        $shippingCount=DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails=array();
        if($shippingCount>0){
          $shippingDetails=DeliveryAddress::where('user_id',$user_id)->first();

        }
        //update cart table with user email
        $session_id=Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);

        if($request->isMethod('post')){
          $data=$request->all();
         /* echo "<pre>"; print_r($data);echo "</pre>";die;*/
        if(empty($data['billing_name'])||empty($data['billing_address'])||empty($data['billing_city'])||empty($data['billing_state'])||empty($data['billing_country'])||empty($data['billing_pincode'])||empty($data['billing_mobile'])||empty($data['shipping_name'])||empty($data['shipping_address'])||empty($data['shipping_city'])||empty($data['shipping_state'])||empty($data['shipping_country'])||empty($data['shipping_pincode'])||empty($data['shipping_mobile'])){
         return redirect()->back()->with('flash_message_error','please fill all the fields to checkout');

        }

        //update user details 
        User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'country'=>$data['billing_country'],'pincode'=>$data['billing_pincode'],'mobile'=>$data['billing_mobile']]);

        //update shipping address
        if($shippingCount>0){
           DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'country'=>$data['shipping_country'],'pincode'=>$data['shipping_pincode'],'mobile'=>$data['shipping_mobile']]);
        }else{
          //Add new shipping address 
          $shipping= new DeliveryAddress;
          $shipping->user_id=$user_id;
          $shipping->user_email=$user_email;
          $shipping->name=$data['shipping_name'];

          $shipping->address=$data['shipping_address'];
          $shipping->city=$data['shipping_city'];
          $shipping->state=$data['shipping_state'];
          $shipping->country=$data['shipping_country'];
          $shipping->pincode=$data['shipping_pincode'];
          $shipping->mobile=$data['shipping_mobile'];
          $shipping->save();
            
        }
        return redirect()->action('ProductsController@orderReview');

        }


        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));
      }



      public function orderReview(){
        $user_id=Auth::user()->id;
        $user_email=Auth::user()->email;
        $userDetails=User::where('id',$user_id)->first();
        /*$userDetails=json_decode(json_encode($userDetails));*/
        $shippingDetails=DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails=json_decode(json_encode($shippingDetails));
         $usercart=DB::table('cart')->where(['user_email'=>$user_email])->get();
         foreach ($usercart as $key => $product) {
        $productDetails=Product::where('id',$product->product_id)->first();
        // $usercart[$key]->image="test";
         $usercart[$key]->image=$productDetails->image;     
      }
      /*echo "<pre>"; print_r($usercart);echo "</pre>";die;*/
        return view('products.order_review')->with(compact('userDetails','shippingDetails','usercart'));
      }
      public function placeOrder(Request $request){
        if($request->isMethod('post')){
          $data=$request->all();
          $user_id=Auth::user()->id;
          $user_email=Auth::user()->email;
          //get shipping address of user
           $shippingDetails=DeliveryAddress::where('user_email',$user_email)->first();
          /* $shippingDetails=json_decode(json_encode($shippingDetails));
          echo "<pre>"; print_r($shippingDetails);echo "</pre>";die;*/
          if(empty(Session::get('coupon_code'))){
                $coupon_code= "";
            }else{
              $coupon_code=Session::get('coupon_code');

            }
             if(empty(Session::get('couponAmount'))){
              $coupon_amount= "";
                
            }else{
              $coupon_amount=Session::get('couponAmount');

            }
            

          $order=new Order;
          $order->user_id=$user_id;
          $order->user_email=$user_email;
          $order->name=$shippingDetails->name;
          $order->address=$shippingDetails->address;
          $order->city=$shippingDetails->city;
          $order->state=$shippingDetails->state;
          $order->pincode=$shippingDetails->pincode;
          $order->country=$shippingDetails->country;
          $order->mobile=$shippingDetails->mobile;
          $order->coupon_code=$coupon_code;
          $order->coupon_amount=$coupon_amount;
          $order->order_status="new";
          $order->payment_method=$data['payment_method'];
          $order->grand_total=$data['grand_total'];
          $order->save();


          $order_id=DB::getPdo()->lastInsertId();

          $cartProducts=DB::table('cart')->where(['user_email'=>$user_email])->get();

          foreach ($cartProducts as $pro) {

            $cartPro=new OrdersProduct;
            $cartPro->order_id=$order_id;
            $cartPro->user_id=$user_id;
            $cartPro->product_id=$pro->product_id;
            $cartPro->product_code=$pro->product_code;
            $cartPro->product_name=$pro->product_name;
            $cartPro->product_color=$pro->product_color;
            $cartPro->product_size=$pro->size;
            $cartPro->product_price=$pro->price;
            $cartPro->product_qty=$pro->quantity;
       
            $cartPro->save();
           
          }

          Session::put('order_id',$order_id);
          Session::put('grand_total',$data['grand_total']);
          //redirect user ti thanks page after save order..
          return redirect('/thanks');
         

        }


      }

      public function thanks(Request $request){

        $user_email=Auth::User()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('products.thanks');

        
      }
      public function userOrders(){
        $user_id=Auth::User()->id;
        $orders=Order::with('orders')->where('user_id',$user_id)->OrderBy('id','DESC')->get();
        /*$orders=json_decode(json_encode($orders));
        echo "<pre>";print_r($orders); "<pre/>"; die;*/
        return view('/orders.user_orders')->with(compact('orders'));

      }

      public function userOrderDetails($order_id){
        $user_id=Auth::User()->id;
        $orderDetails=Order::with('orders')->where('id',$order_id)->first();
        $orderDetails=json_decode(json_encode($orderDetails));
        /*echo "<pre>";print_r($orderDetails); "<pre/>"; die;*/
        return view('orders.user_order_details')->with(compact('orderDetails'));


      }
    
}
