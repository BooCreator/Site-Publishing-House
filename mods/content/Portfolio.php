<div class="content page">
      
  <h1>Наши работы</h1>
      
  <div class="line">
    <div class="gallery row">
      
      <?php
      
        $result = -1;
  
        $mysqli = MySQLConnect();
  
        $res = $mysqli->query("SELECT src FROM portfolio");
  
        if($res) {
          for($i = 0; $i < $res->num_rows; $i++){
            $row = mysqli_fetch_row($res);
            echo "<a data-fancybox='gallery' href='$row[0]'><img src='$row[0]'></a>";
          }          
        }
  
        mysqli_free_result($res);

        MySQLClose($mysqli);
      
      ?>
      
    </div>
  </div>
</div>

