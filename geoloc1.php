<!DOCTYPE html>
<html>
  <head>
    <title>Geocoding service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
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
#floating-panel {
  position: absolute;
  top: 10px;
  left: 25%;
  z-index: 5;
  background-color: #fff;
  padding: 1px;
  border: 1px solid #999;
  text-align: center;
  font-family: 'Roboto','sans-serif';
  line-height: 30px;
  padding-left: 1px;
}

    </style>
  </head>

<?php
//AIzaSyAnBldurl6R99KHflS3hgO_MqIsEkH8fgQ 
$penama=isset($_REQUEST["penama"])?$_REQUEST["penama"]:"";
$lat=isset($_REQUEST["lat"])?$_REQUEST["lat"]:"";
$lng=isset($_REQUEST["lng"])?$_REQUEST["lng"]:"";

if(empty($lat)){ $lat='3.1577405'; }
if(empty($lng)){ $lng='101.71216700000002'; }
?>
  <body>
    <div id="floating-panel">
      <input id="submit" type="button" value="Get Location">
      <!--<input id="address1" type="textbox" value="">
      <input id="lat" type="text" value="">
      <input id="lng" type="text" value="">-->
    </div>
    <div id="map" style="height: 400px;"></div>
    <script>
	var marker;

	function initMap() {
		var myLatLng = {lat: <?php print $lat;?>, lng: <?php print $lng;?>};
		
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: myLatLng
			//center: {lat: 2.937765, lng: 101.777059}
		});
		
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			draggable: true,
			title: '<?php print $penama;?>'
		});
		

		var geocoder = new google.maps.Geocoder();
		document.getElementById('submit').addEventListener('click', function() {
			geocodeAddress(geocoder, map);
		});

		// GET NEW LOCATION
        google.maps.event.addListener(marker, 'dragend', function(event) {
			// to get the geographical position:
			var pos = marker.getPosition();
			var lat = pos.lat();
			var lng = pos.lng();
			//alert(lat);
            parent.document.getElementById('glat').value = lat;
            parent.document.getElementById('glng').value = lng;
        });
	}
	
	function geocodeAddress(geocoder, resultsMap) {
	  var address = parent.document.getElementById('address').value;
	  //if(address==''){ address = document.getElementById('address1').value; }
	  //alert(address);
	  geocoder.geocode({'address': address}, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
		  resultsMap.setCenter(results[0].geometry.location);
		  var marker = new google.maps.Marker({
			map: resultsMap,
			draggable: true,
			position: results[0].geometry.location
		  });
		  var coords = new google.maps.LatLng(
							results[0]['geometry']['location'].lat(),
							results[0]['geometry']['location'].lng()
						);
		  parent.document.getElementById('glat').value=coords.lat();
		  parent.document.getElementById('glng').value=coords.lng();
		  //map.setCenter(coords);
		  //map.zoom(18);

		// GET NEW LOCATION
        google.maps.event.addListener(marker, 'dragend', function(event) {
			// to get the geographical position:
			var pos = marker.getPosition();
			var lat = pos.lat();
			var lng = pos.lng();
			//alert(lat);
            parent.document.getElementById('glat').value = lat;
            parent.document.getElementById('glng').value = lng;
        });


		} else {
		  alert('Geocode was not successful for the following reason: ' + status);
		}
	  });
	}
	
	function toggleBounce() {
	  if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	  } else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	  }
	}
	

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnBldurl6R99KHflS3hgO_MqIsEkH8fgQ&signed_in=true&callback=initMap"
        async defer></script>
  </body>
</html>