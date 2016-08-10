<html>
<head>
	<title></title>

</head>
<body>

<!-- HEADER -->
<div class="top_custom" style="overflow:hidden; background:rgb(1,117,96) none repeat scroll 0 0; overflow:hidden; height:40px; width:100%;">
		<div class="col-sm-12 col-sm-12">
			<div class="font_padding" style="text-align: center; font-size:20px; font-family: calibri; font-weight: bold; padding:10px; color:white;"> GoCGoD - Healthy Drink with Vitamin C and D</div>
		</div>
	</div>




@yield('content')





<!-- FOOTER -->
<div class="top_custom" style="overflow:hidden; background:rgb(1,117,96) none repeat scroll 0 0; overflow:hidden; height:100px; width:100%;">
		<div class="col-sm-12 col-sm-12">
			<br>
			<div class="font_padding" style="font-size:15px; font-family: calibri; padding:10px; color:white;"> <span style="font-size:20px; font-weight: bold;"> GoCGoD </span><br> <span style="font-weight:bold">Alamat:</span> <span>{{$contact->address}}</span> 
				<br> <span style="font-weight:bold">WhatsApp: </span> <span>{{$contact->phone}}</span>
			</div>
		</div>
	</div>

</body>
</html>