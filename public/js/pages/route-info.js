  function getRoute(){
    var stepOn = $("#stepOn").val();
    var stepOff = $("#stepOff").val();
    var treinTijd = $("#treinTijd").val();

    $("#rechterdeelId").addSpinner(10, 2, 10, "black", "no replace");

    $.ajax({
      url: '/route-info/getRoute',
      type: 'GET',
      data: { 'stepOn': "Vilvoorde",'stepOff': "Oostende", 'treinTijd': treinTijd},
      success: function(data){
        $("#rechterdeelId").html(data);           
      }
    });
}
$(document).ready(function(){

  //Lokale datum instellen
  $("#treinTijd").setLocalDatetime();



  $(".routeInfo-dropdown").click(function(){
    $el = $(this).parent().parent().find(".overstappen");
    if($el.css("display") == "none"){
      $el.show(50);
      $(this).find(".routeInfo-dropdown-img").css("background-image", "url('images/expand_reverse.png')");
    }
    else{
      $el.hide(50);
      $(this).find(".routeInfo-dropdown-img").css("background-image", "url('images/expand.png')");
    }
  });

  //Stationlijst genereren
  autofillStation(["stepOn", "stepOff"]);
});
