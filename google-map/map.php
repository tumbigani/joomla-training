<!DOCTYPE html>
<html>
  <head>
    <style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
      var lat1= 0;
      var lng1= 0;

        function initialize(name) {
          var address = document.getElementById(name).value;


          var arr = [];
          var x;
          $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address="'+address+'"&sensor=true%27', function(data){
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
      //google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
  <input type="text" name="txt" id="txt">
    <button onclick="initialize('txt');">search</button>
    <div id="map-canvas"></div>

  </body>
</html>