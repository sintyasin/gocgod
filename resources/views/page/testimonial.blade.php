@foreach($data as $testi)
	<div class="reviews_comment">

		<div class="row">
			<div class="col-md-12">
				{{$testi->name}}
				<span class="pull-right">{{$testi->created_at}}</span>

				<p style="-ms-word-break: break-all; word-break: break-all; word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto;">
				{{$testi->testimonial}}
				</p>

			</div>
		</div>
	</div>
@endforeach
<?php $data->links(); ?>

<div class="reviews_comment" style="text-align:right; border-bottom: none;"> {!! $data->render() !!} </div>

<script>
$( document ).ready(function() {
	$('.pagination a').on('click', function(event) {
		event.preventDefault();
		if ($(this).attr('href') != '#') {
			$('#testimonial').load($(this).attr('href'));
		}
	});
});
</script>