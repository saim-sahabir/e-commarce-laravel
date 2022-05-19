@extends('frontlayout.front_design')
@section('content')

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Order Review</li>
				</ol>
			</div><!--/breadcrums-->

		

			<div class="shopper-informations">
				<div class="row">
										
				</div>
			</div>

			<div class="row">
					<div class="col-sm-5 col-sm-offset-1  clearfix">
						<div class="bill-to">
							<p>Bill Details</p>
							<div class="form-one" style="width: 350px;">
							
									 <div class="form-group">									   
									    {{ $userDetails->name}}
									  </div>
									   <div class="form-group">									   
									   {{ $userDetails->address}}
									  </div>
									  <div class="form-group">									   
									   {{ $userDetails->city}}
									  </div>
									   <div class="form-group">									   
									    {{ $userDetails->state}}
									  </div>
									  <div class="form-group">									   
									  
											{{ $userDetails->country }}
									  </div>
									   <div class="form-group">									   
									    {{ $userDetails->pincode}}
									  </div>
									   <div class="form-group">									   
									    {{ $userDetails->mobile}}
									  </div>

								
							</div>
							
						</div>
					</div>

					<div class="col-sm-5 clearfix">
						<div class="bill-to">
							<p>Shipping Details</p>
							<div class="form-two col-sm-12" style="width: 350px;" >
									
							
									 <div class="form-group">									   
									  {{ $shippingDetails->name }}
									  </div>
									   <div class="form-group">									   
									   {{ $shippingDetails->address }}
									  </div>
									  <div class="form-group">									   
									   {{ $shippingDetails->city }} 
									  </div>
									   <div class="form-group">									   
									   {{ $shippingDetails->state }} 
									  </div>


									  <div class="form-group">									   
									   
									
										{{ $shippingDetails->country }}
									  </div>
									   <div class="form-group">									   
									   {{ $shippingDetails->pincode }} 
									  </div>
									   <div class="form-group">									   
									   {{ $shippingDetails->mobile }}
									  </div>                      									
								

							</div>

							
							
						</div>
					</div>								
			</div>

			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php $total_amount=0; ?>

						@foreach($usercart as $cart)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{asset('backend/images/products/small/'.$cart->image)}}" alt="" style="width: 100px;"></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{ $cart->product_name }}</a></h4>
								<p>{{ $cart->product_code }} | {{ $cart->size }}</p>
							</td>
							<td class="cart_price">
								<p>INR {{ $cart->price }}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<p>{{ $cart->quantity }}</p>
									
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">INR {{ $cart->price*$cart->quantity }}</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/cart/delete-product/'.$cart->id)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php $total_amount=$total_amount+( $cart->price*$cart->quantity); ?>
						@endforeach

						
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>{{ $total_amount }}</td>
									</tr>
									
									<tr class="shipping-cost">
										<td>Shipping Cost(+)</td>
										<td>INR 0</td>										
									</tr>
									<tr class="shipping-cost">
										<td>Discount(-)</td>
										<td>
										  @if(!empty(Session::get('couponAmount')))
										   INR {{ Session::get('couponAmount') }}
										   @else
										    INR 0
										   @endif
									   </td>										
									</tr>
									<tr>
										<td>Grand Total</td>
										<td><span>INR {{$grand_total= $total_amount-Session::get('couponAmount') }}</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<form name="paymentform" id="paymentform" action="{{ url('/place-order') }}" method="post">
			     {{ csrf_field() }}
			     <input type="hidden" name="grand_total" value="{{ $grand_total }}">
			<div class="payment-options">
					<span>
						<label> <strong>Select Payment Method</strong></label>
					</span>
					<span>
						<label><input type="radio" name="payment_method" id="COD" value="COD"><strong> COD</strong></label>
					</span>
					<span>
						<label><input type="radio" name="payment_method" id="Paypal" value="Paypal"><strong> Paypal</strong></label>
					</span>
					<span style="float: right;">
						<button type="submit" name="submit" class="btn btn-default" onclick="return selectPaymentMethod();">place order</button>
					</span>
			</div>
		</form>

		</div>
	</section> <!--/#cart_items-->



@endsection