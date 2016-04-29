
@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class ="padding_outer">
		<h2>Our Menu</h2>
		<?php $i = 0; ?>
		@foreach($query->chunk(4) as $items)
		<div class="row">  
			@foreach ($items as $item)
				<div class='col-md-3 col-sm-4 col-xs-6'>
					<figure class='cap-bot'>
						<a href={{ url("/menu_detail/".$item->varian_id) }}><img src={{ URL::asset("assets/images/product/". $queryCategory[$i]->category_name . "/" . $item->picture) }} class='figure-img img-fluid' alt='Image'></a>
						<!-- <div class="font_menu">
						<a><strong> {{ $item->varian_name }} </strong></a>
						</div> -->
						<figcaption>
							<div class="caption"><b> {{ $item->varian_name }} </b><br><br><small> Stock &nbsp; {{ $item->qty }} </small></div>
						</figcaption>
					</figure>
				</div>
			<?php $i++ ?>
			@endforeach
		</div>
		@endforeach
	</div>
</div>
@stop