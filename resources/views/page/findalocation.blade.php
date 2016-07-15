
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
			
				<div class="title_location"> {{$agent->name}}  <span> - <span style="font-size:15px; color:red;"> Rating: {{number_format($rating[$i][0]->rate, 2)}}/5</span> <!-- <div id="rateYo" value="{{$rating[$i][0]->rate}}"></div> --></span></div>
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
