	<?php
/**
 * @version     1.0.0
 * @package     com_map
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      gani tumbi <gani@tasolglobal.com> - http://
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_map', JPATH_ADMINISTRATOR);
$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . '/media/jui/js/jquery.min.js');
$document->addScript(JUri::root(true).'/components/com_map/assets/js/map.js');
?>
<style>
#map-canvas {
        width: 500px;
        height: 400px;
      }



 </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script type="text/javascript">
		var directionDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;
		// function for get the driving direction
		function getroute() {

			directionsDisplay = new google.maps.DirectionsRenderer();
			var melbourne = new google.maps.LatLng(-37.813187, 144.96298);
			var myOptions = {
				zoom:12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: melbourne
			}

			map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
			directionsDisplay.setMap(map);
			calcRoute();
		}

		function calcRoute() {
			var start = document.getElementById("start").value;
			var end = document.getElementById("end").value;
			var distanceInput = document.getElementById("distance");

			var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};

			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
					distanceInput.value = response.routes[0].legs[0].distance.value / 1000;
				}
			});
		}
		</script>

<div class="span12">

<div class="btn-group">
	<button class="btn" id="find">Find the address</button>
    <button class="btn" id="current">Get Current Location</button>
    <button class="btn" id="direction">Get The Direction</button>
</div>
<div class="span12"></div>
<div class="find-location">
<input type="text" name="address" id="text">
<button class="btn btn-primary" onclick="initialize('text');">Search</button>

</div>

<div class="current-location">

<button class="btn btn-primary" onclick="showlocation();">Get Your Current Location</button>

</div>

		<div class="direction">


				Start Point : <input type="text" name="start" id="start" />


				End Point : <input type="text" name="end" id="end" />



				<p>Distance (km):
				<input type="text" name="distance" id="distance" readonly="true" /></p>
				<input type="submit" value="Get Route" class="btn btn-primary" onclick="getroute()" />
			</p>
		</div>
		<div id="map-canvas"></div>

</div>
