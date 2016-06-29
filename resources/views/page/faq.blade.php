@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2>Frequent Asked Question</h2>

		<div class="clicktoregister">
		<div class="col-md-12 col-xs-12">
		@foreach($query_faq as $faq)
			<div class="faq">
				<div class="faq_title">
					{{$faq->question_id}}. &nbsp{!! $faq->question !!}
				</div>
				<div class="faq_answer">
					{!! $faq->answer !!}
				</div>
			</div>
		@endforeach
		</div>
		</div>
		
	</div>
</div>
@stop