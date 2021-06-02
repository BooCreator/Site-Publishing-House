<?php 

  include "../ext/database.php";

  if(!isset($_COOKIE['userID'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Войдите в систему!");
  }
  
  $user = GetLoginedUser("id");
  
  if($user < 0) {
    header("Location: ".$_SERVER['HTTP_REFERER']."&error=Пользователь не найден!");
  }
  
  echo "<a href=''>Скачать файл</a>";

?>