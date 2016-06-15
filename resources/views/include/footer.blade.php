<!-- <div class="footer_top footer-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-sm-6">
				<div class="newsletter">
					<h4>Sign up for newSletter</h4>
				</div>
			</div>
			<div class="col-sm-12 col-sm-6">
				<div class="newsletter text-right">
					<input class="news_input" type="text" value="" placeholder="Email Address"/>
					<input class="subscribe_btn" type="button" value="subscribe"/>
				</div>
			</div>
		</div>
	</div>
</div> -->
<div class="footer_middel footer-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="footer_link address">
					<p>go C go D</p>
					<ul>
						<li><span>Address: </span> Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk</li>
						<li><span>WA: </span>0811-139318 (Baby)</li>
					</ul>
				</div>
				<div class="footer_icon">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://www.instagram.com/gocgod.id/"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="footer_link">
					<p>My Account</p>
					<ul>
						@if(Auth::guest())
						<li><a href="#">My Account</a></li>
						<li><a href="#">Check Out</a></li>
						@else
						<li><a href="{{ url('/profile/{id}') }}">My Account</a></li>
						<li><a href="{{ url('/checkout') }}">Check Out</a></li>
						@endif
						
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="footer_link res_mar">
					<p>Customer Support</p>
					<ul>
						<li><a href="{{ url('/howtobuy') }}">Shipping Guide</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="footer_link res_mar">
					<p>information</p>
					<ul>
						<li><a href="{{ url('/findalocation') }}">Our Agent Location</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer_bottom footer-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="copyright_icon text-right">
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-1.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-2.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-3.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-4.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-5.png') }}" alt="" /></a>
				</div>
			</div>
		</div>
	</div>
</div>