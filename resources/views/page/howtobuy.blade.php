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
		      <br><br>
		      <center>
		      <h1>1</h1><h2>Click Join Us</h2>
		      </center>
		      <img src={{ URL::asset("assets/images/howtobuy/01.png") }} class='figure-img img-fluid' alt='Image'>
		  	  <hr style="color:black;">
		  	  <center>
		      <h1>2</h1><h2>Register to be a Member</h2>
		      </center>
		      <img src={{ URL::asset("assets/images/howtobuy/02.png") }} class='figure-img img-fluid' alt='Image'>
		  	  <hr style="color:black;">
		  	  <center>
		      <h1>3</h1><h2>To See the Menus</h2>
		      </center>
		      <img src={{ URL::asset("assets/images/howtobuy/03.png") }} class='figure-img img-fluid' alt='Image'>
		      <br>
		      <img src={{ URL::asset("assets/images/howtobuy/04.png") }} class='figure-img img-fluid' alt='Image'>
		  	</div><!-- /.row -->
			<!-- <div class="container">
			<img src={{ URL::asset("assets/images/howtobuy/01.png") }} class='figure-img img-fluid' alt='Image'>
			<hr>
			<img src={{ URL::asset("assets/images/howtobuy/02.png") }} class='figure-img img-fluid' alt='Image'>
			</div> -->
			</div>
		
	</div>
</div>

@stop