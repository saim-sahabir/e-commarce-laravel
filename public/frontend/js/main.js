/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

//change price and stock with size
	$(document).ready(function(){
		
		$("#selSize").change(function(){

			 var selSize=$(this).val();
			 if(selSize==""){
			 	return false;
			 }

			$.ajax({

				type:'get',
				//url:'get-product-price',
				url:'http://localhost/laravel/public/get-product-price',
				data:{selSize:selSize},
				//dataType:'json',
				success:function(resp){
					/*alert(resp); return false;*/
					var arr=resp.split('#');
					$('#getPrice').html("INR "+arr[0]);
					$("#price").val(arr[0]);
					if(arr[1]==0){
						$("#cartBtton").hide();
						$("#Availability").text("Out of stock");

					}else{
						$("#cartBtton").show();
						$("#Availability").text("In stock");
					}
				},error:function(){
					alert("error");
				}
			});        
		});		
	});
	
	//......replac main image with alterimage
$(document).ready(function(){

	$(".changeImage").click(function(){
		var image=$(this).attr('src');
		$(".mainImage").attr("src",image);
		//alert(image);
		//console.log("sdf");

	});


});
// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);

			e.preventDefault();

			// Use EasyZoom's `swap` method
			api1.swap($this.data('standard'), $this.attr('href'));
		});

		// Setup toggles example
		var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

		$('.toggle').on('click', function() {
			var $this = $(this);

			if ($this.data("active") === true) {
				$this.text("Switch on").data("active", false);
				api2.teardown();
			} else {
				$this.text("Switch off").data("active", true);
				api2._init();
			}
		});




$(document).ready(function(){
   $("#accountForm").validate({
  	rules:{
 		name:{
 			required:true,
 			minlength:2,
 			accept: "[a-zA-Z]+"
 		},
 		address:{
 			required:true,
 			minlength:2
 		},
 		city:{
 			required:true,
 			minlength:2
 		},
 		state:{
 			required:true,
 			minlength:2
 		},
 		country:{
 			required:true	
 			
 		},
 		pincode:{
 			required:true,
 			minlength:2
 		},
 		mobile:{
 			required:true,
 			minlength:2
 		}
 	
 	  },



 	  messages:{
 	  	name:{
 	  		required:"Please enter your Name",
 	  		minlength:"your Name  must be at least 2 characters long",
 	  		accept:"your Name must contain only letters"
 	  	},
 	  	address:{
 	  		required:"please prodide your address",
 	  		minlength:"your address must be at least 2 characters long"

 	  },
 	   	city:{
 	  		required:"please provide your city",
 	  		minlength:"your city must be at least 2 characters long"

 	  },
 	    state:{
 	  		required:"please provide your state",
 	  		minlength:"your state must be at least 2 characters long"
 	  },
 	  
 	    country:{
 	  		required:"please provide your country"
 	  		
 	  		
 	  },
 	  pincode:{
 	  		required:"please provide your pincode",
 	  		minlength:"your pincode must be at least 2 characters long"

 	  },
 	  mobile:{
 	  		required:"please provide your mobile number",
 	  		minlength:"your mobile must be at least 2 characters long"

 	  }
 	

 	  }	
    });


 	//validate register form..
 	$('#registerForm').validate({
 	rules:{
 		name:{
 			required:true,
 			minlength:2,
 			accept: "[a-zA-Z]+"
 		},
 		password:{
 			required:true,
 			minlength:6
 		},
 		email:{
 			required:true,
 			email:true,
 			remote:"check-email" 
 		}
 	  },



 	  messages:{
 	  	name:{
 	  		required:"Please enter your Name",
 	  		minlength:"your Name  must be at least 2 characters long",
 	  		accept:"your Name must contain only letters"
 	  	},
 	  	password:{
 	  		required:"please provide your password",
 	  		minlength:"your password must be at least 6 characters long"

 	  },
 	  email:{
 	  	required:"please enter your email",
 	  	email:"please enter valid email",
 	  	remote:"Email already exists"
 	  }

 	  }	
 	});

 	////password validation for update
 	$("#passwordForm").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});



 	//validate login form on keyup and submit
 		$('#loginform').validate({
 	rules:{
 		email:{
 			required:true,
 			email:true			
 		},	
 		password:{
 			required:true,			
 		}		
 	  },
 	  messages:{

 	  email:{
 	  	 required:"please enter your email",
 	     email:"please enter valid email"	  	
 	  },	  
 	  	password:{
 	  		required:"please prodide your password"	  
 	  }
 	  }	
 	});
 		//check current user password
 		$("#current_pwd").keyup(function(){
 			var current_pwd=$(this).val();

 			$.ajax({
 				headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
 				type:"post",
 				url:'check-user-pwd',
 				data:{current_pwd:current_pwd},
 				success:function(resp){
 					if(resp=="false"){
					$("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
				}else if(resp=="true"){
					$("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
				}

 				},error:function(){
 					alert("error");
 				}
 			});

 		});

 	//password strengtyh script
 	 $('#myPassword').passtrength({
          minChars: 4,
          passwordToggle: true, 
          tooltip: true,
          eyeImg : "frontend/images/eye.svg"

        });
 	 //copy Billing address to shipping address
 	 $("#copyAddress").click(function(){
 	 	if(this.checked){
 	 		$("#shipping_name").val($("#billing_name").val());
 	 		$("#shipping_address").val($("#billing_address").val());
 	 		$("#shipping_city").val($("#billing_city").val());
 	 		$("#shipping_state").val($("#billing_state").val());
 	 		$("#shipping_country").val($("#billing_country").val());
 	 		$("#shipping_pincode").val($("#billing_pincode").val());
 	 		$("#shipping_mobile").val($("#billing_mobile").val());


 	 	}else{
 	 		$("#shipping_name").val();
 	 		$("#shipping_address").val();
 	 		$("#shipping_city").val();
 	 		$("#shipping_state").val();
 	 		$("#shipping_country").val();
 	 		$("#shipping_pincode").val();
 	 		$("#shipping_mobile").val();
 	 	} 	
 	 });
 });

function selectPaymentMethod(){
	if($('#Paypal').is(':checked') || $('#COD').is(':checked')){
	alert("checked");

}else{
	alert("Please Select a Payment Menthod");
	return false;
	
}
	
	
}

		
