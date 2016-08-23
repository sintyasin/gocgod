@extends('layout.main_layout')

@section('content')

<div class="container">	
	<div class="padding_outer">
		<h2>Frequently Asked Question</h2>

		<div id="faq_data">
		</div>
	</div>
</div>

@push('scripts')
<script>
$(document).ready()
{
	$.ajax({
    type: "GET",
    url: "{{ URL::to('faq_data') }}",
    success:
    function(data)
	    {
	      $('#faq_data').html(data);
	    }
  	});
}
</script>
@endpush
@stop