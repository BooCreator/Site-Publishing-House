<?php 

  include "../../ext/database.php";

  if(!isset($_COOKIE['userID'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Войдите в систему!");
  }
  
  $error = false;
  $errorMsg = "";

  $userID = GetLoginedUserPID();
  $user = GetLoginedUser("id");
  $role = GetLoginedUser("role");
  
  if(!isset($_COOKIE['userID'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Пользователь не найден!");
  }

  if($role == 2)
  {
    
    if(isset($_GET["order"]))
    {
      
      $mysqli = MySQLConnect();
      
      if(!$mysqli->query("DELETE FROM orders WHERE id = ".$_GET["order"])) {
        $error = true;
        $errorMsg = mysqli_error($mysqli);
      }
      
      if(!$mysqli->query("DELETE FROM inwork WHERE `order` = ".$_GET["order"])) {
        $error = true;
        $errorMsg = mysqli_error($mysqli);
      }
      
      MySQLClose($mysqli);

    } else {
      $error = true;
      $errorMsg = "Номер заказа не определен!";
    }
    
  } else {
    $error = true;
    $errorMsg = "У вас недостаточно прав для удаления заказов!";
  }

  if($error){
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=".$errorMsg);
  } else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
  }

?>