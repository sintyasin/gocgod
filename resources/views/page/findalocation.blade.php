
@extends('layout.main_layout')

@section('content')
<div class="container">
	<br>
	<h2>Lokasi Agen</h2>
	<div class="col-md-12" style="padding-bottom: 50px;">
	<?php $i=0; ?>
		@foreach($agent as $agent)
		<div class="col-md-6">
			<div class="find_location">
			
				<div class="title_location"> {{$agent->name}}  <span> - <span style="font-size:15px; color:red;"> Rating: 
				@if(empty($agent->rate))
				Belum Ada Rating
				@else
				{{number_format($agent->rate, 2)}}/5</span>
				@endif</span></div>
				<div class="data_location" style="padding-left: 10px;">
					 
					 {{$agent->address}} <br>
					 {{$agent->city_name}} <br>
					 {{$agent->phone}} <br>
					 {{$agent->email}}
					
				</div>
				<?php $i++; ?>
			</div>
		</div>
		@endforeach
	</div>
</div>

@push('scripts')
<script type="text/javascript">
$(function () {
 
  $("#rateYo").rateYo({
    rating: $("#rateYo").val(),
    readOnly: true
  });
});
</script>
@endpush

@stop
