function getTrein(){
    var treinId = $("#treinId").val();
    $("#rechterdeelId").addSpinner(10, 2, 10, "black", "no replace");
    
    $.ajax({
      url: '/trein-info/getTrein',
      type: 'GET',
      data: { 'treinId': treinId},
      success: function(data){
        $("#rechterdeelId").html(data);
      },
      error: function(){
        var tekst = '<div class="jumbotron" style="background-color:white">'
            + '<h1 class="text-center">:(</h1>'
            + '<p class="text-center">Er is iets misgegaan, onze oprechte excuses hiervoor.</p>'
            + '</div>';
        $("#rechterdeelId").html(tekst);
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