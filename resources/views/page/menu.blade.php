
@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class ="padding_outer">
		<h2>Produk</h2>
		@foreach($query->chunk(4) as $items)
		<div class="row">  
			@foreach ($items as $item)
				<div class='col-md-3 col-sm-4 col-xs-6'>
					<a href={{ url("/menu_detail/".$item->varian_id) }}>
						<figure class='cap-bot'>
							<img src={{ URL::asset("assets/images/product/". $item->category_name . "/" . $item->picture) }} class='figure-img img-fluid' alt='Image'>
							<!-- <div class="font_menu">
							<a><strong> {{ $item->varian_name }} </strong></a>
							</div> -->
							<figcaption>
								<div class="caption">
								<div class="title_cap"> <b> {{ $item->varian_name }} </b> </div>
								<small> Stock &nbsp; {{ $item->qty }} </small></div>
							</figcaption>
						</figure>
					</a>
				</div>
			@endforeach
		</div>
		@endforeach
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="pull-right"> {!! $query->render() !!} </div>
			</div>
		</div>
	</div>
</div>
@stop