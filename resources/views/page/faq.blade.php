@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2>Frequent Asked Question</h2>

		<div class="clicktoregister">
		<div class="col-md-12 col-xs-12">

		<?php $i=1; ?>
		@foreach($query_faq as $faq)
			<div class="faq">
				<div class="faq_title">
					<?php echo $i ?>. &nbsp{!! $faq->question !!}
				</div>
				<div class="faq_answer">
					{!! $faq->answer !!}
				</div>
			</div>
		<?php $i++;?>
		@endforeach
		</div>
		</div>
		
	</div>
</div>
@stop