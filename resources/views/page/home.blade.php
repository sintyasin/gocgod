@extends('layout.main_layout')

@section('content')
<div class="padding_slider">
	@include('include.slide')
</div>
<div class="boa">
	<!-- <img src={{ URL::asset("assets/images/background/untitled-1.jpg") }} data-bgfit="cover" data-bgrepeat="no-repeat"> -->
	<div class="boa_title">
		Be Our Member and Subcribe Our Product!
	</div>
	<div class="boa_caption">
		Get free shipping fee
	</div>
	<a href={{ URL('/login') }} class="boaBtn" target="_self">Become Our Member</a> <a href={{ URL('/menu') }} class="boaBtn" target="_self">Subscribe Our Product</a>
</div>

<!-- <div class="clicktoregister">
<div class="container">
	<div class="padding_menu_bottom">
		<div class="col-md-3 col-xs-12">
			<img src={{ URL::asset("assets/images/logo/capture.png")}} style="padding-bottom: 20px;">
		</div>
		<div class="menu_bottom_caption col-md-9 col-xs-12">
				Healthy Drink with various variants
		</div>
	</div>
</div>
</div> -->
@stop