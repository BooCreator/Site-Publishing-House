<?php 

  include "../../ext/database.php";

  if(!isset($_COOKIE['userID'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Войдите в систему!");
  }
  
  $userID = GetLoginedUserPID();
  $user = GetLoginedUser("id");
  $role = GetLoginedUser("role");
  
  if(!isset($_COOKIE['userID'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Пользователь не найден!");
  }
  
  $mysqli = MySQLConnect();

  if($role == 2 || $role == 1){
    
    if(isset($_GET["bind"]) && isset($_GET["order"]) && isset($_GET["worker"])){
      
      if($_GET["bind"] == 1){
        
        $id = MySQLGetMaxID($mysqli, "inwork") + 1;
        
        $mysqli->query("INSERT INTO inwork(id,worker,`order`,`date_start`,`date_end`) values(".$id.",".$_GET["worker"].",".$_GET["order"].",'".GetNowDate()."',NULL)") or die("Ошибка: ".mysqli_error($mysqli)); 
        
      } else {
        $mysqli->query("DELETE FROM inwork WHERE `order` = ".$_GET["order"]." and worker = ".$_GET["worker"]) or die("Ошибка: ".mysqli_error($mysqli));
      }
      MySQLClose($mysqli);
      header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
  } else {
    MySQLClose($mysqli);
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=У вас недостаточно прав доступа!");
  }

  MySQLClose($mysqli);
  
?>