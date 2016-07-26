@extends('layout.main_layout')

@section('content')
@if (session('active'))
	<div class="alert alert-success">
	    {{ session('active') }}
	</div>
@elseif (session('login'))
	<div class="alert alert-danger">
	    {{ session('login') }}
	</div>
@endif
<div class="padding_slider">
	@include('include.slide')
</div>
<div class="padding_slider_1">
	<img src="{{ URL::asset('assets/images/mobile.png') }}" alt="Logo" />
</div>
<div class="boa">
	<div class="boa_title">
		Be Our Member and Subcribe Our Product!
	</div>
	<div class="boa_caption">
		Get free shipping fee
	</div>
	<a href={{ URL('/register') }} class="boaBtn" target="_self">Become Our Member</a> <a href={{ URL('/menu') }} class="boaBtn" target="_self">Subscribe Our Product</a>
</div>
@stop