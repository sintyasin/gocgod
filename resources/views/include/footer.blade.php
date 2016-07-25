<div class="footer_middel footer-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="footer_link address">
					<p>go C go D</p>
					<ul>
						<li><span>Alamat: </span> {{$contact->address}} </li>
						<li><span>WhatsApp: </span>{{$contact->phone}} ({{$contact->name}})</li>
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
					<p>Akun Saya</p>
					<ul>
						@if(Auth::guest())
						<li><a href="#">Informasi Akun</a></li>
						<li><a href="#">Shopping Cart</a></li>
						@else
						<li><a href="{{ url('/profile/{id}') }}">Informasi Akun</a></li>
						<li><a href="{{ url('/checkout') }}">Shopping Cart</a></li>
						@endif
						
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="footer_link res_mar">
					<p>Bantuan</p>
					<ul>
						<li><a href="{{ url('/howtobuy') }}">Cara Berbelanja</a></li>
						<li><a href="{{ url('/faq')}}"> FAQ </a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="footer_link res_mar">
					<p>Informasi</p>
					<ul>
						<li><a href="{{ url('/findalocation') }}">Lokasi Agen</a></li>
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
			<!-- <div class="col-sm-6 col-xs-12">
				<div class="copyright_icon text-right">
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-1.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-2.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-3.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-4.png') }}" alt="" /></a>
					<a href="#"><img src="{{ url('/assets/images/footer/paypal-5.png') }}" alt="" /></a>
				</div>
			</div> -->
		</div>
	</div>
</div>