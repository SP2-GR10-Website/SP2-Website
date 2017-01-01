$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

//Element functies
jQuery.fn.extend({
    addSpinner: function (length, width, radius, kleur, vervang = "replace") {
        var originalHtml = $(this).html();
        var originalEl = $(this);
        var opts = {
            lines: 12,            // The number of lines to draw
            length: length,            // The length of each line
            width: width,             // The line thickness
            radius: radius,           // The radius of the inner circle
            scale: 1.0,           // Scales overall size of the spinner
            corners: 0,           // Roundness (0..1)
            color: kleur,        // #rgb or #rrggbb
            opacity: 1/4,         // Opacity of the lines
            rotate: 0,            // Rotation offset
            direction: 1,         // 1: clockwise, -1: counterclockwise
            speed: 1,             // Rounds per second
            trail: 100,           // Afterglow percentage
            fps: 20,              // Frames per second when using setTimeout()
            zIndex: 2e9,          // Use a high z-index by default
            className: 'spinner', // CSS class to assign to the element
            top: '50%',           // center vertically
            left: '50%',          // center horizontally
            shadow: false,        // Whether to render a shadow
            hwaccel: false,       // Whether to use hardware acceleration (might be buggy)
            position: 'absolute'  // Element positioning
        };

        $(this).html("<div class='ajaxSpinner'></div>");
        var spinner = new Spinner(opts).spin($(".ajaxSpinner")[0]);
        
        //Wanneer ajax klaar is
       if(vervang == "replace"){
          $( document ).ajaxComplete(function() {
              originalEl.html(originalHtml);
          });
        }
    },
    setLocalDatetime : function(){
      var datetime = new Date();
      datetime.setMinutes(datetime.getMinutes() - datetime.getTimezoneOffset());
      var waarde = datetime.toJSON().substr(0, 16);
      $(this).attr("value", waarde);
    }
});

function autoComplete(element) {
  $.ajax({
    url:'/autofillStation',
    type:'GET',
    data:'',
    success:function(data){
      $availableTags = [];
      if(element == "stepOn" || element == "stepOff"){
      $opstapStation = document.getElementById("stepOn").value;
      $afstapStation = document.getElementById('stepOff').value;
    }
      for(i = 0;i<data.length ; i++){
        if(element == "name"){
         $availableTags.push(data[i]); 
        }
        if(element == "stepOn"){
          if($afstapStation == null){
          $availableTags.push(data[i]); 
        }
        else if($afstapStation != data[i])
        {
           $availableTags.push(data[i]);
        }
      }  
      else if(element =="stepOff"){
         if(data[i] != $opstapStation)
         {
          $availableTags.push(data[i]);
        }
      }
    }
  $("#" + element).autocomplete({

      source: $availableTags
    });
    }
  } )
};
function toonLinkerdeel(){
  $(".linkerdeel").toggle("slide");
  if($("#linkerdeel-hamburger").css("left") == "10px"){
    $("#linkerdeel-hamburger").css("left", "215px");
  }
  else{
    $("#linkerdeel-hamburger").css("left", "10px");
  }
}

