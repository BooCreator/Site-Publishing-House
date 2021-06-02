$(document).ready(function() {
  
  // click events
  
  $("#newblock").click(function(){
    var elem = "<div class='draggable ui-widget-content' style='width:20%; height: 8%; top: 4%; left: 4%;'><p></p></div>"
    $(".preview").html($(".preview").html() + elem);
    SetAction();
  });
  
  $("#bold").click(function() {
    var value = 400;
    if($(this).prop("checked")){
      value = 700;
    }
    $(".draggable.active").css("font-weight", value);
  })
  
  $("#italic").click(function() {
    var value = "normal";
    if($(this).prop("checked")){
      value = "italic";
    }
    $(".draggable.active").css("font-style", value);
  })
  
  $("#underline").click(function() {
    var value = "none";
    if($(this).prop("checked")){
      value = "underline";
    }
    $(".draggable.active").css("text-decoration", value);
  })
  
  $("#left").click(function() {
    $(".draggable.active p").css("text-align", "left");
  })
  $("#center").click(function() {
    $(".draggable.active p").css("text-align", "center");
  })
  $("#right").click(function() {
    $(".draggable.active p").css("text-align", "right");
  })
  $("#justify").click(function() {
    $(".draggable.active p").css("text-align", "justify");
  })
  
  // chane events
  
  $("#font").change(function() {
    $(".draggable.active").css("font-family", $(this).val());
  })
  
  $("#size").change(function() {
    $(".draggable.active p").css("font-size", $(this).val()+"px");
  })
  
  // key events
  
  $(".blocks input[name='text']").keyup(function(){
    $(".draggable.active p").text($(this).val());
  });
  
  $(".blocks input[name='width']").keyup(function(){
    $(".draggable.active").css("width", $(this).val() + "%");
  });
  
  $(".blocks input[name='height']").keyup(function(){    
    $(".draggable.active").css("height", $(this).val() + "%");
  });
  
  $(".blocks input[name='index']").keyup(function(){
    $(".draggable.active").css("z-index", $(this).val());
  });
  
  $(".onlyNum").keydown(function(e) {
    return (!isNaN(parseInt(e.key, 10))) || e.keyCode == 46 || e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39;
  });

  $("#colorlabel").click(function(){
    if(!$("#color").prop("checked")){
      $(".background").css("top", 0);
      $(".background").css("opacity", 1);
    } else {
      $(".background").css("top", -10000);
      $(".background").css("opacity", 0);
    }
  });
  
  $("body").keyup(function(e){
    if(e.keyCode == 27){
      $(".background").css("top", -10000);
      $(".background").css("opacity", 0);
      $("#color").prop("checked", false);
    }
  });
  
  $("#picture").change(function(){
    var path = this.options[this.selectedIndex].getAttribute("path");
    $(".preview").css("background-image", "url('"+path+"')");
  });
  
  // Отправка файлов на сервер
  
  $("#editorform").submit(function() {
    var items = [];
    var elem = document.getElementById("picture");
    var path = elem.options[elem.selectedIndex].getAttribute("path");
    
    $("#preview div").each(function(i, elem) {
      
      var height = parseInt($(".preview").css("height").replace("px", ""));
      var width = parseInt($(".preview").css("width").replace("px", ""));
  
      var eheight = parseInt($(elem).css("height").replace("px", ""));
      var ewidth = parseInt($(elem).css("width").replace("px", ""));

      height = Math.round(eheight * 100 / height);
      width = Math.round(ewidth * 100 / width);

      items[i] = {
        "text":$(elem).children("p").text(),
        "width":width+"%",
        "height":height+"%",
        "top":$(elem).css("top"),
        "left":$(elem).css("left"),
        "z-index":$(elem).css("z-index"),
        "font-family":$(elem).css("font-family"),
        "font-style":$(elem).css("font-style"),
        "font-weight":$(elem).css("font-weight"),
        "font-size":$(elem).children("p").css("font-size"),
        "text-decoration":$(elem).css("text-decoration"),
        "text-align":$(elem).children("p").css("text-align"),
        "color":$(elem).css("color"),
      };
    });
    
    var mJSON = {
      "background":path,
      "value":$("#picture").val(),
      "items":items
    }
    
    var formData = {
      "paper_type":$("#paper_type").val(),
      "paper_format":$("#paper_format").val(),
      "count":$("#count").val(),
      "comment":$("#comment").val()
    };
    
    $.ajax({
      url:'app/construct.php',
      type:'POST',
      data:{
        jsonData: mJSON,
        formData: formData
      },
      success: function( msg ) {
        var json = JSON.parse(msg);
        if(json){
          if(json["msg"] === undefined){
            alert(json["error"]);
          } else {
            alert("Макет сохранен!");
          }
        }
      },
      error: function( response ){
        console.log(response.statusText);
      }
    });
    return false;
  });
  
  $('#sendfile').click(function( event ){
    event.stopPropagation(); // Остановка происходящего
    event.preventDefault();  // Полная остановка происходящего
 
    // Создадим данные формы и добавим в них данные файлов из files
 
    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });
 
    // Отправляем запрос
 
    $.ajax({
      url: 'app/upload.php?uploadfiles',
      type: 'POST',
      data: data,
      cache: false,
      dataType: 'json',
      processData: false, // Не обрабатываем файлы (Don't process the files)
      contentType: false, // Так jQuery скажет серверу что это строковой запрос
      success: function( respond, textStatus, jqXHR ) {
 
        // Если все ОК
 
        if( typeof respond.error === 'undefined' ){
          
          // Файлы успешно загружены, делаем что нибудь здесь
 
          $('.ajax-respond').html( 'Файл загружен!' );
          $('#picture').html($('#picture').html() + respond.text);
        } else {
          $('.ajax-respond').html( 'ERROR: ' + respond.error );
        }
      },
      error: function( jqXHR, textStatus, errorThrown ){
        $('.ajax-respond').html( 'ERROR: ' + textStatus + respond.error );
      }
    });
  });
  
});


function SetAction() {
  
  $(".draggable").mousedown(function (){
    ItemOnClick(this);
  });
  
  $(".draggable").draggable();

}


function UploadFile(id) {
  
  var data = new FormData();
  $.each( files, function( key, value ){
    data.append( key, value );
  });
  
  // Отправляем запрос
  $.ajax({
      url: 'app/uploadfile.php?id='+id+'&uploadfiles',
      type: 'POST',
      data: data,
      cache: false,
      dataType: 'json',
      processData: false, // Не обрабатываем файлы (Don't process the files)
      contentType: false, // Так jQuery скажет серверу что это строковой запрос
      success: function( respond, textStatus, jqXHR ) {
 
        // Если все ОК
 
        if( typeof respond.error === 'undefined' ){
          
          // Файлы успешно загружены, делаем что нибудь здесь
 
          $('.ajax-respond').html( 'Файл загружен!' );
          $('#picture').html($('#picture').html() + respond.text);
        } else {
          $('.ajax-respond').html( 'ERROR: ' + respond.error );
        }
      },
      error: function( jqXHR, textStatus, errorThrown ){
        $('.ajax-respond').html( 'ERROR: ' + textStatus );
      }
    });
}
