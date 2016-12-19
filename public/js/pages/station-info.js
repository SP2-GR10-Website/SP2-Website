var mijnAantalStationRequests = 0;
var station = $("#name").val();
var treinTijd = $("#treinTijd").val();

function getStation(actie="initialise"){
  if(actie == "initialise"){
      station = document.getElementById("name").value;
      treinTijd = document.getElementById("treinTijd").value;
  } 
  if(mijnAantalStationRequests == 0)
    $("#rechterdeelId").addSpinner(10, 2, 10, "black", "no replace");
  else
    $("#extraTreinenBtn").addSpinner(5, 1, 5, "white", "replace");

  
  $.ajax({
    url: '/station-info/getStation',
    type: 'GET',
    data: { 'aantalStationRequests': mijnAantalStationRequests,'name': station, 'treinTijd': treinTijd},
    success: function(data){
      if(mijnAantalStationRequests == 0){
        var tekst = "<div id='treinen'>" + data + "</div>";
        tekst += "<a id='extraTreinenBtn' onclick='getStation()'>Extra treinen laden</a>";
        $("#rechterdeelId").html(tekst);
      }
      else{
        $("#treinen").append(data);
      }
      
      mijnAantalStationRequests++;
    }
  });
}

$(document).on('click', '.meerStations', function(){
  var idDropdown = this.id + "stations";
  if($('#' + idDropdown).css("display") == "block"){
    $('#' + idDropdown).css("display", "none");
    $(this).find(".meerStationsIMG").css("background-image", "url('../images/expand.png");
  }
  else{
    $('#' + idDropdown).css("display","block");
    $(this).find(".meerStationsIMG").css("background-image", "url('../images/expand_reverse.png");
  }
});



$(document).ready(function(){

  //Lokale datum instellen
  $("#treinTijd").setLocalDatetime();

  //Stationlijst genereren
  autoComplete("name");
});