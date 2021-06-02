<?php
  //если на страницу вернули с другой, на которой 
  //произошла ошибка указана ошибка, то вывести ее
  if(isset($_GET["error"])){
    echo "<script>alert('".$_GET["error"]."');</script>";
  }
?>

<div class="main menu">
  <div class="page">
    
    <ul class="items">
      <?php
      
        if($page != 0)
          echo '<li><a href="Index.php?page=0">Главная</a></li>';
        else
          echo '<li><a class="active">Главная</a></li>';
      
        if($page != 1)
          echo '<li><a href="Index.php?page=1">Портфолио</a></li>';
        else
          echo '<li><a class="active">Портфолио</a></li>';
      
        if($page != 2)
          echo '<li><a href="Index.php?page=2">Прайс</a></li>';
        else
          echo '<li><a class="active">Прайс</a></li>';
        
        if($page != 4)
          echo '<li><a href="Index.php?page=4">Клиенты</a></li>';
        else
          echo '<li><a class="active">Клиенты</a></li>';
      
        if($page != 5)
          echo '<li><a href="Index.php?page=5">Контакты</a></li>';
        else
          echo '<li><a class="active">Контакты</a></li>';
        
        if($page != 6)
          echo '<li><a href="Index.php?page=6">Конструктор</a></li>';
        else
          echo '<li><a class="active">Конструктор</a></li>';
      ?>

    </ul>
    
  </div>
</div>