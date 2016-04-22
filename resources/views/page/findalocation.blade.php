
@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="googlemap_custom">
		<div id="googleMap"></div>
	</div>
</div>

<!-- Google Map js -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
	function initialize() {
		var mapOptions = {
			zoom: 15,
			scrollwheel: false,
			center: new google.maps.LatLng(40.663293, -73.956351)
		};
		var map = new google.maps.Map(document.getElementById('googleMap'),
			mapOptions);
		var marker = new google.maps.Marker({
			position: map.getCenter(),
			animation:google.maps.Animation.BOUNCE,
			icon: 'assets/images/map-marker.png',
			map: map
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>  
<!-- main js -->

@stop

