
@extends('layout.main_layout')

@section('content')
<div class="container">
	<br>
	<h2>Lokasi Agen</h2>
	<div class="col-md-12" style="padding-bottom: 50px;">
	<?php $i=0; ?>
		@foreach($queryAgent as $agent)
		<div class="col-md-6">
			<div class="find_location">
			
				<div class="title_location"> {{$agent->name}} </div>
				<div class="data_location" style="padding-left: 10px;">
					 
					 {{$agent->address}} <br>
					 {{$queryCity[$i]->city_name}} <br>
					 {{$agent->phone}} <br>
					 {{$agent->email}}
					
				</div>
				<?php $i++; ?>
			</div>
		</div>
		@endforeach
	</div>
</div>
@stop
