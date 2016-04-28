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
				<div class="header_line_custom">
				</div>
			</div>
			<div class="col-sm-11">
				<div class="header_top_right text-right">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://www.instagram.com/gocgod.id/"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><p> | </p> </li>
						<li><p>  </p> </li>
						<li><p>  </p> </li>
						<!-- <li><a href="{{ url('/cart') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart</a></li> -->
						<li><a href="{{ url('/findalocation') }}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Find an Agent</a></li>
						


	                    <!-- Authentication Links -->
	                    @if (Auth::guest())
	                        <li><a href="{{ url('/login') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign In</a></li>
	                    @else
	                        <li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  {{ Auth::user()->name }} <span class="caret"></span>
	                            </a>

	                            <ul class="dropdown-menu" role="menu">
	                                <li><a href="{{ url('/logout') }}"><div class="padding_outer"><i class="fa fa-btn fa-sign-out"></i>Logout</div></a></li>
	                            </ul>
	                        </li>
	                    @endif

	                    <li><p>  </p> </li>
						<li><p>  </p> </li>

						<li class="searchbox">
							<input type="search" placeholder="Search......" name="search" class="searchbox-input" onkeyup="buttonUp();" required>
							<input type="submit" class="searchbox-submit" value="">
							<span class="searchbox-icon"><i class="fa fa-search"></i></span>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-sm-11">
				<div class="mainmenu float-left">
					<nav>
						<ul>
							<li><a href="{{ url('/home') }}">HOME</a></li>
							<!-- <li><a href="#">PRODUCT DETAIL</i></a></li> -->
							<li><a href="{{ url('/menu') }}">MENU</a></li>
							<li><a href="{{ url('/howtobuy') }}">HOW TO BUY</a></li>
							<li><a href="{{ url('/becomeanagent') }}">BECOME AN AGENT</a></li>
							<li><a href="{{ url('/faq') }}">FAQ</a></li>
							<li><a href="{{ url('/checkout') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Check Out</a></li>
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
					<li><a href=""{{ url('/home') }}"">HOME</a></li>
					<!-- <li><a href="#">PRODUCT DETAIL</a></li> -->
					<li><a href="{{ url('/menu') }}">MENU</a></li>
					<li><a href="{{ url('/howtobuy') }}">HOW TO BUY</a></li>
					<li><a href="{{ url('/becomeanagent') }}">BECOME AN AGENT</a></li>
					<li><a href="{{ url('/faq') }}">FAQ</a></li>
					<!-- <li><a href="{{ url('/checkout') }}">CHECK OUT</a></li> -->
					<li><a href="{{ url('/checkout') }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Check Out</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<!-- mobile-menu-area end -->