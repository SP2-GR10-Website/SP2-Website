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

/*function validateFields () {
  var email = getElementById("email");
  var naam = getElementById("naam");
  var bericht = getElementById("bericht");

  if(== )
}
*/

function IsEmpty(){
  var check = true;
  if(document.forms['contactUs'].name.value ==="" && document.forms['contactUs'].email.value ==="" && document.forms['contactUs'].message.value ===""){
        alert("Naam en Email en Bericht zijn leeg!");
        check = false;
  }
  if(document.forms['contactUs'].name.value === "" && document.forms['contactUs'].message.value ===""){
        alert("Naam en Bericht zijn leeg!");
     check = false;
  }
  if(document.forms['contactUs'].name.value === "" && document.forms['contactUs'].email.value ===""){
        alert("Naam en Email zijn leeg!");
        check = false;
  }
  if(document.forms['contactUs'].email.value === "" && document.forms['contactUs'].message.value ===""){
        alert("Email en Bericht zijn leeg!");
        check = false;
}
  if(document.forms['contactUs'].name.value === "")
  {
    alert("Naam is leeg!");
        check = false;
  }
  if(document.forms['contactUs'].email.value === "")
  {
    alert("Email is leeg!");
        check = false;
  }
  if(document.forms['contactUs'].message.value === "")
  {
    alert("Bericht is leeg!");
        check = false;
  }
  if(check == true){
    emailChecker();
  }
  }

  function emailChecker(){
    var emailChecker = false;
     var email = document.getElementById("email").value;
     var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    emailChecker = re.test(email);
    if(emailChecker == false){

      alert("Email is niet oke");
    }
    if(emailChecker == true){

      alert("Email is goed verzonden, bedankt!");
      sendMail();
    }
  }

