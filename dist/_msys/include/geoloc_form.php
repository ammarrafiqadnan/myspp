<?php 
// include_once '../../common.php';
// include_once '../../security.php';

?>

<script>
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 18,
    center: {lat: 2.937765, lng: 101.777059}
  });
  var geocoder = new google.maps.Geocoder();

  document.getElementById('submit').addEventListener('click', function() {
    geocodeAddress(geocoder, map);
  });
}

function geocodeAddress(geocoder, resultsMap) {
  var address = parent.document.getElementById('add').value;
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
      });
	  var coords = new google.maps.LatLng(
						results[0]['geometry']['location'].lat(),
						results[0]['geometry']['location'].lng()
					);
	  parent.document.getElementById('glat').value=coords.lat();
	  parent.document.getElementById('glng').value=coords.lng();
	  map.setCenter(coords);
	  map.setZoom(18);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDay7r2XcQtONsBrlx_vc4l-KKoHdOqQFk&signed_in=true&callback=initMap"
        async defer></script>
