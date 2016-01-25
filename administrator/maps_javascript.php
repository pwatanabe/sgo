<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div style="width:400px; height: 400px;"id="map"></div>
    <script>

var map;
function initMap() {
  
  var originalMapCenter = new google.maps.LatLng(-25.363882, 131.044922)
  var lat = document.getElementById('lat').value;
  var long = document.getElementById('long').value;
  
  if(lat != "" && long !=""){
    var originalMapCenter = new google.maps.LatLng(lat, long);
  }
  var map = new google.maps.Map(document.getElementById('map'),{
    mapTypeId: google.maps.MapTypeId.SATELLITE,/*ROADMAP*/
    scrollwheel: false,
    zoom: 15,
    center: originalMapCenter
  });

  var infowindow = new google.maps.InfoWindow({
    content: 'Aqui é sua Obra',
    position: originalMapCenter
  });
  infowindow.open(map);

  map.addListener('zoom_changed', function() {
    infowindow.setContent('Zoom: ' + map.getZoom());
  });
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPnNgPERfFRTJYYW4zt9lZ0njBseIdi1I&callback=initMap"async defer></script>
        <input type="text" id="lat" name="lat"   onchange="initMap()">
        <input type="text" id="long" name="long" onchange="initMap()">
        
  </body>
</html>