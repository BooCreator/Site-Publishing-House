<?php 
  include "../ext/database.php";

  session_start();

  $name = $_POST["name"];
  $mail = $_POST["mail"];
  $phone = $_POST["phone"];
  $pass = $_POST["pass"];

  $mysqli = MySQLConnect();

  $res = $mysqli->query("SELECT id FROM user WHERE mail LIKE '".$mail."'") or die("Ошибка " . mysqli_error($mysqli)); 

  if($res){
    $rows = mysqli_num_rows($res);
    if($rows > 0){
      echo "Пользователь с указанными данными(E-mail) существует!";
    } else {
      $id = 0;
      mysqli_free_result($res);
      if($res = $mysqli->query("SELECT MAX(id) FROM user")) {
        if($res->num_rows > 0) {
          $row = mysqli_fetch_row($res);
          $id = 1 + $row[0];
        }
      }
      if($mysqli->query("INSERT INTO user(id,name,mail,phone,password,role) values(".$id.",'".$name."','".$mail."','".$phone."','".sha1($pass)."',0)")){ 
        header("Location: " . $_SESSION['prevPg']);
      } else {
        echo $mysqli->error;
      }
    }
  } else {
    echo $mysqli->error;
  }
  mysqli_free_result($res);

  MySQLClose($mysqli);

?>