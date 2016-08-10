@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2> {{ $query->varian_name }} </h2>
		
		<div class="col-md-3 col-xs-12">
			<div class="labout">
				<img src={{URL::asset("assets/images/product/". $query->category_name . "/" . $query->picture)}} style="height:260px;">
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
					<p class="notes">*Gratis ongkos kirim bagi yang berlangganan atau total pembelian lebih dari 5</p>
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
							<a href={{ URL('/productsample') }}> <button class="cartBtnn"> Contoh Produk </button> </a>
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
							Beri Ulasan Produk
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
					<div id="testimonial">

					</div>
					
				</div>

					
					<div class="modal fade" id="myModal_added" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
			          <div class="modal-dialog" role="document">
			            <div class="modal-content">
			              <div class="modal_header">
			                  <center>Cart Telah Ditambahkan</center>
			              </div>
			              <div class="modal-body">
			                <center>
			                <a href={{ url("/menu") }} class="cartBtn"> Kembali Berbelanja </a>
			                
			                <br>
			                <br>
			                <a href="#" class="cartBtn" data-toggle="modal" data-target="#checkout" data-dismiss="modal"> Lanjutkan Ke Pembayaran</a>
			                </center>

			              </div>
			            </div>
			          </div>
			        </div>

					<div class="modal fade" id="checkout" tabindex="-1" role="dialog" aira-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal_header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        	<center>Lanjutkan ke Pembayaran</center>
						      </div>

						      <div class="modal-body">
						      <center>
						      <button type="button" class="boaBtn_boa_pf" onclick="single()">
					            Sekali Membeli
					          </button>
					          <a href="{{ url('/checkout_subcriber')}}"><button type="button" class="boaBtn_boa_pf">
					            Berlangganan
					           
					          </button>
					          </a>
					            <br><br><p>*Gratis ongkos kirim untuk yang berlangganan atau pembelian dengan total kuantitas lebih dari 5</p>
						      </div>
						      </center>
					      	</div>
					    </div>
					</div>

				</div>
			</div>
		</div>


	</div>
</div>

@push('scripts')
<script>
	$(document).ready(function()
	{
		var url = "<?php echo URL::to('testimonial_data/'. $query->varian_id) ?>";
		$('#testimonial').load(url);
		// $.ajax({
		// 	type:"GET",
		// 	url: "{{ URL::to('testimonial_data/'. $query->varian_id)}}",
		// 	success:
		// 	function(data)
		// 	{
		// 		$('#testimonial').html(data);
		// 	}
		// });
	});

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
      		$('#myModal_added').modal('show');
      		// window.location.replace('{{URL("/menu_detail")}}'+ '/' + id);
      	})
      	.fail(function(){
      		alert('error');
      	})
      	}
    }
</script>
@endpush

@stop


