<!DOCTYPE html>
<html>
  <head>

	<script src="https://maps.googleapis.com/maps/api/js"></script>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		var lat1= 0;
		var lng1= 0;
		function showlocation()
		{
		   // One-shot position request.
			navigator.geolocation.getCurrentPosition(callback);
		}
		function callback(position)
		{

			var lat = position.coords.latitude;
			var lon = position.coords.longitude;
			var mapCanvas = document.getElementById('map-canvas');
			var myLatlng = new google.maps.LatLng(lat, lon);
			var mapOptions = {
				center: new google.maps.LatLng(lat, lon),
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(mapCanvas, mapOptions);
	   		var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title:"Current Location"
			});
	  	}

	</script>
  </head>
  <body>
	<button onclick="showlocation();">Your Current Location</button>
	<div id="map-canvas"></div>
  </body>
</html>