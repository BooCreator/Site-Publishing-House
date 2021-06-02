<?php 
  include "../ext/database.php";

  session_start();

  $error = false;
  $errorMsg = "";

/*
  $("#preview").each(function(i, elem) {
      items[i] = {
        "text":$(elem + " p").text(),
        "width":$(elem).css("width"),
        "height":$(elem).css("height"),
        "top":$(elem).css("top"),
        "left":$(elem).css("left"),
        "z-index":$(elem).css("z-index"),
        "font-family":$(elem).css("font-family"),
        "font-style":$(elem).css("font-style"),
        "font-weight":$(elem).css("font-weight"),
        "font-size":$(elem).css("font-size"),
        "text-decoration":$(elem).css("text-decoration"),
        "text-align":$(elem + " p").css("text-align"),
        "color":$(elem).css("color"),
      };
    });
    
    var JSON = {
      "background":path,
      "value":$("#picture").val(),
      "items":items
    }
    
  var formData = {
      "maket":$("#maket").val(),
      "paper_type":$("#paper_type").val(),
      "paper_format":$("#paper_format").val(),
      "count":$("#count").val(),
      "comment":$("#comment").val(),
      "image":$("#picture").val(),
      "items":items
    };
*/


  $JSON = json_encode($_POST["jsonData"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

  $obj = $_POST["formData"];

  $user = GetLoginedUser("id");

  if($user > -1){
    
    // сохранение данных о макете на диск
    $title = md5($JSON);
    $data = "data/mackets/".$title.".json";
    $fd = fopen("../".$data, 'w') or die("не удалось создать файл");
    fwrite($fd, $JSON);
    fclose($fd);

    // записываем данные в бд о макете
    $mysqli = MySQLConnect();
    $id = MySQLGetMaxID($mysqli, "maket") + 1;
    
    $query = "INSERT INTO maket(id,title,data,public) values(".$id.",'".$title."','".$data."',0)";
    if(!$mysqli->query($query)) {
      $error = true;
      $errorMsg = $mysqli->error;
    }
    
    if(!$error) {
      $mid = MySQLGetMaxID($mysqli, "orders") + 1;
      $date = new DateTime(date("Y-m-d"));
      $date->add(new DateInterval('P10D'));
      
      $count = 0;
      if(strlen($obj["count"]) > 0){
        $count = $obj["count"];
      }
      
      $query = "INSERT INTO orders(id,client,maket,comment,count,paper_format,size,paper_type,end_date)".
        "values(".$mid.",".$user.",".$id.",'".$obj["comment"]."',".$count.",".$obj["paper_format"].",'0:0',".
        $obj["paper_type"].",'".$date->format('Y-m-d')."')";
      
      if(!$mysqli->query($query)) {
        $error = true;
        $errorMsg = $mysqli->error;
      }
      
    }
    
    MySQLClose($mysqli);
  } else {
    $error = true;
    $errorMsg = "Пользователь не найден!";
  }

  $data = $error ? array('error' => $errorMsg) : array('msg' => "ok" );

  echo json_encode( $data );

?>