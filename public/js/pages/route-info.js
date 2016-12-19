  function getRoute(){
    var stepOn = $("#stepOn").val();
    var stepOff = $("#stepOff").val();
    var treinTijd = $("#treinTijd").val();

    $("#rechterdeelId").addSpinner(10, 2, 10, "black", "no replace");

    $.ajax({
      url: '/route-info/getRoute',
      type: 'GET',
      data: { 'stepOn': stepOn,'stepOff': stepOff, 'treinTijd': treinTijd},
      success: function(data){
        $("#rechterdeelId").html(data);           
      }
    });
}
$(document).ready(function(){

  //Lokale datum instellen
  $("#treinTijd").setLocalDatetime();
  //Stationlijst genereren
  autoComplete("stepOn");
  autoComplete("stepOff");
});
