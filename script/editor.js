function ItemOnClick(item){
  
  var height = parseInt($(".preview").css("height").replace("px", ""));
  var width = parseInt($(".preview").css("width").replace("px", ""));
  
  $(".draggable.active").removeClass("active");
  $(item).addClass("active");
  
  $(".blocks input[name='text']").val($(item).text());
  
  var eheight = parseInt($(item).css("height").replace("px", ""));
  var ewidth = parseInt($(item).css("width").replace("px", ""));

  height = Math.round(eheight * 100 / height);
  width = Math.round(ewidth * 100 / width);
  
  $(".blocks input[name='width']").val(width);
  $(".blocks input[name='height']").val(height);
  
  var index = $(item).css("z-index");
  if(index == "auto"){
    index = 0;
  }
  $(".blocks input[name='index']").val(index);
  
  if($(item).css("font-weight") > 400){
    $("#bold").prop('checked', true);
  } else {
    $("#bold").prop('checked', false);
  }
  
  if($(item).css("font-style") == "italic"){
    $("#italic").prop('checked', true);
  } else {
    $("#italic").prop('checked', false);
  }
  
  if($(item).css("text-decoration").search("underline") == 0 ){
    $("#underline").prop('checked', true);
  } else {
    $("#underline").prop('checked', false);
  }
  
  switch($(item).children("p").css("text-align")){
    case "center":
      $("#center").prop('checked', true);
      break;
    case "right":
      $("#right").prop('checked', true);
      break;
    case "justify":
      $("#justify").prop('checked', true);
      break;
    default:
      $("#left").prop('checked', true);
  }
  
  $(".editor .tools #colorlabel").css("background-color", $(item).css("color"));
  
  $("#size").val($(".draggable.active p").css("font-size").replace("px", ""));
  
  $("#font").val($(item).css("font-family"));

}

function LoadMaket() {
  
  var elem = document.getElementById("maket");
  var window = document.getElementById("preview");
  
  if(elem != null){
    var path = elem.options[elem.selectedIndex].getAttribute("path");
    
    fetch(path).then(function(response) {
      response.text().then(function(json) {
        
        json = JSON.parse(json);
        
        var items = json["items"];
        
        $(".preview").css("background-image", "url('"+json["background"]+"')");
        
        $("#picture").val(json["value"]);
        
        var result = "";
        
        if(items != null) {
          
          for(var i = 0; i < items.length; i++){

            var item = items[i];

            result += "<div class='draggable ui-widget-content'";

            result += "style='" +
              SetCSS("width", item["width"], "20%")+
              SetCSS("height", item["height"], "8%")+
              SetCSS("top", item["top"], "0px")+
              SetCSS("left", item["left"], "0px")+
              SetCSS("z-index", item["z-index"], "auto")+
              SetCSS("font-family", item["font-family"], "sans")+
              SetCSS("font-weight", item["font-weight"], "400")+
              SetCSS("font-style", item["font-style"], "normal")+
              SetCSS("text-decoration", item["text-decoration"], "none")+
              SetCSS("color", item["color"], "black")+
              "'";

            result += "><p style='"+
              SetCSS("text-align", item["text-align"], "center")+
              SetCSS("font-size", item["font-size"], "16px")+
              "'>"+item["text"]+"</p></div>";
          }
        
        }
        
        window.innerHTML = result;
        
        SetAction();
        
      });
    });
  }
  
}

function SetCSS(text, value, base){
  if(value != null) {
    return text+":"+value+";";
  } else {
    return text+":"+base+";";
  }
}