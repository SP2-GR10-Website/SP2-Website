$(document).ready(function(){
  	function initialize() {
	  var latlng = new google.maps.LatLng(50.841551,4.323024);
    var mapOptions = {
      center: latlng,
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.HYBRID
    };

    map = new google.maps.Map(document.getElementById("apiGoogle"), mapOptions);
    var marker = new google.maps.Marker({position: latlng});
      marker.setMap(map);
    }
  $('#apiGoogle').html(initialize());
});