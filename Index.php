<?php

  // main portfolio price news clients contacts editor regisration enter exit profile 
  // 0    1         2     3    4       5        6      7           8     9    10    

  include "about.php";

  include "ext/database.php";
  
  $page = 0;

  $userID = -1;
  $user = -1;

  if(isset($_GET["page"])){
    $page = $_GET["page"];
  }

  if(!isset($_COOKIE['userID'])) {
    switch($page){
      case 6: 
        header("Location: ".$_SERVER['HTTP_REFERER']."&error=Для использования конcтруктора войдите в систему!");
        break;
      case 7: case 8:
        session_start();
        $_SESSION['prevPg'] = $_SERVER['HTTP_REFERER'];
        break;
      case 10:
        header("Location: ".$_SERVER['HTTP_REFERER']."&error=Войдите в систему для перехода на страницу профиля!");
        break;
    }
    
  } else {
    
    //увеличиваем срок службы куков, отвечающих за вход пользователя
    setcookie("userID", $_COOKIE['userID'], time()+(86400 * 30), '/');
    
    $userID = GetLoginedUserPID();
    $user = GetLoginedUser("id");
    
    if($page == 10 && $user < 0) {
      header("Location: ".$_SERVER['HTTP_REFERER']."&error=Пользователь не найден!");
    }
    
  }


?>

<HTML>
  
  <?php include "mods/head.php" ?>
  
  <BODY>
    
    <script>
      new WOW().init();
    </script>
    
    <?php include "mods/login.php" ?>
    
    <?php include "mods/header.php" ?>
    
    <?php include "mods/menu.php" ?>
    
    <?php include "mods/content.php" ?>
    
    <?php include "mods/footer.php" ?>
    
  </BODY>
  
</HTML>