<div class="content page">
  
  <h1>Наши клиенты</h1>
      
  <div class="line">
    <div class="gallery">
      
      <?php
      
        $result = -1;
  
        $mysqli = MySQLConnect();
  
        $res = $mysqli->query("SELECT src FROM clients");
  
        if($res) {
          for($i = 0; $i < $res->num_rows; $i++){
            $row = mysqli_fetch_row($res);
            echo '<img src="'.$row[0].'">';
          }
        }
  
        mysqli_free_result($res);

        MySQLClose($mysqli);
      
      ?>
      
    </div>
  </div>
      
</div>