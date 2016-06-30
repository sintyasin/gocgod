@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2>How To Buy</h2>

			<div class="row">
   
		    <div class="col-lg-12">
		      <!-- Nav tabs -->
		      <ul class="nav nav-tabs" role="tablist">
		        <li role="presentation" class="active"><a href="#" onclick="first()" aria-controls="home" role="tab" data-toggle="tab">First</a></li>
		        <li role="presentation"><a href="#" onclick="single()" aria-controls="profile" role="tab" data-toggle="tab">Single Buyer</a></li>
		      	<li role="presentation"><a href="#" onclick="subcriber()" aria-controls="profile" role="tab" data-toggle="tab">Subcriber Buyer</a></li>
		      </ul>
		    </div>

		    <div class="col-lg-12">
		      <div id="picture_htb">
		      
		  	  </div>
		  	</div><!-- /.row -->
			<!-- <div class="container">
			<img src={{ URL::asset("assets/images/howtobuy/01.png") }} class='figure-img img-fluid' alt='Image'>
			<hr>
			<img src={{ URL::asset("assets/images/howtobuy/02.png") }} class='figure-img img-fluid' alt='Image'>
			</div> -->
			</div>
			<br>
			<br>
	</div>
</div>

<script>
	function first()
	{
		$.ajax({
			type: "GET",
			url: "{{ URL::to('howtobuyfirst')}}",
			success:
			function(data)
			{
				$('#picture_htb').html(data);
			}
		});
	}

	function single()
	{
		$.ajax({
			type: "GET",
			url: "{{ URL::to('howtobuysingle')}}",
			success:
			function(data)
			{
				$('#picture_htb').html(data);
			}
		});
	}

	function subcriber()
	{
		$.ajax({
			type: "GET",
			url: "{{ URL::to('howtobuysubcriber')}}",
			success:
			function(data)
			{
				$('#picture_htb').html(data);
			}
		});
	}
	
	$(document).ready()
	{
	  first();
	}
</script>

@stop