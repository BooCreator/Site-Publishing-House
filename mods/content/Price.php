<div class="content page">
      
  <h1>Прайс лист</h1>
      
  <div class="line">
    <table>
      <tbody>
      <tr>
          <th>Цветность, вид ламинации, вид бумаги</th>
          <th>1–5 комплектов*</th>
          <th>6 и более комплектов*</th>
      </tr>
          
      <?php
      
        $result = -1;
  
        $mysqli = MySQLConnect();
  
        $res = $mysqli->query("SELECT * FROM price");
  
        if($res) {
          for($i = 0; $i < $res->num_rows; $i++){
            $row = mysqli_fetch_row($res);
            echo '<tr>';
            echo '<td>'.$row[1].'</td>';
            echo '<td>'.number_format($row[2], 2, '.', ' ').'</td>';
            echo '<td>'.number_format($row[3], 2, '.', ' ').'</td>';
            echo '</tr>';
          }
        }
  
        mysqli_free_result($res);

        MySQLClose($mysqli);
      
      ?>
            
      </tbody>
    </table>
    <p>*указана стоимость за 1 комплект (100 шт.) с учетом НДС.</p>
  </div>
      
</div>