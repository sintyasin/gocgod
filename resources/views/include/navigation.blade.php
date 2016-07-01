<header>

	<div class="top_custom">
		<div class="row">
			<div class="col-sm-12 col-sm-12">
				<div class="font_padding"> Healthy Drink with Vitamin C and D</div>
			</div>
		</div>
	</div>


	<div class="container_custom">
		<div class="header_top">
			<div class="row">
				<div class="col-xs-12 col-sm-1">
					<div class="logo head_lo">
						<a href="{{ url('/home') }}"><img src="{{ URL::asset('assets/images/logo/logo.png') }}" alt="Logo" /></a>
					</div>
				</div>
				<div class="col-sm-11">
					<div class="header_top_right text-right">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="https://www.instagram.com/gocgod.id/"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>

							<!-- <li><a href="{{ url('/cart') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart</a></li> -->
							<li><a href="{{ url('/findalocation') }}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari Agent</a></li>



							<!-- Authentication Links -->

							@if (Auth::guest())
							<li class="dropdown">
								<a href=# class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Masuk <span class="caret"> </a>

								<ul id="login-dp" class="dropdown-menu">
									<li>
										<div class="row">
											<div class="col-md-12">
												<form class="form" role="form" method="POST" action="{{ url('/login') }}" accept-charset="UTF-8" id="login-nav">
													{!! csrf_field() !!}
													<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
														<label class="sr-only" for="inputemail">Alamat Email</label>
														<input type="email" class="form-control" id="inputemail" name="email" placeholder="Input Your Email" value="{{ old('email') }}" required>
														@if ($errors->has('email'))
														<script type="text/javascript">
															alert('False Email or Password');
														</script>
														<!-- 						                                    
																<span class="help-block">
						                                        <strong>{{ $errors->first('email') }}</strong>
						                                     	window.alert("False Email or Password");
						                                    </span>
						                                -->						                                    @endif
						                            </div>
						                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						                            	<label class="sr-only" for="inputpassword">Password</label>
						                            	<input type="password" class="form-control" id="inputpassword" placeholder="Password" name="password" required>
						                            	@if ($errors->has('password'))
						                            	<script type="text/javascript">
						                            		alert('False Email or Password');
						                            	</script>
						                                    <!-- <span class="help-block">
						                                        <strong>{{ $errors->first('password') }}</strong>
						                                    </span> -->
						                                    @endif

						                                    <div class="checkbox">
																 <label>
																 <input type="checkbox" name="remember"> Ingat Saya
																 </label>
															</div>


				                                             <div class="help-block text-right"><a href="{{ url('/password/reset') }}">Lupa Password ?</a></div>
														</div>
														<div class="form-group">
															 <button type="submit" class="btn btn-primary btn-block">Sign in</button>
														</div>
												 </form>
											</div>
											<div class="bottom text-center">
												Baru? <a href="{{ url('/register') }}"><b>Klik disini untuk mendaftar</b></a>
											</div>
									</div>
								</li>
							</ul>
	                    @else
	                        <li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  {{ Auth::user()->name }} <span class="caret"></span>
	                            </a>

	                            <ul class="dropdown-menu" role="menu">
	                            	<li><a href="{{ url('/profile/'.Auth::user()->id) }}"><div class="padding_outer_profile">Profile</div></a></li>
	                            	<li><a href="{{ url('/myorder') }}"><div class="padding_outer_profile">Orderku</div></a></li>
	                            	<li><a href="{{ url('/historymyorder') }}"><div class="padding_outer_profile">History Order</div></a></li>
	                                <li><a href="{{ url('/logout') }}"><div class="padding_outer_profile">Logout</div></a></li>
	                            </ul>
	                        </li>
	                    @endif

	                    <li><p>  </p> </li>
						<li><p>  </p> </li>
					</ul>
				</div>
			</div>

			<div class="col-sm-11">
				<div class="mainmenu float-left">
					<nav>
						<ul>
							<li><a href="{{ url('/home') }}">BERANDA</a></li>
							<!-- <li><a href="#">PRODUCT DETAIL</i></a></li> -->
							<li><a href="{{ url('/menu') }}">MENU</a></li>
							<li><a href="{{ url('/howtobuy') }}">CARA BERBELANJA</a></li>
							@if(!Auth::guest() && Auth::user()->status_user == 1)
							<li><a href="{{ url('/becomeanagent') }}">BERGABUNG MENJADI AGEN</a></li>
							@endif
							<li><a href="{{ url('/faq') }}">FAQ</a></li>
							@if(!Auth::guest() && Auth::user()->status_user == 0)
							<li><a href="{{ url('/customerorder')}}">ORDER PELANGGAN</a></li>
							@endif	
							<li class="shop_icon"><a href="#" data-toggle="modal" data-target="#checkout"><img src="{{ URL::asset('assets/images/menu_icon_img.png') }}" alt="" /><span>{{Cart::count()}}</span> Shopping Cart</a></li>
							<!-- <li><a href="{{ url('/checkout') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Check Out</a></li> -->

							<!-- <li><a href="{{ url('/checkout') }}">CHECK OUT</a></li> -->
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- <div class="top_bottom_headercustom">
		<div class="row">
			<div class="col-sm-12 col-sm-6">
			</div>
		</div>
	</div> -->
</header>
<!-- mobile-menu-area start -->
<div class="mobile-menu-area">
	<div class="container">
		<div class="mobile-menu">
			<nav id="dropdown">
				<ul>
					<li><a href="{{ url('/home') }}">BERANDA</a></li>
					<!-- <li><a href="#">PRODUCT DETAIL</a></li> -->
					<li><a href="{{ url('/menu') }}">MENU</a></li>
					<li><a href="{{ url('/howtobuy') }}">CARA BERBELANJA</a></li>
					@if(!Auth::guest() && Auth::user()->status_user == 1)
					<li><a href="{{ url('/becomeanagent') }}">BECOME AN AGENT</a></li>
					@endif
					<li><a href="{{ url('/faq') }}">FAQ</a></li>
					<!-- <li><a href="{{ url('/checkout') }}">CHECK OUT</a></li> -->
					@if(!Auth::guest() && Auth::user()->status_user == 0)
					<li><a href="{{ url('/customerorder')}}">ORDER PELANGGAN</a></li>
					@endif
					<li><a href="#" data-toggle="modal" data-target="#checkout"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>SHOPPING CART</a></li>
<!-- 					<li><a href="{{ url('/checkout') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Check Out</a></li> -->
					
				</ul>
			</nav>
		</div>
	</div>
</div>
<!-- mobile-menu-area end -->


<div class="container_modal">
	<div class="modal fade" id="checkout" tabindex="-1" role="dialog" aira-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal_header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<center>Who are you?</center>
		      </div>

		      <div class="modal-body">
		      <center>
		      <button type="button" class="boaBtn_boa_pf" onclick="single()">
	            I am Single Buyer
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

<script>
function subscribe()
{
	window.location = '<?php echo URL::to('checkout_subcriber'); ?>';
}

function single()
{
	window.location = '<?php echo URL::to('checkout_singlebuyer'); ?>';
}
</script>