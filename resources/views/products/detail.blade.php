@extends('frontlayout.front_design')
@section('content')


<section>
		<div class="container"> 
			<div class="row">
			   @if(Session::has('flash_message_error'))
        <div class="alert alert-danger  alert-block" style="padding-left:300px; ">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
             @endif
				<div class="col-sm-3">
					@include('frontlayout.front_sidebar')
				
				</div>
				
			<div class="col-sm-9 padding-right">
				<div class="product-details"><!--product-details-->
					<div class="col-sm-5">
						<div class="view-product">
							<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
							  <a  href="{{asset('backend/images/products/large/'.$productsDetails->image)}}">
								 <img style="width:300px;" class="mainImage" src="{{asset('backend/images/products/large/'.$productsDetails->image)}}" alt="" />
							  </a>
								
						   </div>
						</div>

							
				<div id="similar-product" class="carousel slide" data-ride="carousel">
						
						 
					 <div class="carousel-inner">
						<div class="item active thumbnails">
							
							<a href="{{asset('backend/images/products/large/'.$productsDetails->image)}}" data-standard="{{asset('backend/images/products/small/'.$productsDetails->image)}}">
								 <img style="width:80px;" class="changeImage" src="{{asset('backend/images/products/small/'.$productsDetails->image)}}" alt="" />
							  </a>
								@foreach($ProductAltImages as $altimage)
						 <a href="{{ asset('/backend/images/products/large/'.$altimage->image) }}" data-standard="{{ asset('/backend/images/products/small/'.$altimage->image) }}">
							<img class="changeImage" style="width:80px; cursor: pointer; " src="{{ asset('/backend/images/products/small/'.$altimage->image) }}" alt="" >
							</a>
								  @endforeach
							</div>
								
								
							</div>
					
					      </div>

						</div>
						
						<div class="col-sm-7">
							<form name="addtocartForm" id="addtocartForm" action="{{url('add-cart')}}" method="post">
								{{ csrf_field()}}
								<input type="hidden" name="product_id" value="{{$productsDetails->id}}">
								<input type="hidden" name="product_name" value="{{$productsDetails->product_name}}">
								<input type="hidden" name="product_code" value="{{$productsDetails->product_code}}">
								<input type="hidden" name="product_color" value="{{$productsDetails->product_color}}">
								<input type="hidden" name="price" id="price" value="{{$productsDetails->price}}">
								<input type="hidden" name="size" id="size" value="{{$productsDetails->size}}">
								
								
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg'" class="newarrival" alt="" />
								<h2>{{ $productsDetails->product_name}}</h2>
								<p>Code: {{ $productsDetails->product_code}}</p>
							<p>									
							<select name="size" id="selSize" style="width:150px;">
								<option value="">Select Size</option>
								@foreach($productsDetails->attributes as $sizes)
								<option value="{{$productsDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
								@endforeach
							</select>																										
								</p>
								<img src="images/product-details/rating.png" alt="" />
								<span>
									<span id="getPrice">INR {{ $productsDetails->price}}</span>
									<label>Quantity:</label>

									<input type="text" name="quantity" value="1" />
									@if($total_stock>0)
										<button type="submit" class="btn btn-fefault cart" id="cartBtton">
											<i class="fa fa-shopping-cart"></i>
											Add to cart
										</button>
										@endif
								</span>
								<p><b>Availability:</b>
									<span id="Availability">@if($total_stock>0)
									 In Stock
									 @else
									 out of stock
									 @endif
									</p>
									</span>
								<p><b>Condition:</b> New</p>
								<p><b>Brand:</b> E-SHOPPER</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
							</form>

						</div>
						
						



					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab"> Material & care</a></li>
								<li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
								
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="description" >
								<div class="col-sm-12">
									<p>
										{{ $productsDetails->description}}
									</p>
								</div>
								
							</div>
							
							<div class="tab-pane fade" id="care" >
								<div class="col-sm-12">
									<p>
										{{ $productsDetails->care}}
									</p>
								</div>
								
							</div>
							
							<div class="tab-pane fade" id="delivery" >
								<div class="col-sm-12">
									<p>
										100% Original Products<br>
										Cash on Delivery
									</p>
								</div>
								
							</div>
							
							
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php $count=1;?>
								@foreach($releteProducts->chunk(3) as $chunk)
								<div <?php if($count==1){?> class="item active" <?php }else{

									?> class="item" <?php } ?>   >
									@foreach($chunk as $item) 

									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img style="width:200px;"  src="{{asset('backend/images/products/small/'.$item->image)}}" alt="" />
													<h2>INR {{$item->price}}</h2>
													<p>{{$item->product_name}}</p>
													<a href="{{ url('product/'.$item->id) }}"><button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button></a>
												</div>
											</div>
										</div>
									</div>
									@endforeach
									
								</div>
								<?php  $count++; ?>
								@endforeach 

								 
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>


@endsection