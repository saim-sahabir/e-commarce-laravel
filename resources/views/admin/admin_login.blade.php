<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Matrix Admin</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('backend/css/bootstrap-responsive.min.css')}}" />
        <link rel="stylesheet" href="{{asset('backend/css/matrix-login.css')}}" />
        <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">    
         @if(Session::has('message'))
         <div class="alert alert-error alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong> {{ Session('message') }}</strong>
        </div>
        @endif
          @if(Session::has('success'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong> {{ Session('success') }}</strong>
        </div>
        @endif

            <form id="loginform" class="form-vertical" action="{{ url('/admin') }}" method="post">
            	      {{ csrf_field() }}
				 <div class="control-group normal_text"> <h3><img src="{{asset('backend/img/logo.png')}}" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input id="email" type="email" name="email" placeholder="email" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="password" type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><input type="submit" value="Lost password?" class="flip-link btn btn-info" id="to-recover"></input></span>
                    <span class="pull-right"><input type="submit" value="Login"  class="btn btn-success" /></input></span>
                
            </form>

            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="{{asset('backend/js/jquery.min.js')}}"></script>  
        <script src="{{asset('backend/js/matrix.login.js')}}"></script> 
        <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>

    </body>

</html>
