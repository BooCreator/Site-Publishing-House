<?php 
  include "../ext/database.php";

  session_start();

  $mail = $_POST["mail"];
  $pass = $_POST["pass"];

  $mysqli = MySQLConnect();

  $res = $mysqli->query("SELECT id FROM user WHERE mail LIKE '".$mail."' and password LIKE '".sha1($pass)."'") or die("Ошибка " . mysqli_error($mysqli)); 

  if($res){
    $rows = mysqli_num_rows($res);
    if($rows < 1){
      echo "Пользователь с указанными данными(E-mail + Пароль) не существует!";
    } else {
      $row = mysqli_fetch_row($res);
      setcookie("userID", $row[0], time()+(86400 * 30), '/');
      if (@$_SERVER['HTTP_REFERER'] != null) {
        header("Location: " . $_SESSION['prevPg']);
        exit;
      }
      Sys::GoHome();
    }
  } else {
    echo $mysqli->error;
  }
  mysqli_free_result($res);

  MySQLClose($mysqli);

?>