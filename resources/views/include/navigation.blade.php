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
				<div class="col-sm-11 col-xs-12 ">
					<div class="header_top_right text-center">
						<div class="col-sm-9">
						<ul class="nav navbar-nav navbar-right">
						
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="https://www.instagram.com/gocgod.id/"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						</ul>
						</div>

						<div class="col-sm-3">
							<ul class="nav navbar-nav navbar-center">
								<li><a href="{{ url('/findalocation') }}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Lokasi Agen</a></li>


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
															<input type="email" class="form-control" id="inputemail" name="email_masuk" placeholder="gocgod@gocgod.com" value="{{ old('email') }}" required>
							                            </div>
							                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							                            	<label class="sr-only" for="inputpassword">Password</label>
							                            	<input type="password" class="form-control" id="inputpassword" placeholder="Password" name="password_masuk" required>
							                            	@if (isset($errors))
							                            		@if($errors->has('password_masuk') || $errors->has('email_masuk'))
								                            	<script type="text/javascript">
								                            		alert('Alamat Email atau Password Salah!');
								                            	</script>
							                                    <!-- <span class="help-block">
							                                        <strong>{{ $errors->first('password') }}</strong>
							                                    </span> -->
							                                    @endif
						                                    @endif

							                                    <div class="checkbox text-center">
																	 <label>
																	 <input type="checkbox" name="remember" class="text-center"> Biarkan saya tetap masuk
																	 </label>
																</div>


					                                             <div class="help-block text-center"><a href="{{ url('/password/reset') }}">Lupa Password ?</a></div>
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
								</li>
			                    @else
			                        <li class="dropdown">
			                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
			                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  {{ Auth::user()->name }} <span class="caret"></span>
			                            </a>

			                            <ul class="dropdown-menu" role="menu">
			                            	<li><a href="{{ url('/profile') }}"><div class="padding_outer_profile">Informasi Akun</div></a></li>
			                            	<li><a href="{{ url('/myorder') }}"><div class="padding_outer_profile">Pesananku</div></a></li>
			                            	<li><a href="{{ url('/historymyorder') }}"><div class="padding_outer_profile">Riwayat Pesanan</div></a></li>
			                                <li><a href="{{ url('/logout') }}"><div class="padding_outer_profile">Keluar</div></a></li>
			                            </ul>
			                        </li>
			                    @endif
							</ul>
                    	</div>
					</div>
				</div>

				<div class="col-sm-11">
					<div class="mainmenu float-left">
						<nav>
							<ul>
								<li><a href="{{ url('/home') }}">BERANDA</a></li>
								<!-- <li><a href="#">PRODUCT DETAIL</i></a></li> -->
								<li><a href="{{ url('/menu') }}">PRODUK</a></li>
								<li><a href="{{ url('/howtobuy') }}">CARA BERBELANJA</a></li>
								@if(!Auth::guest() && Auth::user()->status_user == 1)
								<li><a href="{{ url('/becomeanagent') }}">BERGABUNG MENJADI AGEN</a></li>
								@endif
								<li><a href="{{ url('/faq') }}">FAQ</a></li>
								@if(!Auth::guest() && Auth::user()->status_user == 0)
								<li><a href="{{ url('/customerorder')}}">PESANAN PELANGGAN</a></li>
								@endif	
								<li class="shop_icon"><a href="#" data-toggle="modal" data-target="#checkout"><img src="{{ URL::asset('assets/images/cart.png') }}" alt="" /><span id='cart-count'>{{Cart::count()}}</span> Shopping Cart</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<!-- mobile-menu-area start -->
<div class="mobile-menu-area">
	<div class="container">
		<div class="mobile-menu">
			<nav id="dropdown">
				<ul>
					<li><a href="{{ url('/home') }}">BERANDA</a></li>
					<!-- <li><a href="#">PRODUCT DETAIL</a></li> -->
					<li><a href="{{ url('/menu') }}">PRODUK</a></li>
					<li><a href="{{ url('/howtobuy') }}">CARA BERBELANJA</a></li>
					@if(!Auth::guest() && Auth::user()->status_user == 1)
					<li><a href="{{ url('/becomeanagent') }}">BERGABUNG MENJADI AGEN</a></li>
					@endif
					<li><a href="{{ url('/faq') }}">FAQ</a></li>
					@if(!Auth::guest() && Auth::user()->status_user == 0)
					<li><a href="{{ url('/customerorder')}}">PESANAN PELANGGAN</a></li>
					@endif
					<li><a href="#" data-toggle="modal" data-target="#checkout"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>SHOPPING CART</a></li>
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