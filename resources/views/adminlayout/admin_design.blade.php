<!DOCTYPE html>
<html lang="en">
<head>
<title>Matrix Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/bootstrap-responsive.min.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/uniform.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/select2.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/fullcalendar.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/matrix-style.css')}}" />
<link rel="stylesheet" href="{{asset('backend/css/matrix-media.css')}}" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
<link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('backend/css/jquery.gritter.css')}}" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body>

 



@include('adminlayout.admin_header') 
@include('adminlayout.admin_sidebar')



@yield('content')

@include('adminlayout.admin_footer')





<script src="{{asset('backend/js/jquery.min.js')}}"></script> 
<!-- <script src="{{asset('backend/js/jquery.ui.custom.js')}}"></script>  -->
<script src="{{asset('backend/js/bootstrap.min.js')}}"></script>  
<script src="{{asset('backend/js/jquery.uniform.js')}}"></script>
<script src="{{asset('backend/js/select2.min.js')}}"></script> 
<script src="{{asset('backend/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/js/jquery.validate.js')}}"></script> 
<script src="{{asset('backend/js/matrix.js')}}"></script> 
<script src="{{asset('backend/js/matrix.form_validation.js')}}"></script>
<script src="{{asset('backend/js/matrix.tables.js')}}"></script>
<script src="{{ asset('backend/js/matrix.popover.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
  $( function(){
    $("#expiry_date").datepicker({
    	minDate: 0,
    	dateFormat: 'yy-mm-dd'
    });
  });
 </script>





</body>
</html>
