<!-- Slider-Section-Strat  -->
	<div class="slider_area">
		<div class="fullwidthbanner">
			<ul>
				<!-- SLIDE-1  -->
				@foreach($query as $data)
					<li data-transition="random" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" >
					<!-- MAIN IMAGE -->
					<img src="{{ URL::asset('assets/images/slider/bg.jpg') }}"  alt="mainbanner-31"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
					<!-- LAYERS -->
					<!-- LAYER NR. 1 -->
					<div class="tp-caption banner1 tp-fade tp-resizeme"
						data-x="910"
						data-y="20" 
						data-speed="300"
						data-start="500"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						data-end="8700"
						data-endspeed="300"
						style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;"><img src="{{ URL::asset('assets/images/slider/') . '/' . $data->picture }}" alt="">
					</div>

					<!-- LAYER NR. 2 -->
					<div class="tp-caption banner12 tp-fade tp-resizeme"
						 data-x="385"
						 data-y="145" 
						data-speed="300"
						data-start="800"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"
						style="z-index: 7;font-size:72px; font-family:nexa_blackregular;font-weight:700;color:#3a4b60;max-width: auto; max-height: auto; white-space: nowrap;"> {{$data->name}}
					</div>

					<!-- LAYER NR. 3 -->
					<div class="tp-caption banner13 tp-fade tp-resizeme"
						data-x="385"
						data-y="190" 
						data-speed="300"
						data-start="1100"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"
						style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;font-size:24px;line-height:26px;font-family:Roboto;font-weight:100; color:#ffffff;letter-spacing:8px;"> {{$data->alias}}
					</div>
					
					<!-- LAYER NR. 4.1 -->
					<div class="tp-caption banner21 tp-fade tp-resizeme"
						data-x="385"
						data-y="273"  
						data-speed="300"
						data-start="800"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"
						style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;font-size:20px;line-height:2;font-family:nexa_bookregular;color:#ffffff;">
						{{$data->description1}}
					</div>
					
					<!-- LAYER NR. 4.2 -->
					<div class="tp-caption banner21 tp-fade tp-resizeme"
						data-x="385"
						data-y="309"
						data-speed="300"
						data-start="1000"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"

						style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;font-size:20px;line-height:2;font-family:nexa_bookregular;color:#ffffff;">
						{{$data->description2}}
					</div>
					
					<!-- LAYER NR. 4.6 -->
					<div class="tp-caption banner23 tp-fade tp-resizeme"
						data-x="385"
						data-y="345" 
						data-speed="300"
						data-start="1700"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"
						style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;font-size:20px;line-height:2;font-family:nexa_bookregular;color:#ffffff;"> HARGA: Rp {{number_format($data->price, 0, ',', '.')}}
					</div>
						
					<!-- LAYER NR. 4.7 -->
					<div class="tp-caption banner2 tp-fade tp-resizeme"
						data-x="385"
						data-y="400" 
						data-speed="300"
						data-start="1800"
						data-easing="Power3.easeInOut"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0"
						data-endelementdelay="0"
						 data-end="8700"
						data-endspeed="300"
						>
						<a class="slide_btn" href="menu" style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;font-size:16px; color:#fff;border: 2px solid #ffffff;line-height:2;padding: 10px 30px;">SHOP NOW</a>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	<!-- Slider-Section-End  -->