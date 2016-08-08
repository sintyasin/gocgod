@extends('layout.404_layout')

@section('content')
<div class="container" style="position: absolute; top: 50%;left: 50%; transform: translateX(-50%) translateY(-50%);">
<center>
	<a href="{{URL('/home')}}"><img src="{{ URL::asset('assets/images/404.png') }}"/></a>
</center>
</div>
@stop