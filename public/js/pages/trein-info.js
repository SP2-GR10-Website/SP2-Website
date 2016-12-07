function getTrein(){
    var treinId = $("#treinId").val();
    $("#rechterdeelId").addSpinner(10, 2, 10, "black", "no replace");
    
    $.ajax({
      url: '/trein-info/getTrein',
      type: 'GET',
      data: { 'treinId': treinId},
      success: function(data){
        $("#rechterdeelId").html(data);
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