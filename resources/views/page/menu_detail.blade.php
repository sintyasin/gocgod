@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2> {{ $query->varian_name }} </h2>

		<div class="col-md-3 col-xs-12">
			<div class="labout">
				<img src={{URL::asset("assets/images/product/". $queryCategory->category_name . "/" . $query->picture)}} style="height:260px;">
			</div>
		</div>

		<div class="col-md-6 col-xs-12">
			<div class="padding_outer_menu">
				<div class="cont1 simpleCart_shelfItem">
					<!-- <h3 class="quick_h3_stock">Stock: <span class="color">{{$query->qty}}</span></h3> -->
					<div class="price_single">
						<!-- <span class="reducedfrom">$140.00</span> -->
						<?php 
						$price = number_format($query->price, 2, ',', '.')
						?>
						<span class="actual">Rp {{$price}}</span>
					</div>

					<h3 class="quick_h3">Deskripsi: </h3>
					<p class="quick_desc"> {{$query->description}}</p>
					<h3 class="quick_h3">Berat: <span class="color"> {{$query->weight}} kg</span></h3> 
				</div>
			</div>
		</div>


		<div class="col-md-3 col-xs-12">
			<div class="padding_outer_menu">
				<div class="border_outer">
					<div class="col-xs-5">
					<h3 class="quick_h3" style="padding-top: 10px"> KUANTITAS: </h3>
					</div>
					<div class="col-xs-5">
						<input type="number" min="1" value="1" class="form-control" id="qty" placeholder="Qty" name="#" style="width: 100px;">
						<input type="hidden" id="name" value="{{ $query->varian_name }}">
						<input type="hidden" id="price" value="{{ $query->price }}">
					</div>

					
					<div class="col-xs-12">
					<br>
					<p class="notes">*Free shipping fee for subcriber or buy more than 5</p>
					</div>
					<div class="position_menu">
						<div class="col-xs-12">
							<a href="#" class="cartBtn" onclick="addtocart({{$query->varian_id}})"><i class="fa fa-shopping-cart" ></i> Tambah</a>
							<a href={{ URL('/checkout_subcriber') }} class="cartBtn" target="_self">Berlangganan</a>
							
						</div>
						<br>
							@if (Auth::guest())
							<br>
							@elseif (Auth::user()->status_user == 0)
							<button class="cartBtnn"> <a href={{ URL('/productsample') }}>Contoh Produk </a></button>
							@else
							<br>
							@endif
					</div>
				</div>
			</div>
		</div>


		<div class="col-md-12 col-xs-12">
			<div class="padding_outer_review">
				@if(Session::has('status'))
				<div class="alert alert-success fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>{{ session('status') }}</strong>
				</div>
				@endif

				<div class="well">

					<div class="panel sauget-accordion">
						<div id="headingFive" role="tab" class="panel-heading">
							<h4 class="panel-title">
							<a class="btn" aria-controls="orderReview" aria-expanded="false" href="#review" data-parent="#accordion" data-toggle="collapse" class="collapsed">
									Klik disini untuk memberikan ulasan produk
								</a>
							</h4>
						</div>
						<div aria-labelledby="headingFive" role="tabpanel" class="panel-collapse collapse" id="review" aria-expanded="false">
							<div class="content-info">
								<div class="review-bar">
									<div class="col-md-12 col-xs-12">
										<div class="product-review">
											@if (Auth::guest())
						                        <a href={{ URL('/register')}} class="testimonial_custom"> Silahkan masuk terlebih dahulu atau klik link ini untuk mendaftar </a>
						                    @else
						                    	<form method="POST" action="{{ url('/review/'. $query->varian_id) }}">
						                    		{!! csrf_field() !!}
							                    	<!-- <input type="hidden" class="form-control" name="varian_id" value="{{ $query->varian_id }}"> -->
							                    	<div class="form-group">
														<label>Nama:</label>
														<input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" style="width: 100%;" disabled> 
													</div>
													<div class="form-group">
														<label>Ulasan:</label>
														<textarea class="form-control" name="testimonial" placeholder="Ulasan Anda" row="12"></textarea>
														@if ($errors->has('testimonial'))
											            <span class="help-block">
											                <strong>{{ $errors->first('testimonial') }}</strong>
											            </span>
											            @endif
													</div>
													<button type="submit" class="checkPageBtn">Submit</button>
												</form>
						                    @endif
												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<hr>

					<?php $i=0; ?>
					@foreach($query_testimonial as $testi)
					<div class="reviews_comment">

						<div class="row">
							<div class="col-md-12">
								<!-- <span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star-empty"></span> -->
								
								
								{{$query_member[$i]->name}}
								<span class="pull-right">{{$testi->created_at}}</span>
								<p>{{$testi->testimonial}}</p>
								
							</div>
						</div>
						<?php $i++; ?>
					</div>
					@endforeach

					


				</div>
			</div>
		</div>


	</div>
</div>

@push('scripts')
<script>
      // $(function () {
      //   $(".rateyo").rateYo({
      //   	fullStar: true,
      //   });
        

      // });

      function addtocart(id){
      	var quantity = $('#qty').val();
      	var name = $('#name').val();
      	var price = $('#price').val();
      	
      	if ($('#qty').val() == 0) alert('Quantity product still blank...');
      	else{
      	$.ajax({
      		url: '{{ URL("/addtocart")}}',
      		type: 'POST',
      		data: {id: id, qty: quantity, name: name, price: price},
      		beforeSend: function(request){
      			return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
      		},
      // 		headers: {
		    //     'X-CSRF-Token': $('meta[name="token"]').attr('content')
		    // }
      	})
      	.done(function(){
      		alert('Added to cart!');
      		window.location.replace('{{URL("/menu_detail")}}'+ '/' + id);
      	})
      	.fail(function(){
      		alert('error');
      	})
      	}
      }
</script>
@endpush

@stop


