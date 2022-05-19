


<?php  $url=url()->current(); ?>

<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if (preg_match("/dashboard/i",$url)) {?> class="active" <?php }?>><a href="{{url('/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>categories</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/categor/i",$url)) {?> style="display: block;" <?php }?>>
        <li <?php if (preg_match("/add-category/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/add-category') }}">Add Category</a></li>
        <li <?php if (preg_match("/view-categories/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/view-categories') }}">View Categories</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/product/i",$url)) {?> style="display: block;" <?php }?>>
        <li  <?php if (preg_match("/add-product/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/add-product') }}">Add Product</a></li>
        <li  <?php if (preg_match("/view-products/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/view-products') }}">View Products</a></li>
      </ul>
    </li>
       <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/coupon/i",$url)) {?> style="display: block;" <?php }?>>
        <li  <?php if (preg_match("/add-coupon/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/add-coupon') }}">Add Coupons</a></li>
        <li  <?php if (preg_match("/view-coupons/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/view-coupons') }}">View Coupons</a></li>
      </ul>
    </li>
     <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banner</span> <span class="label label-important">2</span></a>
      <ul  <?php if (preg_match("/banner/i",$url)) {?> style="display: block;" <?php }?>>
        <li <?php if (preg_match("/add-banner/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/add-banner') }}">Add Banner</a></li>
        <li <?php if (preg_match("/view-banner/i",$url)) {?> class="active" <?php }?>><a href="{{ url('/admin/view-banner') }}">View Banner</a></li>
      </ul>
    </li>
 
    
   
  </ul>
</div>
<!--sidebar-menu-->

