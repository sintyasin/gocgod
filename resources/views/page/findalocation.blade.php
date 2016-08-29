
@extends('layout.main_layout')

@section('content')
<div class="container">
	<br>
	<h2>Lokasi Agen</h2>
	<div class="col-md-12" style="padding-bottom: 50px;">
	<?php $i=0; ?>
		@foreach($agent as $agentlocation)
		<div class="col-md-6">
			<div class="find_location">
			
				<div class="title_location"> {{$agentlocation->name}}  <span> - <span style="font-size:15px; color:red;"> Rating: 
				@if(empty($agentlocation->rate))
				Belum Ada Rating
				@else
				{{number_format($agentlocation->rate, 2)}}/5</span>
				@endif</span></div>
				<div class="data_location" style="padding-left: 10px;">
					 
					 {{$agentlocation->address}} <br>
					 {{$agentlocation->city_name}} <br>
					 {{$agentlocation->phone}} <br>
					 {{$agentlocation->email}}
					
				</div>
				<?php $i++; ?>
			</div>
		</div>
		@endforeach
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="pull-right"> {!! $agent->render() !!} </div>
		</div>
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
