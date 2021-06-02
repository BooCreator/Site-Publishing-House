<?php

  $workers = $mysqli->query("SELECT id, name FROM user WHERE role = 3 or role = 0") or die("Ошибка " . mysqli_error($mysqli)); 
  $orders = $mysqli->query("SELECT orders.id, orders.end_date, inwork.worker FROM orders LEFT JOIN inwork ON inwork.order = orders.id ORDER BY id") or die("Ошибка " . mysqli_error($mysqli)); 

  $workers_list = "";

  for($j = 0; $j < $workers->num_rows; $j++){
    $row = mysqli_fetch_row($workers);
    $workers_list .= "<option value='".$row[0]."'>".$row[1]."</option>";
  }
  

?>

<h1>Менеджер</h1>
<div class="line">
  <form action="" method="post">
    <table>
      <tbody>
        <tr>
          <th>Заказ</th>
          <th>Конечная дата</th>
          <th>Исполнитель</th>
          <th>Операция</th>
        </tr>
        <?php
          
          if($orders){
            for($i = 0; $i < $orders->num_rows; $i++){
              $row = mysqli_fetch_row($orders);
              echo "<tr>
                <td><a href='Index.php?page=6&id=".$row[0]."'>Заказ ".($row[0]+1)."</a></td>
                <td>".$row[1]."</td>";
                
              if(isset($row[2])){
                
                $workername = $mysqli->query("SELECT name FROM user WHERE id = ".$row[2]) or die("Ошибка " . mysqli_error($mysqli)); 
                
                if($workername){
                  if($workername->num_rows > 0){   
                    $row3 = mysqli_fetch_row($workername);
                    $workername = $row3[0];
                  } else {
                    $workername = "Не определено";
                  }
                }

                echo "<td>".$workername."</td>";
                echo "<td>
                  <a class='button' href='app/order/bind.php?bind=0&page=12&order=".$row[0]."&worker=".$row[2]."'>Отвязать</a>";
                if($role == 2){
                  echo "<a class='button' href='app/order/remove.php?order=".$row[0]."' ><i class='fa fa-trash aria-hidden='true'></i></a>";
                }
                echo "</td>";
              } else {
                if($workers) {
                  echo "<td><select id='editors".$i."' name='editors".$i."'>";
                  
                  echo $workers_list;
                  
                  echo "</select></td>";
                  echo "<td>
                    <input type='button' onclick='BindOrder(".$row[0].",\"editors".$i."\")' value='Назначить'>";
                  if($role == 2){
                    echo "<a class='button' href='app/order/remove.php?order=".$row[0]."' ><i class='fa fa-trash aria-hidden='true'></i></a>";
                  }
                  echo "</td>";
                }
              }
              echo "</tr>";
            }
          }
        
        ?>
      </tbody>
    </table>
    
  </form>
</div>

<?php

  mysqli_free_result($workers);
  mysqli_free_result($orders);

?>