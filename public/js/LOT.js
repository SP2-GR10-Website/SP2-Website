
//GLOBAL VARS
var expand = false;
var backupitems = [];
var selectedbackups = [];
var selectedDupEntries = [];
var openmenu = [];
var backupmenu = 1;

//AJAX PROGRESS BAR
/*class AjaxBar {
    constructor(locatieId, id, className){
        this.locatieId = locatieId;
        this.id = id;
        this.className = className;
        var html = "";
        html += "<div class='nanobar " + className + "' id='"+ id + "'>";
        html += "<div class='bar " + className + "'></div>";
        html += "</div>";
        $("#" + locatieId).append(html);
    }
    setWidth(width){
        $("#" + this.id).find(".bar").css({"width" : width + "%"});
    }
}*/

//Ajax Spinner
jQuery.fn.extend({
    toonMenu : function(){
        if($(this).attr("id") == "backpopup"){
            $.ajax({
                type: "GET",
                url: "/minidagboek/backups/initialise",
                data: '',
                success: function(data) {
                    $("#backupitemscont3").html(data);
                }
            });
        }
        $(this).css("display", "inline");
        $("body").css("overflowY", "hidden");

        //setTimeout(function(){
        openmenu.push($(this).attr('id'));
        console.log(openmenu.length);
        $("#" + openmenu[openmenu.length-1]).css("background-color", "rgba(130, 130, 130, 0.61)");
        if(openmenu.length > 1){
            $("#" + openmenu[openmenu.length-2]).css("background-color", "transparent");
        }
        //}, 100);
        
    },
    hideMenu : function(){
        $(this).css("display", "none");
        $("body").css("overflowY", "scroll");
        openmenu.pop();
        $("#" + openmenu[openmenu.length-1]).css("background-color", "rgba(130, 130, 130, 0.61)");
    },
    addSpinner: function (kleur = "white") {
        var originalHtml = $(this).html();
        var originalEl = $(this);
        var opts = {
            lines: 12,            // The number of lines to draw
            length: 15,            // The length of each line
            width: 3,             // The line thickness
            radius: 15,           // The radius of the inner circle
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

        $(this).html("<div id='ajaxSpinner'></div>");
        var target = document.getElementById("ajaxSpinner");
        var spinner = new Spinner(opts).spin(target);
        
        //Wanneer ajax klaar is
        $( document ).ajaxComplete(function() {
            originalEl.html(originalHtml);
        });
    }
});


//DEDICATED FUNCTIES
function reload(){
    location.reload();
}
function getMaandVoluit(int){
    if(int.length == 1) int = "0" + int;
    if(int == "01") return "Januari";
    if(int == "02") return "Februari";
    if(int == "03") return "Maart";
    if(int == "04") return "April";
    if(int == "05") return "Mei";
    if(int == "06") return "Juni";
    if(int == "07") return "Juli";
    if(int == "08") return "Augustus";
    if(int == "09") return "September";
    if(int == "10") return "Oktober";
    if(int == "11") return "November";
    if(int == "12") return "December";
    return false;
}
function vervang(str, wat, doorwat){
    var blijvegoan = 0;
    while(blijvegoan != -1){
        var WAAR = str.indexOf(wat, blijvegoan);
        if(WAAR != -1){     
            str = str.slice(0,WAAR) + doorwat + str.slice(WAAR+1,str.length);
        }
        blijvegoan = WAAR;
    }
    return str;
}
function filter(str){
    str = vervang(str, "&", "xxAMPxx");
    str = vervang(str, "'", "xxAANxx");
    str = vervang(str, "\\", "xBCKSLx");
    str = vervang(str, "<", "xKLNDNx");
    str = vervang(str, ">", "xGRTDNx");
    str = vervang(str, "", "xPIJLxx");
    return str;
}
function hoverInfo(object, print, special = 0){
    var randomId = Math.random() * (100 - 1) + 1;
    if(print != ""){
        var popup = "<div class='hoverinfo' id='hoverInfo-" + randomid + "'>" + print + "</div>";
        $("body").append(popup);
    }
    /*var pureID = this.id.substring(7,this.id.length);
    var id = "opmerking-" + pureID;
    var x = event.clientX, y = event.clientY;
    
    $('#' + id).css("opacity", "1");
    $('#' + id).css("top", y + "px");
    $('#' + id).css("left", x + "px");
    
    $('#hoverInfo-' + randomId).mouseout(function(){
        $('#' + id).css("opacity", "0");
        $('#' + id).css("top", "-500px");
        $('#' + id).css("left", "-500px");
    });*/
}
function resetmenu(menu){
    if(menu == "backpopup"){
        backupitems = [];
        selectedbackups = [];
        $("#backselectcont").html("");
        var allechecks = $("#backupitemscont3").find(".check");
        for(var i = 0; i < allechecks.length; i++){
            $(allechecks[i]).css({"background-image": "url('/images/checkmark_leeg.png')",
"opacity": "0"});
        }
        var allechecks = $("#backuplistcont2").find(".check");
        for(var i = 0; i < allechecks.length; i++){
            $(allechecks[i]).css("background-image", "url('/images/checkmark_leeg.png')");
        }
        var allemaanden = $(".backnavmaandInhoud");
        for(var i = 0; i < allemaanden.length; i++){
            $(allemaanden[i]).css("display", "none");
        }
        toggleBackupGUI(1,0);
        $("#backupnaamtextarea").val("");
        $("#layer1-2content").find("error").css("display", "none");
        $("#layer2-1").find("error").css("display", "none");
    }
}
function toggleRommelWaardes(){
    $rommelEntryCont = $("#rommelEntryCont");
    if($rommelEntryCont.css("display") == "none"){
        $rommelEntryCont.css("display", "block");
    }
    else{
        $rommelEntryCont.css("display", "none");
    }
}
function toggleDropdownMaand(input){
    expand = true;
    var inhoud = input.parentElement.nextSibling;
    if(inhoud.style.display == "block"){
        input.src = "/images/expand.png"
        inhoud.style.display =  "none";
    }
    else{
        input.src = "/images/expand_reverse.png"
        inhoud.style.display = "block";
    }
    setTimeout(function() {
        expand = false;
    }, 20);
}
function toggleDropdownJaar(input){
    expand = true;
    var inhoud = input.parentElement.nextSibling;
    if(inhoud.style.display == "none"){
        input.src = "/images/expand_reverse.png"
        inhoud.style.display =  "block";
    }
    else{
        input.src = "/images/expand.png"
        inhoud.style.display = "none";
    }
    setTimeout(function() {
        expand = false;
    }, 20);
}
function verzendBackup(){
    var backupnaam = $("#backupnaamtextarea").val();
    var opmerking = $("#opmerkingtextarea").val();
    console.log($("#backupnaamtextarea").val());
    var dataString = "backupnaam=" + backupnaam + "&opmerking=" + opmerking + "&selectdagen=";
    for(var i = 0; i < backupitems.length; i++){
        dataString = dataString + vervang(backupitems[i], "-", "/") + ";";
    }
    dataString = dataString + "&backup=OKAY";
    console.log(dataString);
    $.ajax({
        type: "POST",
        url: "test.php",
        data: dataString,
        success: function(data) {
            location.reload();
        }
    });
}
function selectBackup(input){
    console.log(input);
    if($(input).find(".check").css("background-image").indexOf("checkmark_vol") == -1){
        $(input).find(".check").css("background-image", "url('/images/checkmark_vol.png");
        $(input).css("background-color", "rgb(214, 214, 214)");
        var backup = input.id.substring(7, input.id.length);
        selectedbackups.push(backup);
    }
    else{
        $(input).find(".check").css("background-image", "url('/images/checkmark_leeg.png");
        $(input).css("background-color", "rgba(239, 239, 239, 0.63)");
        var backup = input.id.substring(7, input.id.length);
        selectedbackups.splice(selectedbackups.indexOf(backup), 1);
    }
}
function toggleBackupGUI(interface, pagina){
    if(interface == 1){
        if(pagina == 0){
            $("#back1").css("display", "block");
            $("#back2").css("display", "none");
            $("#layer1-1").css("display", "inline");
            $("#layer1-2").css("display", "none");
            $("#layer1-3").css("display", "none");
            $("#backupnaamtextarea").val("");
            $("#opmerkingextarea").val("");
            $("#makebackup").css("background-color", "#98D8ED");
            $("#putbackup").css("background-color", "#7CAFBF");
        }
        if(pagina == 1){
            $("#layer1-1").css("display", "inline");
            $("#layer1-2").css("display", "none");
        }
        if(pagina == 2){
            $("#layer1-1").css("display", "none");
            $("#layer1-3").css("display", "none");
            $("#layer1-2").css("display", "inline");
            $("#layer1-2content").find("error").css("display", "none");
        }
        if(pagina == 3){
            var backupnaam = $("#backupnaamtextarea").val();
            if(backupnaam == ""){
                $("#layer1-2content").find("error").css("display", "block");
            }
            else{
                $("#layer1-2content").find("error").css("display", "none");
                $("#layer1-2").css("display", "none");
                $("#layer1-3").css("display", "inline");
            }
        }
    }
    if(interface == 2){
        if(pagina == 0){
            $("#back1").css("display", "none");
            $("#back2").css("display", "block");
            $("#makebackup").css("background-color", "#7CAFBF");
            $("#putbackup").css("background-color", "#98D8ED");
        }
        if(pagina == 1){
            $("#layer2-1").css("display", "inline");
            $("#layer2-2").css("display", "none");
        }
        if(pagina == 2){
            if(selectedbackups.length > 0){
                $("#layer2-1").css("display", "none");
                $("#layer2-3").css("display", "none");
                $("#layer2-2").css("display", "inline");
                $("#layer2-1").find("error").css("display", "none");
                vulLayer22();
            }
            else{
                $("#layer2-1").find("error").css("display", "block");
            }
        }
    }
}
function vulLayer22(){
    $("#selectedbackups").html("");
    var SBT = "";
    for(var i = 0; i < selectedbackups.length; i++){
        console.log(selectedbackups[i]);
        $("#selectedbackups").append("<b>" + selectedbackups[i] + "</b>");

        if(i <= selectedbackups.length - 2){
            if(i == selectedbackups.length - 2){
                $("#selectedbackups").append(" en ");
            }
            else{
                $("#selectedbackups").append(", ");
            }
        }
        var nummer = i + 1;
        SBT = SBT + "<tr class='SBTtr' id='SBT-" + nummer + "'><th class='SBTth'>" + nummer + "</th><td class='SBTtd'><ul class='SBTselect' value='hidden'>"
        for(var j = 0; j < selectedbackups.length; j++){
            if(j == 0) SBT = SBT + "<li class='layer2-2dropdown layer2-2dropdown1' onclick='vulSBT(this)'>" + selectedbackups[j] + "</li>";
            else SBT = SBT + "<li class='layer2-2dropdown layer2-2dropdown2' onclick='vulSBT(this)'>" + selectedbackups[j] + "</li>";
        }
        SBT = SBT + "</ul></td></tr>";
    }
    $("#SBT").append(SBT);
}
function vulSBT(input){
    if(input.parentElement.getAttribute("value") == "hidden"){
        var aantal = $(input.parentElement).find(".layer2-2dropdown2");
        for(var i = 0; i < aantal.length; i++){
            console.log(aantal[i]);
            $(aantal[i]).css("display", "block");
            $(aantal[i]).css("z-index", "50");
            $(input.parentElement.parentElement.parentElement).find(".SBTth").css("z-index", "50");
        }
        input.parentElement.setAttribute("value", "visible")
    }
    else if(input.parentElement.getAttribute("value") == "visible"){
        var aantal = $(input.parentElement).find(".layer2-2dropdown2");
        for(var i = 0; i < aantal.length; i++){
            $(aantal[i]).css("display", "none");
            $(aantal[i]).css("z-index", "2");
            $(input.parentElement.parentElement.parentElement).find(".SBTth").css("z-index", "2");
        }
        input.parentElement.setAttribute("value", "hidden");
    }
    
    var id = input.parentElement.parentElement.parentElement.id;
    setTimeout(function() {
        $("body").click(function(){

            var x = event.clientX, y = event.clientY;
            var muiselem = document.elementFromPoint(x, y);
            console.log(id);
            console.log(muiselem.parentElement.parentElement.parentElement.id);
            console.log(muiselem.parentElement.parentElement.parentElement.id != id);
            if(muiselem.parentElement.parentElement.parentElement.id != id){
                console.log("WHYYYYY")
                var aantal = $(input.parentElement).find(".layer2-2dropdown2");
                for(var i = 0; i < aantal.length; i++){
                    $(aantal[i]).css("display", "none");
                    $(aantal[i]).css("z-index", "2");
                    $(input.parentElement.parentElement.parentElement).find(".SBTth").css("z-index", "2");
                }
                input.parentElement.setAttribute("value", "hidden");
            }

        });
    }, 200);
}
function deleteSelect(id){
    var selectarray = $(".backselectitem");
    for(var i = 0; i < selectarray.length; i++){
        if($(selectarray[i]).attr("name") == id){
            $(".backselectitem")[i].remove();
        }
    }
}
function addSelect(id){
    //als het een dag of een jaar is
    if(id.length == 8){
        var content = '<div onclick="toggleBackup(this)" class="backselectitem selectdag" name="' + id + '"><div class="backselectitemkruis"></div><p>' + vervang(id, "-", "/") + '</p></div>';
        $("#backselectcont").append(content);
    }
    //als het een maand is
    else if(id.length == 5){
        var naam = getMaandVoluit(id.substr(0,2)) + " 20" + id.substr(3,5);
        if(id.substr(0,2) == "12") naam = "December" + " 20" + id.substr(3,5);
        var content = '<div onclick="toggleBackup(this)" class="backselectitem selectmaand" name="' + id + '"><div class="backselectitemkruis"></div><p>' + naam + '</p></div>';
        $("#backselectcont").append(content);
    }
    else if(id.length == 4){
        var content = '<div onclick="toggleBackup(this)" class="backselectitem selectjaar" name="' + id + '"><div class="backselectitemkruis"></div><p>' + vervang(id, "-", "/") + '</p></div>';
        $("#backselectcont").append(content);
    }
}
function deleteVinkje(input, type){
    if(type == "backup"){
        $(document.getElementsByName(input)[0]).find(".check").css({"background-image": "url('/images/checkmark_leeg.png')",
    "opacity": "0"});
    }
    else if(type == "dupError"){
        input.css({"background-image": "url('/images/checkmark_leeg.png')"});
    }
}
function addVinkje(input, type){
    if(type == "backup"){
        $(document.getElementsByName(id)[0]).find(".check").css({"background-image": "url('/images/checkmark_vol.png')","opacity": "1"});
    }
    else if(type == "dupError"){
        input.css({"background-image": "url('/images/checkmark_vol.png')"});
    }
}
function addBackupItem(input){
    console.log(input);
    if(input.length == 8){
        backupitems.push(input);
    }
    else if(input.length == 5){
        var dagen = document.getElementsByName(input)[0].parentElement.getElementsByClassName("backnavdag");
        for(var i = 0; i < dagen.length; i++){
            var dag = dagen[i].getElementsByClassName("backnavdaglink")[0];
            var id = dag.getAttribute("name");
            if(backupitems.indexOf(id) == -1){
                backupitems.push(id);
            }
        }
    }
    else if(input.length == 4){
        var dagen = document.getElementsByName(input)[0].parentElement.getElementsByClassName("backnavdag");
        for(var i = 0; i < dagen.length; i++){
            var dag = dagen[i].getElementsByClassName("backnavdaglink")[0];
            var id = dag.getAttribute("name");
            if(backupitems.indexOf(id) == -1){
                backupitems.push(id);
            }
        }
    }
}
function deleteBackupItem(input){
    if(input.length == 8){
        backupitems.splice(backupitems.indexOf(input), 1);
    }
    else if(input.length == 5){
        var dagen = document.getElementsByName(input)[0].parentElement.getElementsByClassName("backnavdag");
        for(var i = 0; i < dagen.length; i++){
            var dag = dagen[i].getElementsByClassName("backnavdaglink")[0];
            var id = dag.getAttribute("name");
            backupitems.splice(backupitems.indexOf(id), 1);
        }
    }
    else if(input.length == 4){
        var dagen = document.getElementsByName(input)[0].parentElement.getElementsByClassName("backnavdag");
        for(var i = 0; i < dagen.length; i++){
            var dag = dagen[i].getElementsByClassName("backnavdaglink")[0];
            var id = dag.getAttribute("name");
            backupitems.splice(backupitems.indexOf(id), 1);
        }
    }
}
function toggleBackup(input){
    if(input.className != "check"){
        var temp = input.getAttribute("name");
        var input = document.getElementsByName(temp)[0].getElementsByClassName("check")[0];
    }
    var inputId = input.parentElement.getAttribute("name");
    //DAG
    if(inputId.length == 8){
        //ALS DE DAG LEEG IS
        if($(input).css("background-image").indexOf("checkmark_vol") == -1){
            addVinkje(inputId, "backup");
            addSelect(inputId);
            addBackupItem(inputId);
            
            //De parentmaand ophalen om te checken of ie vol is nu
            var teller = 0;
            var maandklasse = ".dag" + inputId.substring(inputId.length-5);
            var maanddagen = $(maandklasse);
            for(var i = 0; i < maanddagen.length; i++){
                //Als de dag aangevinkt is
                if($(maanddagen[i]).find(".check").css("background-image").indexOf("checkmark_leeg") == -1){
                    teller++;
                }
            }
            //Als het totaal aangevinkte dagen gelijk is aan alle dagen in de parentmaand
            if(teller == maanddagen.length){
                var maandId = inputId.substring(inputId.length - 5);
                addVinkje(maandId, "backup");
                
                addSelect(maandId);
                
                //In de select de childdagen verwijderen
                for(var i = 0; i < maanddagen.length; i++){
                    var dagId = $(maanddagen[i]).attr("name");
                    deleteSelect(dagId);
                }
                
                //Het parentjaar ophalen om te checken of ie vol is nu
                var teller = 0;
                var jaarklasse = ".maand20" + maandId.substring(maandId.length-2);
                var jaarmaanden = $(jaarklasse);
                for(var i = 0; i < jaarmaanden.length; i++){
                    //Als de maand aangevinkt is
                    if($(jaarmaanden[i]).find(".check").css("background-image").indexOf("checkmark_leeg") == -1){
                        teller++;
                    }
                }
                //Als het totaal aangevinkte maanden gelijk is aan alle maanden in het parentjaar
                if(teller == jaarmaanden.length){
                    var jaarId = 20 + maandId.substring(maandId.length - 2);
                    addVinkje(jaarId, "backup");
                    
                    addSelect(jaarId);
                
                    //In de select de childmaanden verwijderen
                    for(var i = 0; i < jaarmaanden.length; i++){
                        var maandId = $(jaarmaanden[i]).attr("name");
                        deleteSelect(maandId);
                    }
                }
            }
        }
        
        //ALS DE DAG VOL IS
        else{
            deleteVinkje(inputId, "backup");
            deleteSelect(inputId);
            deleteBackupItem(inputId);
            
            //De parentmaand op leeg zetten
            var maandNaam = inputId.substring(inputId.length-5)
            deleteVinkje(maandNaam, "backup");
            
            //Het parentjaar op leeg zetten
            var jaarNaam = "20" + inputId.substring(inputId.length-2)
            deleteVinkje(jaarNaam, "backup");
            
            //Als het jaar vol is, de jaarselect verwijderen en alle maanden adden
            var selectJaren = $(".selectjaar");
            for(var i = 0; i < selectJaren.length; i++){
                if(selectJaren[i].getAttribute("name") == jaarNaam){
                    deleteSelect(jaarNaam);
                    
                    //ALLE selectmaanden adden (de goeie wordt hierna weer vervangen door de resterende dagen)
                    var jaarklasse = ".maand20" + inputId.substring(inputId.length-2);
                    var jaarmaanden = $(jaarklasse);
                    
                    for(var j = 0; j < jaarmaanden.length; j++){
                        var maandNaam2 = jaarmaanden[j].getAttribute("name");
                        addSelect(maandNaam2);
                    }
                }
            }
            
            //Als de maand vol is, de maandselect verwijderen en alle dagen adden
            var selectMaanden = $(".selectmaand");
            for(var i = 0; i < selectMaanden.length; i++){
                if(selectMaanden[i].getAttribute("name") == maandNaam){
                    deleteSelect(maandNaam);
                    
                    //Alle resterende selectdagen adden
                    var maandklasse = ".dag" + inputId.substring(inputId.length-5);
                    var maanddagen = $(maandklasse);
                    for(var j = 0; j < maanddagen.length; j++){
                        var dagNaam = maanddagen[j].getAttribute("name");
                        if(dagNaam != inputId){
                            addSelect(dagNaam);
                        }
                        
                    }
                }
            }
            
            
        }
    }
    
    
    //MAAND
    if(inputId.length == 5){
        if($(input).css("background-image").indexOf("checkmark_vol") == -1){
            addVinkje(inputId, "backup");
            addSelect(inputId);
            addBackupItem(inputId);
            
            //De childdagen aanvinken
            var maandklasse = ".dag" + inputId;
            var maanddagen = $(maandklasse);
            for(var i = 0; i < maanddagen.length; i++){
                var dagNaam = maanddagen[i].getAttribute("name");
                addVinkje(dagNaam, "backup");
                deleteSelect(dagNaam);
            }
            

            //Het parentjaar ophalen om te checken of ie vol is nu
            var teller = 0;
            var jaarklasse = ".maand20" + inputId.substring(inputId.length-2);
            var jaarmaanden = $(jaarklasse);
            for(var i = 0; i < jaarmaanden.length; i++){
                //Als de maand aangevinkt is
                if($(jaarmaanden[i]).find(".check").css("background-image").indexOf("checkmark_leeg") == -1){
                    teller++;
                }
            }
            //Als het totaal aangevinkte maanden gelijk is aan alle maanden in het parentjaar
            if(teller == jaarmaanden.length){
                var jaarId = 20 + inputId.substring(inputId.length - 2);
                addVinkje(jaarId, "backup");
                
                addSelect(jaarId);
                
                //In de select de childmaanden verwijderen
                for(var i = 0; i < jaarmaanden.length; i++){
                    var maandId = $(jaarmaanden[i]).attr("name");
                    deleteSelect(maandId);
                }
            }
        }
        //ALS DE MAAND VOL IS
        else{
            deleteVinkje(inputId, "backup");
            deleteSelect(inputId);
            deleteBackupItem(inputId);
            
            //De childdagen op leeg zetten
            var maandklasse = ".dag" + inputId;
            var maanddagen = $(maandklasse);
            for(var i = 0; i < maanddagen.length; i++){
                $(maanddagen[i]).find(".check").css("background-image", "url('/images/checkmark_leeg.png')");
                $(maanddagen[i]).find(".check").css("opacity", "0");
            }
            
            //Het parentjaar op leeg zetten
            var jaarNaam = "20" + inputId.substring(inputId.length-2)
            deleteVinkje(jaarNaam, "backup");
            
            //Als het jaar vol is, de jaarselect verwijderen en alle maanden adden
            var selectJaren = $(".selectjaar");
            for(var i = 0; i < selectJaren.length; i++){
                if(selectJaren[i].getAttribute("name") == jaarNaam){
                    deleteSelect(jaarNaam);
                    
                    //Alle resterende selectmaanden adden
                    var jaarklasse = ".maand20" + inputId.substring(inputId.length-2);
                    var jaarmaanden = $(jaarklasse);
                    
                    
                    for(var j = 0; j < jaarmaanden.length; j++){
                        var maandNaam = jaarmaanden[j].getAttribute("name");
                        if(maandNaam != inputId){
                            addSelect(maandNaam);
                        }
                        
                    }
                }
            }
        }
    }
    
    
    
    //JAAR
    if(inputId.length == 4){
        if($(input).css("background-image").indexOf("checkmark_vol") == -1){
            addVinkje(inputId, "backup");
            addSelect(inputId);
            addBackupItem(inputId);
            
            //Alle vinkjes van de maanden adden
            var jaarklasse = ".maand" + inputId;
            var jaarmaanden = $(jaarklasse);
            for(var i = 0; i < jaarmaanden.length; i++){
                var maandNaam = jaarmaanden[i].getAttribute("name");
                addVinkje(maandNaam, "backup");
                deleteSelect(maandNaam);
                
                //Alle vinkjes van de dagen adden
                var maandId = $(jaarmaanden[i]).attr("name");
                var maandklasse = ".dag" + maandId;
                var maanddagen = $(maandklasse);
                for(var j = 0; j < maanddagen.length; j++){
                    var dagNaam = maanddagen[j].getAttribute("name");
                    addVinkje(dagNaam, "backup");
                    deleteSelect(dagNaam);
                }
                
            }
        }
        //ALS HET JAAR VOL IS
        else{
            deleteVinkje(inputId, "backup");
            deleteSelect(inputId);
            deleteBackupItem(inputId);
            
            //De childdagen en childmaanden op leeg zetten
            var jaarklasse = ".maand" + inputId;
            var jaarmaanden = $(jaarklasse);
            for(var i = 0; i < jaarmaanden.length; i++){
                var maandNaam = jaarmaanden[i].getAttribute("name");
                deleteVinkje(maandNaam, "backup");
                
                //Alle vinkjes van de dagen leegmaken
                var maandId = $(jaarmaanden[i]).attr("name");
                var maandklasse = ".dag" + maandId;
                var maanddagen = $(maandklasse);
                for(var j = 0; j < maanddagen.length; j++){
                    var dagNaam = maanddagen[j].getAttribute("name");
                    deleteVinkje(dagNaam, "backup");
                }
            }
        }
    }
}
function verzendEntry(){
    var datum = $("textarea#datum").val();
    var weekdag = $("textarea#weekdag").val();
    var muziek = $("textarea#muziek").val();
    var gebeurtenis = $("textarea#gebeurtenis").val();
    datum = filter(datum);
    gebeurtenis = filter(gebeurtenis);
    weekdag = filter(weekdag);
    muziek = filter(muziek);
    

    //DATUM CHECK
    var geldigeDatum = true;
    var delimiter = "";
    var datumparts = datum.split(/\/|-/g);
    if(datumparts.length == 3){
        var d = new Date(datumparts[1] + "/" + datumparts[0] + "/" + datumparts[2]);
        if ( Object.prototype.toString.call(d) === "[object Date]" ) {
          if ( isNaN( d.getTime() ) )  geldigeDatum = false;
        }
        else geldigeDatum = false;
        if(datumparts[2].length != 2 && datumparts[2].length != 4) geldigeDatum = false;
        if(datumparts[2].length == 2) datum = datumparts[0] + "/" + datumparts[1] + "/" + datumparts[2];
        if(datumparts[2].length == 4) datum = datumparts[0] + "/" + datumparts[1] + "/" + datumparts[2].substr(2);

    }
    else geldigeDatum = false;
    

    //WEEKDAG CHECK
    var geldigeWeekdag = true;
    if(weekdag.toLowerCase() != "ma" &&
        weekdag.toLowerCase() != "di" &&
        weekdag.toLowerCase() != "wo" &&
        weekdag.toLowerCase() != "do" &&
        weekdag.toLowerCase() != "vr" &&
        weekdag.toLowerCase() != "za" &&
        weekdag.toLowerCase() != "zo")geldigeWeekdag = false;

    //MUZIEK CHECKEN
    var geldigeMuziek = true;
    if(muziek.length > 100) geldigeMuziek = false;

    //GEBEURTENIS CHECKEN
    var geldigeGebeurtenis;
    if(gebeurtenis == "") geldigeGebeurtenis = false;

    //ERROR 
    if(!geldigeDatum || !geldigeWeekdag || !geldigeMuziek || !geldigeGebeurtenis){
        $("#errorcont").html("");
        if(!geldigeDatum){
            $("#errorcont").append("Gelieve een geldige datum in te geven (bv. 2/11/16 of 02-10-2016).<br>");
        }
        if(!geldigeWeekdag){
            $("#errorcont").append("Gelieve een geldige dag in te geven (bv; ma, MA, ...).<br>");
        }
        if(!geldigeMuziek){
            $("#errorcont").append("Muziek mag maximaal 100 karakters bevatten.<br>");
        }
        if(!geldigeGebeurtenis){
            $("#errorcont").append("Gelieve een gebeurtenis te vermelden.<br>");
        }
        
        $("#errorpopup").toonMenu();
    }
    else{
        $.ajax({
            type: "GET",
            url: "/minidagboek/addEntry",
            data: {'datum' : datum, 'gebeurtenis' : gebeurtenis, 'weekdag' : weekdag, 'muziek' : muziek},
            success: function(data) {
                if(data.length > 0){
                    var tekst = "<div id='errorDuplicateEntryCont'>";
                    for(var i = 0; i < data.length; i++){
                        tekst += "<div class='errorDuplicateEntry'><div class='errorDuplicateEntryCheck' onclick='addSelectedDuplicate(this)'></div><tekst>" + data[i] + "</tekst></div>";
                    }
                    tekst += "</ul></div>";

                    $("#errorDuplicateEntryCont").html(tekst);
                    $("#errorpopup").toonMenu();
                }
                else{
                   location.reload();
                }
            }
        });
    }
}
function verzendEntries(){
    var KBM = document.getElementById("KBM_area").value;
    KBM = filter(KBM);

    $("#KBM_button").addSpinner();
    $.ajax({
        type: "POST",
        url: "/minidagboek/addEntries",
        data: {'entries' : KBM},
        success: function(data) {
            if(data[0].length > 0 || data[1].length > 0){
                //Content van rommel bepalen
                if(data[0].length > 0){
                    var rommelTekst = "Je verzoek bevat rommelwaardes dat niet verwerkt konden worden. <fakeA id='toggleRommel' onclick='toggleRommelWaardes()'>Bekijk ze<fakeA><br>";
                    var rommelEntries = "<ul>";
                    for(var i = 0; i < data[0].length; i++){
                        rommelEntries += "<li class='rommelEntry'>" + data[0][i] + "</li>";
                    }
                    rommelEntries += "</ul>";
                    var duplicateDoorgaan = "<div id='duplicateSubmit'><tekst onclick='reload()'>Doorgaan</tekst></div>";
                }

                //Content van duplicates bepalen
                if(data[1].length > 0){
                    var duplicateTekst = "<div>Er bestaan al entries voor onderstaande dagen. Kies welke je wilt overschrijven.</div>";
                    var duplicateSelectAll = "<div id='duplicateSelectAll'>Selecteer alles  <fakeA id='duplicateSelectAllCheck' onclick='selectAllDuplicates(this)'></fakeA>";
                    var duplicateEntries = "";
                    for(var i = 0; i < data[1].length; i++){
                        duplicateEntries += "<div class='duplicateEntry'><div class='duplicateEntryCheck' onclick='addSelectedDuplicate(this)'></div><tekst>" + data[1][i] + "</tekst></div>";
                    }
                    var duplicateDoorgaan = "<div id='duplicateSubmit'><tekst onclick='overrideDuplicates()''>Doorgaan</tekst></div>";
                    
                }

                //Oude data cleanen
                $("#rommelTekst").html("");
                $("#rommelEntryCont").html("");
                $("#errorHr").html("");
                $("#duplicateTekst").html("");
                $("#duplicateEntryCont").html("");
                $("#duplicateSubmitCont").html("");

                //Alles pushen naar de errorpopup
                $("#rommelTekst").html(rommelTekst);
                $("#rommelEntryCont").html(rommelEntries);
                if(data[0].length > 0 && data[1].length > 0) $("#errorHr").html("<hr>");
                $("#duplicateTekst").html(duplicateTekst);
                $("#duplicateTekst").append(duplicateSelectAll);
                $("#duplicateEntryCont").html(duplicateEntries);
                $("#duplicateSubmitCont").html(duplicateDoorgaan);

                $("#errorpopup").toonMenu();
            }
            
            else{
                location.reload();
            }
        }
    });
}
function addSelectedDuplicate(input){
    if($(input).css("background-image").indexOf("checkmark_leeg") == -1){
        deleteVinkje($(input), "dupError");
        selectedDupEntries.splice(selectedDupEntries.indexOf($(input).parent().find("tekst").html()), 1);
    }
    else{
        addVinkje($(input), "dupError");
        selectedDupEntries.push($(input).parent().find("tekst").html());
    }
}
function selectAllDuplicates(input){
    var muiselem = $(input);
    console.log(input);
    if(muiselem.css("background-image").indexOf("checkmark_leeg") == -1){
        deleteVinkje(muiselem, "dupError");
        var allEntries = $(".duplicateEntryCheck");
        for(var i = 0; i < allEntries.length; i++){
            deleteVinkje($(allEntries[i]), "dupError");
            selectedDupEntries.splice(selectedDupEntries.indexOf($(allEntries[i]).parent().find("tekst").html()), 1);
        }
    }
    else{
        addVinkje(muiselem, "dupError");
        var allEntries = $(".duplicateEntryCheck");
        for(var i = 0; i < allEntries.length; i++){
            addVinkje($(allEntries[i]), "dupError");
            selectedDupEntries.push($(allEntries[i]).parent().find("tekst").html());
        }
    }
}
function overrideDuplicates(){
    $.ajax({
        url: "/minidagboek/overrideDuplicates",
        type: "POST",
        data: {'duplicates' : selectedDupEntries},
        success: function() {
            location.reload();
        }
    });
}

//PERMANENTE FUNCTIES
$(document).ready(function() {
    $.ajax({
      url: '/minidagboek/initialise',
      type: 'GET',
      data: '',
      success: function(data){
        $("#inhoud").append(data[0]);
        $("#navigatie").append(data[1]);
      }
    });
    
});

$(document).ready(function() {
    //MENUS OPENEN
    $(".menubutton").click(function(e){
        var menuId = $(this).attr('name');
        $("#" + menuId).toonMenu();
    });
    //POPUP'S AUTOMATISCH HIDEN
    $(".togglepopup").click(function(e){
        if(e.target == this) {
            $(this).hideMenu();
            resetmenu(e.target.id);
        }
    });
    
    //backupmenu - opmerking popup
    $(".backups").hover(function(e){
        var pureID = this.id.substring(7,this.id.length);
        var id = "opmerking-" + pureID;
        var x = event.clientX, y = event.clientY;
        
        $('#' + id).css("opacity", "1");
        $('#' + id).css("top", y + "px");
        $('#' + id).css("left", x + "px");
        
        $('#backup-' + pureID).mouseout(function(){
            $('#' + id).css("opacity", "0");
            $('#' + id).css("top", "-500px");
            $('#' + id).css("left", "-500px");
        });
    });
    
    
    //rechtermuisklik menu
    document.addEventListener('contextmenu', function(e) {
        var width = $('#backupitemscont2').css("width");
        $('#RKmenu').css({"display": "none"});
        var x = event.clientX, y = event.clientY;
        var muiselem = document.elementFromPoint(x, y);
        var wat = "";
        var datum = "";
        
        //Checken wat de muiselem is
        
            //----inhoud
                if(muiselem.tagName.indexOf("NAAM") != -1 || muiselem.parentElement.tagName.indexOf("NAAM") != -1 || muiselem.tagName == "TD") {
                    //muiselem aanpassen
                    if(muiselem.parentElement.tagName.indexOf("NAAM") != -1) muiselem = muiselem.parentElement;
                    muiselem = muiselem.parentElement;

                    //datum en wat bepalen
                    if(muiselem.tagName == "DIV" && muiselem.className == "jaar"){
                        wat = "jaar";
                        datum = muiselem.id;
                    }
                    if(muiselem.tagName == "DIV" && muiselem.className == "maand") {
                        wat = "maand";
                        datum = muiselem.id;
                    }
                    if(muiselem.tagName == "TR") {
                        wat = "dag";
                        datum = muiselem.id;
                    }
                }
            //----nav
                if(muiselem.className == "navjaarlink" || muiselem.parentElement.className == "navjaarlink"){
                    wat = "jaar";
                    datum = muiselem.name.substring(1, muiselem.name.length);
                }
                if(muiselem.className == "navmaandlink" || muiselem.parentElement.className == "navmaandlink"){
                    wat = "maand";
                    datum = muiselem.name.substring(1, muiselem.name.length);
                }
                if(muiselem.className == "navdaglink"){
                    wat = "dag";
                    datum = muiselem.name.substring(1, muiselem.name.length);
                }

        //Het RK-menu maken
        if(wat != ""){
            
            //De inhoud van het RK menu maken
            var inhoud = "<li class='RKli'><fakeA id='RKedit' class='RKa'><span class='helper'></span><img  class='RKimg' src='/images/edit-zwt.png'>Bewerk</fakeA></li>"
                    + "<li class='RKli'><fakeA id='RKdelete' class='RKa'><span class='helper'></span><img class='RKimg' src='/images/delete-zwt.png'>Verwijder</fakeA></li>"
                    + "<li class='RKli'><fakeA id='RKstat' class='RKa'><span class='helper'></span><img class='RKimg' src='./images/statistieken-zwt.png'>Statistieken</fakeA></li>";   
            $("#RKul").html(inhoud);
            
            
            //TITEL MAKEN
            var titel = "";
            if(wat == "jaar"){
                titel = datum;
            }
            if(wat == "maand"){
                titel = getMaandVoluit(datum.substr(0,2)) + " 20" + datum.substr(3,5);
            }
            if(wat == "dag"){
                titel = vervang(datum, "-", "/");
            }
            $('#RKtitel').html(titel);
            
            //CSS voor jaar
            if(wat == "jaar"){
                var $temp = $(muiselem);
                var css = '#MD .RKa:hover{ background-color: #fcd9d9; box-shadow: inset 3px 0px 0px 0px #C45454;}';
                $("#RKstijl").html(css);
                $("#RK").find("h3").css({"background-color": "rgba(250,192,192,0.3"});
                
                var id;
                $(".RKa").hover(function(){
                    id = this.id;
                    var srctemp = $(this).find(".RKimg").attr("src");
                    var src = srctemp.substring(0, srctemp.length - 7) + "rod.png";
                    $(this).find(".RKimg").attr("src", src);
                });
                $(".RKa").mouseout(function(){
                    var x2 = event.clientX, y2 = event.clientY;
                    var muiselem2 = document.elementFromPoint(x2, y2);
                    if(muiselem2.className != "RKimg" && muiselem2.id != id){
                        var srctemp = $(this).find(".RKimg").attr("src");
                        var src = srctemp.substring(0, srctemp.length - 7) + "zwt.png";
                        $(this).find(".RKimg").attr("src", src);
                    }
                });
            }
            
            //CSS voor maand
            if(wat == "maand"){
                var $temp = $(muiselem);
                var css = '#MD .RKa:hover{ background-color: #abc5ff; box-shadow: inset 3px 0px 0px 0px #294380;}';
                $("#RKstijl").html(css);
                $("#RK").find("h3").css({"background-color": "rgba(130,168,255,0.3"});
                 
                var id;
                $(".RKa").hover(function(){
                    id = this.id;
                    var srctemp = $(this).find(".RKimg").attr("src");
                    var src = srctemp.substring(0, srctemp.length - 7) + "blw.png";
                    $(this).find(".RKimg").attr("src", src);
                });
                $(".RKa").mouseout(function(){
                    var x2 = event.clientX, y2 = event.clientY;
                    var muiselem2 = document.elementFromPoint(x2, y2);
                    if(muiselem2.className != "RKimg" && muiselem2.id != id){
                        var srctemp = $(this).find(".RKimg").attr("src");
                        var src = srctemp.substring(0, srctemp.length - 7) + "zwt.png";
                        $(this).find(".RKimg").attr("src", src);
                    }
                });
            }
            
            //CSS voor maand
            if(wat == "dag"){
                var $temp = $(muiselem);
                var $kleur = $temp.css("background-color");
                if(muiselem.tagName == "A") $kleur = "rgba(155,187,89,0.3)";
                var css = '#MD .RKa:hover{ background-color: ' + $kleur + '; box-shadow: inset 3px 0px 0px 0px #9bbb59;}';
                
                $("#RKstijl").html(css);
                $("#RK").find("h3").css({"background-color": "rgba(155,187,89,0.3"});
                
                var id;
                $(".RKa").hover(function(){
                    id = this.id;
                    var srctemp = $(this).find(".RKimg").attr("src");
                    var src = srctemp.substring(0, srctemp.length - 7) + "grn.png";
                    $(this).find(".RKimg").attr("src", src);
                });
                $(".RKa").mouseout(function(){
                    var x2 = event.clientX, y2 = event.clientY;
                    var muiselem2 = document.elementFromPoint(x2, y2);
                    if(muiselem2.className != "RKimg" && muiselem2.id != id){
                        var srctemp = $(this).find(".RKimg").attr("src");
                        var src = srctemp.substring(0, srctemp.length - 7) + "zwt.png";
                        $(this).find(".RKimg").attr("src", src);
                    }
                });
            }
            
            $('#RKmenu').css({
                "display": "block",
                "left": x,
                "top": y
            });
            
            
            //FUNCTIES
            $("#RKdelete").click(function(){
                

                $('#delpopup').css("display", "block");
                $('#RKmenu').css({"display": "none"});
                
                var titeltemp = titel.toLowerCase();
                if(wat != "dag") titeltemp = "heel " + titeltemp;
                document.getElementById("header").innerHTML = "Je staat op het punt om " + titeltemp + " te verwijderen";

                $("#ja").unbind().click(function(){
                    var delitem = "";
                    if(wat == "dag"){
                        delitem = "20" + datum.split("-")[2] + "-" + datum.split("-")[1] + "-" + datum.split("-")[0];
                    }
                    if(wat == "maand"){
                        delitem = "20" + datum.split("-")[1] + "-" + datum.split("-")[0];
                    }
                    if(wat == "jaar"){
                        delitem = datum;
                    }
                    console.log(delitem);
                    $.ajax({
                        type: "GET",
                        url: "/minidagboek/deleteEntries",
                        data: {'delitem' : delitem},
                        success: function(data) {
                            if (data == null || data == false){
                                alert("Item kon niet verwijderd worden");
                            }
                            else{
                                location.reload();
                            }
                        }
                    });
                });
                
            });

            e.preventDefault();
        }
        $("body").click(function() {
            var x2 = event.clientX, y2 = event.clientY;
            var muiselem2 = document.elementFromPoint(x2, y2);

            if(muiselem2.id != "RKmenu" &&
                    muiselem2.id != "RKul" &&
                    muiselem2.className != "RKli" &&
                    muiselem2.className != "RKa" &&
                    muiselem2.id != "RKtitel"){
                $('#RKmenu').css({"display": "none"});
            }
        });
        window.onscroll = function (e) {  
            $('#RKmenu').css({"display": "none"});
        } 
    });
    
    
    //double click expanden
    document.addEventListener('dblclick', function(e){ 
        var valid = false;
        var x = event.clientX, y = event.clientY;
        var muiselem = document.elementFromPoint(x, y);
        
        if(muiselem.tagName.indexOf("NAAM") != -1 || muiselem.parentElement.tagName.indexOf("NAAM") != -1) {
            if(muiselem.parentElement.tagName.indexOf("NAAM") != -1) muiselem = muiselem.parentElement;
            muiselem = muiselem.parentElement;
            valid = true;
        }
        if(valid == true && (
                muiselem.tagName == "DIV" && muiselem.className == "jaar" ||
                muiselem.tagName == "DIV" && muiselem.className == "maand")){
            if(muiselem.className == "jaar"){
                if($(muiselem).find(".maanden").css("display") == "none"){
                    $(muiselem).find(".maanden").css({"display": "block"});
                }
                else{
                    $(muiselem).find(".maanden").css({"display": "none"});
                }
            }
            if(muiselem.className == "maand"){
                if($(muiselem).find(".dagen").css("display") == "none"){
                    $(muiselem).find(".dagen").css({"display": "block"});
                }
                else{
                    $(muiselem).find(".dagen").css({"display": "none"});
                }
            }
            
        }
      
    });
    
    
    //smooth scrollen
    $(document).on('click', '.navjaarlink', function(event){
        console.log("1");
        if(expand == false){
            console.log("2");
            var $vh = $(window).height() * 0.07;
            var $offset = $( $(this).attr('name') ).offset().top - $vh;
            $('html, body').animate({
                scrollTop: $offset
            }, 500);
        }
        else{
            event.preventDefault();
        }
    });
    $(document).on('click', '.navmaandlink', function(event){
        if(expand == false){
            var $vh = $(window).height() * 0.07;
            var $offset = $( $(this).attr('name') ).offset().top - $vh;
            $('html, body').animate({
                scrollTop: $offset
            }, 500);
        }
        else{
            event.preventDefault();
        }
    });
    
    //DAG POPUP
    $(document).on('click', '.navdaglink', function(event){
        if(expand == false){
            var $target = $( $(this).attr('name') );
            if($target.parent().parent().parent().parent().parent().css("display") == "none"){
                $target.parent().parent().parent().parent().parent().css({"display" : "block"});
            }
            if($target.parent().parent().parent().css("display") == "none"){
                $target.parent().parent().parent().css({"display" : "block"});
            }
            
            
            
            var $rijhoogte = $target.height();
            var $vh = $(window).height() * 0.01;
            var $localOffset = (100 * $vh - $rijhoogte) / 2;
            
            var $offset = $target.offset().top - $localOffset;
            
            
            $('html, body').animate({
                scrollTop: $offset
            }, 500);
            
            //popup fixen
            setTimeout(function() {
                var $inhoud = $target.html();
                var html = "<table id='temptable'><tr id='tempdag'>" + $inhoud + "</tr></table>";
                document.getElementById('dagpopup').innerHTML = html;
                var $dagpopup = $('#dagpopup');
                var $table = $('#temptable');
                var $datum = $('#temptable .datum');
                var $weekdag = $('#temptable .weekdag');
                var $gebeurtenis = $('#temptable .gebeurtenis');
                
                //offset fixen van table
                if($target.offset().top > $localOffset && $target.offset().top < $(document).height() - $localOffset){
                    $table.css({
                        "left": $target.offset().left,
                        "top": $localOffset + 1
                    });
                }
                else if($target.offset().top < $localOffset){
                    $table.css({
                        "left": $target.offset().left,
                        "top": $target.offset().top + 1
                    });
                }
                else{
                    $table.css({
                        "left": $target.offset().left,
                        "top": $(window).height() - ($(document).height() - $target.offset().top) + 1
                    });
                }
                
                
                var $tempwidth = $target.find('.datum').css("width");
                var $width = Number($tempwidth.substring($tempwidth.length - 2, $tempwidth - 1)) + 1 + "px";
                $datum.css({
                    "width": $width
                });
                
                $tempwidth = $target.find('.weekdag').css("width");
                $width = Number($tempwidth.substring($tempwidth.length - 2, $tempwidth - 1)) + 1 + "px";
                $weekdag.css({
                    "background-color": $target.css("background-color"),
                    "width": $width
                });
                
                $tempwidth = $target.find('.gebeurtenis').css("width");
                $width = Number($tempwidth.substring($tempwidth.length - 2, $tempwidth - 1)) + 1 + "px";
                $gebeurtenis.css({
                    "background-color": $target.css("background-color"),
                    "width": $width
                });
                
                $("#dagpopup").toonMenu();
                $dagpopup.animate({backgroundColor: 'rgba(130, 130, 130, 0.61)'});
                
            }, 500);
                
            
            $("body").click(function() {
                hideMenu("dagpopup");
                $('#dagpopup').html = "";
                $('#dagpopup').css({"background-color": "rgba(255, 255, 255, 0)"});
            });
        }
        else{
            event.preventDefault();
        }
    });
    
    
  });