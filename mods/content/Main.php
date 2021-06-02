<?php

$mysqli = MySQLConnect();

$block = $mysqli->query("SELECT id, title, fields FROM blocks") or die("Ошибка " . mysqli_error($mysqli));

?>


<div class="video">
  <div class="foreground">
    <p class="page">Полиграфия и рекламная продукция <br/>
      для Вас и вашего бизнеса</p>
  </div>
  <video id="myvideo" autoplay="true" loop="true" muted="true" >
    <source src="https://snorovka.by/video/video_bg.mp4" tpe="video/mp4">
    <source src="https://snorovka.by/video/video_bg.ogv" tpe="video/ogg">
    <source src="https://snorovka.by/video/video_bg.webm" tpe="video/webm">
  </video>
</div>
    
<div class="content page">
      
  <?php
  
  for($i = 0; $i < $block->num_rows; $i++){
    $row = mysqli_fetch_row($block);
    $data = $mysqli->query("SELECT text, text2, image FROM block_data WHERE block = ".$row[0]) or die("Ошибка " . mysqli_error($mysqli));
    
    if($row[2] == 1){
      echo 
        '<div class="line cols">'.
          '<div class="mpage">'.
            '<p class="title">'.$row[1].'</p>'.
          '</div>'.
          '<div class="mpage">';
      
      for($j = 0; $j < $data->num_rows; $j++){
        $row2 = mysqli_fetch_row($data);
        echo '<p class="wow rollIn " data-wow-duration="0.6s">'.$row2[0].'</p>';
      }
      
      echo 
          '</div>'.
        '</div>';
    } else if($row[2] == 3) {
      
      echo 
        '<div class="line cols">'.
          '<div class="mpage">'.
            '<p class="title">'.$row[1].'</p>'.
          '</div>'.
        '</div>';
      
      for($j = 0; $j < $data->num_rows; $j++){
        $row2 = mysqli_fetch_row($data);
        if($j & 1){
          echo 
            '<div class="line wow slideInRight" data-wow-duration="0.6s">'.
              '<div class="main lg">'.
                '<div>'.
                  '<p class="title">'.$row2[0].'</p>'.
                  '<p class="text">'.$row2[1].'</p>'.
                '</div>';
          echo 
            '<div class="img">
              <img src="'.$row2[2].'">
            </div>';
            
          echo '</div></div>';
        } else {
          echo 
            '<div class="line wow slideInLeft" data-wow-duration="0.6s">'.
              '<div class="main lg">';
          echo 
            '<div  class="img">
              <img src="'.$row2[2].'">
            </div>';
          
          echo 
                '<div>'.
                  '<p class="title">'.$row2[0].'</p>'.
                  '<p class="text">'.$row2[1].'</p>'.
                '</div>';

          echo '</div></div>';
        }
      }
      
    }

    mysqli_free_result($data);
    
  }
  
  mysqli_free_result($block);
  
  MySQLClose($mysqli);
  
  ?>
      
</div> 