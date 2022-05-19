	
@extends('frontlayout.front_design')
@section('content')
	<section id="cart_items">
		<div class="container " style="padding-bottom:100px;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Checkout</li>
				</ol>
			</div>
			 	@if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
             @endif 
              @if(Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
              @endif
			<form action="{{ url('/checkout') }}" method="post">
					            {{ csrf_field() }}
			
			
				<div class="row">
					<div class="col-sm-5 col-sm-offset-1  clearfix">
						<div class="bill-to">
							<p>Bill To</p>
							<div class="form-one" style="width: 350px;">
							
									 <div class="form-group">									   
									    <input name="billing_name" id="billing_name"
									    @if(!empty($userDetails->name)) value="{{ $userDetails->name}}" @endif type="text" placeholder="Billing Name " class="form-control">
									  </div>
									   <div class="form-group">									   
									    <input name="billing_address" id="billing_address"
									    @if(!empty($userDetails->address)) value="{{ $userDetails->address}} @endif "type="text" placeholder="Billing Address" class="form-control">
									  </div>
									  <div class="form-group">									   
									    <input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city}}" @endif  type="text" placeholder="Billing City" class="form-control">
									  </div>
									   <div class="form-group">									   
									    <input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state}}" @endif type="text" placeholder="Billing State" class="form-control">
									  </div>
									  <div class="form-group">									   
									    <select id="billing_country" name="billing_country" class="form-control">
											<option value="">Select Country</option>
											@foreach($countries as $country)
											<option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif >{{ $country->country_name }}</option>
											@endforeach
										</select>
									  </div>
									   <div class="form-group">									   
									    <input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{ $userDetails->pincode}}" @endif type="text" placeholder="Billing Pincode" class="form-control">
									  </div>
									   <div class="form-group">									   
									    <input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile}}" @endif type="text" placeholder="Billing Mobile " class="form-control">
									  </div>

									
								  <div class="form-check">
								    <input  type="checkbox" class="form-check-input" id="copyAddress">
								    <label class="form-check-label" for="copyAddress" style="font-size: 15px;">Shiping Address same as Billing Address </label>
								  </div>
									
								
							</div>
							
						</div>
					</div>

					<div class="col-sm-5 clearfix">
						<div class="bill-to">
							<p>Ship To</p>
							<div class="form-two col-sm-12" style="width: 350px;" >
									
							
									 <div class="form-group">									   
									    <input name="shipping_name" id="shipping_name" type="text" placeholder="shipping Name " class="form-control" @if(!empty($shippingDetails->name))  value="{{ $shippingDetails->name }}" @endif >
									  </div> 
									   <div class="form-group">									   
									    <input name="shipping_address" id="shipping_address" type="text" placeholder="shipping Address" class="form-control" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif>
									  </div>
									  <div class="form-group">									   
									    <input name="shipping_city" id="shipping_city" type="text" placeholder="shipping City" class="form-control" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif>
									  </div>
									   <div class="form-group">									   
									    <input name="shipping_state" id="shipping_state" type="text" placeholder="shipping State" class="form-control" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif>
									  </div>


									  <div class="form-group">									   
									   <select id="shipping_country" name="shipping_country" class="form-control">
										<option >Select Country</option>
										@foreach($countries as $country)
										<option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif >{{ $country->country_name }}</option>
										@endforeach
									</select>
									  </div>
									   <div class="form-group">									   
									    <input name="shipping_pincode" id="shipping_pincode" type="text" placeholder="shipping Pincode" class="form-control" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif>
									  </div>
									   <div class="form-group">									   
									    <input name="shipping_mobile" id="shipping_mobile" type="text" placeholder="shipping Mobile " class="form-control" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif>
									  </div>                      									
								<button type="submit" name="submit" class="btn btn-default " >Checkout</button>

							</div>

							
							
						</div>
					</div>
									
				</div>
		


		<form>



			
		</div>
	</section> <!--/#cart_items-->

	@endsection