<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\Banner;
use Alert;
use App\ProductsAttribute;

class IndexController extends Controller
{
    public function index(){

    	//....ascending order (by default)......
    	/*$productsAll=Product::get();*/
         //....descending order (by default)..........
    	$productsAll=Product::orderBy('id','DESC')->where('status',1)->get();
    	//....random order (by default)..........
    	/*$productsAll=Product::inRandomOrder()->where('status',1)->get();*/

    	$categories = Category::with('categories')->where(['parent_id'=>0])->get();
    	/*$categories = json_decode(json_encode($categories));
    	echo "<pre>";print_r($categories); echo "</pre>";die;*/
       /*   $category_menu="";
    	foreach ($categories as $cat) {
    		echo $cat->name;echo "</br>";
    		$category_menu.="<div class='panel-heading'>'
    		                    <h4 class='panel-title'>
    		                       <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
    		                        <span class='badge pull-right'><i class='fa fa-plus'></i></span>
    		                   ".$cat->name."
    		                 </a>
    		             </h4>
    		         </div>


    		         <div id='".$cat->id."' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>";

										$sub_categories=Category::where(['parent_id'=>$cat->id])->get();
										foreach ($sub_categories as  $subcat) {
											echo $subcat->name;echo "</br>";
											$category_menu.="<li><a href='#'>".$subcat->name." </a></li>";
										}


											
										
										$category_menu.="</ul>
									</div>
								</div>

    		         ";	 	
    	}*/
    	

      $banners=Banner::where('status','1')->get();

      return view('index')->with(compact('productsAll','category_menu','categories','banners'));
    }
}
