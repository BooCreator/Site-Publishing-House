<?php

  $userName = GetLoginedUser("name");

?>

<div class="menu login">
  <div class="page">
    
    <ul class="items">

    <?php
      if($userName > -1) {
        echo '
          <li class="right">
            <a href="app/exit.php" class="button">Выход</a>
          </li>
          <li class="right">
            <a href="Index.php?page=10?id='.$userID.'" class="button"><i class="fa fa-user-o" aria-hidden="true"></i> '.$userName.'</a>
          </li>
        ';
        
      } else {
    
        echo '
          <li class="right">
            <a href="Index.php?page=8" class="button">Вход</a>
          </li>
          <li class="right">
            <a href="Index.php?page=7" class="button">Регистрация</a>
          </li>
        ';
      
      }
    ?>
    
    
    </ul>
    
  </div>
</div>