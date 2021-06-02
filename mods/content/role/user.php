<?php
  
  $myorders = $mysqli->query("SELECT orders.id, orders.end_date, inwork.result, inwork.date_end FROM orders left join inwork on orders.id = inwork.order WHERE client = ".$user) or die("Ошибка " . mysqli_error($mysqli));

  $inwork = $mysqli->query("SELECT `order`,`date_start`,`date_end`, id FROM `inwork` WHERE `worker` = ".$user) or die("Ошибка " . mysqli_error($mysqli));

?>

<style>
  
  label.file {
    transition-duration: 0.2s;
    height: 100%;
    min-width: 100px;
    padding: 4px;
    margin: 0;
  }
  
  label.file:hover {
    background-color: #3a8dcb;
    color: white;
  }
  
</style>

<h1>Пользователь</h1>
<div class="line">
  <div>
    <h1>Мои заказы</h1>
    <table>
      <tbody>
        <tr>
          <th>Заказ</th>
          <th>Конечная дата</th>
          <th>Дата выполнения</th>
          <th>Операция</th>
        </tr>
        
        <?php 
        
        if($myorders){
          for($i = 0; $i < $myorders->num_rows; $i++){
            $row = mysqli_fetch_row($myorders);
            echo "
            <tr>
              <td><a href='Index.php?page=6&id=".$row[0]."'>Заказ ".($row[0]+1)."</a></td>
              <td>".$row[1]."</td>
              <td>".$row[3]."</td>
              <td>";
                
            if(isset($row[2])){
              if(strlen($row[2]) > 0){
                echo "<a class='button' href='".$row[2]."'><i class='fa fa-download' aria-hidden='true'></i></a>";
              }
            }
            
            echo "<a class='button' href='app/order/remove.php?order=".$row[0]."' ><i class='fa fa-trash aria-hidden='true'></i></a>
              </td>
            </tr>";
          }
        }
        
        ?>
      </tbody>
    </table>
  </div>
  <div>
    <h1>Заказы для выполнения</h1>
    <table>
      <tbody>
        <tr>
          <th>Заказ</th>
          <th>Дата начала</th>
          <th>Дата завершения</th>
          <th>Операция</th>
        </tr>
        <?php
        
          if($inwork){
            for($i = 0; $i < $inwork->num_rows; $i++){
              $row = mysqli_fetch_row($inwork);
              echo "
              <tr>
                <td><a href='Index.php?page=6&id=".$row[0]."'>Заказ ".($i+1)."</a></td>
                <td>".$row[1]."</td>
                <td>".$row[2]."</td>
                <td>".'<input type="file" id="file" accept="image/*">
                    <label class="file" for="file">Выбрать файл</label>
                    <input id="sendresult" type="button" onclick="UploadFile('.$row[3].')" value="Отправить">
                    <div class="ajax-respond"></div>'.
                "</td>
              </tr>";
            }
          }

        ?>
      </tbody>
    </table>
  </div>
</div>


<?php

  mysqli_free_result($myorders);
  mysqli_free_result($inwork);

?>

<script>
  
  var files;
  
  $('input[type=file]').change(function(){
    files = this.files;
    $("label.file").text(this.files[0].name);
  });
  
</script>