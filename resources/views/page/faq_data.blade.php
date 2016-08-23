<div class="clicktoregister">
	<div class="col-md-12 col-xs-12">

	<?php $i=1; ?>
	@foreach($query_faq as $faq)
		<div class="faq">
			<div class="faq_title">
				<h4><?php echo $i ?>. &nbsp{!! $faq->question !!}</h4>
			</div>
			<div class="faq_answer">
				{!! $faq->answer !!}
			</div>
			<br>
		</div>
	<?php $i++;?>
	@endforeach

	</div>
</div>