jQuery(document).ready(function() {

	jQuery('.find-location').hide();
	jQuery('.current-location').hide();
	jQuery('.direction').hide();
	jQuery('#find').click(function(event) {

		jQuery('.find-location').show();
		jQuery('.current-location').hide();
		jQuery('.direction').hide();

	});
	jQuery('#current').click(function(event) {

		jQuery('.current-location').show();
		jQuery('.find-location').hide();
		jQuery('.direction').hide();
	});
	jQuery('#direction').click(function(event) {
		jQuery('.current-location').hide();
		jQuery('.find-location').hide();
		jQuery('.direction').show();
	});
	 var availableTags = [
"ActionScript",
"AppleScript",
"Asp",
"BASIC",
"C",
"C++",
"Clojure",
"COBOL",
"ColdFusion",
"Erlang",
"Fortran",
"Groovy",
"Haskell",
"Java",
"JavaScript",
"Lisp",
"Perl",
"PHP",
"Python",
"Ruby",
"Scala",
"Scheme"
];
	 jQuery( "#text" ).autocomplete({
source: availableTags
});

});
		var lat1= 0;
    	var lng1= 0;
    	// function for serach address and display map
        function initialize(name) {

          var address = document.getElementById(name).value;


          var arr = [];
          var x;
          jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address="'+address+'"&sensor=true%27', function(data){
            for(var x in data['results'][0]['geometry']['location']){
            arr.push(data[x]);
          }

          lat1 = parseInt(data['results'][0]['geometry']['location']['lat']);
           lng1 = parseInt(data['results'][0]['geometry']['location']['lng']);
         var mapCanvas = document.getElementById('map-canvas');
         var myLatlng = new google.maps.LatLng(lat1, lng1);
         //var myLatlng2 = new google.maps.LatLng( 35.5044752, 97.395555);

        var mapOptions = {
          center: new google.maps.LatLng(lat1, lng1),
          zoom: 3,
          mapTypeId: google.maps.MapTypeId.ROADMAP

        }
        var map = new google.maps.Map(mapCanvas, mapOptions);
       var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    draggable:true,
    title:address
	});
});

  }

  // function for fetch the current location.
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