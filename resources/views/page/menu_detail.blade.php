@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2> {{ $query->varian_name }} </h2>

		<div class="col-md-3 col-xs-12">
			<div class="labout">
				<img src={{URL::asset("assets/images/product/". $queryCategory->category_name . "/" . $query->picture)}}>
			</div>
		</div>

		<div class="col-md-6 col-xs-12">
			<div class="padding_outer_menu">
				<div class="cont1 simpleCart_shelfItem">
					<h3 class="quick_h3_stock">Stock: <span class="color">{{$query->qty}}</span></h3>
					<div class="price_single">
						<!-- <span class="reducedfrom">$140.00</span> -->
						<span class="actual">Rp {{$query->price}},00</span>
					</div>

					<h3 class="quick_h3">Description: </h3>
					<p class="quick_desc"> {{$query->description}}</p>
					<h3 class="quick_h3">Weight: <span class="color"> {{$query->weight}} kg</span></h3> 
					<label class="quick_h3"> Quantity: </label>
					<input type="text" class="form-control" placeholder="Qty" name="#" style="width: 25%;"> 
					
					<p class="notes">*Free shipping fee for subcriber or buy more than 5</p>
					<a href="#" class="cartBtn" target="_self">Add to cart</a> <a href="#" class="cartBtn" target="_self">Subscribe</a>
				</div>
			</div>
		</div>


		<div class="col-md-3 col-xs-12">
			<div class="padding_outer_menu">
			</div>
		</div>


		<div class="col-md-12 col-xs-12">
			<div class="padding_outer_review">
				<div class="well">

					<div class="panel sauget-accordion">
						<div id="headingOne" role="tab" class="panel-heading">
							<h4 class="panel-title">
							<a class="btn" aria-controls="orderReview" aria-expanded="true" href="#review" data-parent="#accordion" data-toggle="collapse" class="collapsed">
									Leave a Review Click Here
								</a>
							</h4>
						</div>
						<div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="review" aria-expanded="false">
							<div class="content-info">
								<div class="review-bar">
									<div class="col-xs-12 col-sm-6">
										<div class="product-review">
											<label>Quality:</label>
											<p>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
											</p>
											<form>
												<div class="form-group">
													<label for="exampleInputEmail1">Name:</label>
													<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Your Name" style="width: 100%;">
												</div>
												<div class="form-group">
													<label>Review:</label>
													<textarea class="form-control"  placeholder="Your Review" row="12"></textarea>
												</div>
												<button type="submit" class="checkPageBtn">Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<hr>

					<div class="reviews_comment">
						<div class="row">

							<div class="col-md-12">
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								Anonymous
								<span class="pull-right">10 days ago</span>
								<p>This product was great in terms of quality. I would definitely buy another!</p>
							</div>
						</div>
					</div>

					<hr>


				</div>
			</div>
		</div>


	</div>
</div>
@stop