<?php

  $mysqli = MySQLConnect();

  $makets = $mysqli->query("SELECT id, title, data, public FROM maket") or die("Ошибка " . mysqli_error($mysqli));
  $images = $mysqli->query("SELECT id, title, path FROM images") or die("Ошибка " . mysqli_error($mysqli));
  $paper_type = $mysqli->query("SELECT id, title FROM paper_type ORDER BY id") or die("Ошибка " . mysqli_error($mysqli));
  $paper_format = $mysqli->query("SELECT id, title FROM paper_format ORDER BY title") or die("Ошибка " . mysqli_error($mysqli));

  $order = NULL;
  $value = 0;

  if(isset($_GET["id"])){
    $ordervalues = $mysqli->query("SELECT maket, comment, count, paper_format, paper_type, size FROM orders WHERE id = ".$_GET["id"]) or die("Ошибка " . mysqli_error($mysqli));
    if($ordervalues){
      if($ordervalues->num_rows > 0) {
        $order = mysqli_fetch_row($ordervalues);
      }
    }
  }

  MySQLClose($mysqli);
  
?>


<div class="content page">
      
  <h1>Конструктор</h1>
      
  <div class="background">
    
    <div id="color-picker" class="cp-default">
      <div class="picker-wrapper">
        <div id="picker" class="picker"></div>
        <div id="picker-indicator" class="picker-indicator"></div>
      </div>
      <div class="slide-wrapper">
        <div id="slide" class="slide"></div>
        <div id="slide-indicator" class="slide-indicator"></div>
      </div>
      <p>Нажмите ESC для выхода</p>
    </div>
    
    
    
  </div>
  
      <div class="line">
        <form id="editorform" action="app/construct.php" method="post">
          <div class="editor">

              <div class="tools">
                
                <select id="font" name="font">
                  <option value="sans">Sans</option>
                  <option value="Arial">Arial</option>
                  <option value="Verdana">Verdana</option>
                  <option value="Times New Roman">Times New Roman</option>
                  <option value="Roboto">Roboto (Android)</option>
                  <option value="Helvetica">Helvetica (IOS)</option>
                </select>
                
                <select id="size" name="size">
                  
                  <?php
                  
                    for($i = 12; $i < 99; $i++){
                      echo '<option value="'.$i.'">'.$i.'px</option>';
                    }
                  
                  ?>
                  
                </select>
                
                
                <input type="checkbox" id="bold" name="bold" hidden>
                <label for="bold">B</label>
                
                <input type="checkbox" id="italic" name="italic" hidden>
                <label for="italic">I</label>
                
                <input type="checkbox" id="underline" name="underline" hidden>
                <label for="underline">U</label>
                
                <input type="checkbox" id="color" name="color" hidden>
                <label id="colorlabel" for="color"></label>
                
                <input type="radio" id="left" name="align" hidden>
                <label for="left">
                  <i class="fa fa-align-left" aria-hidden="true"></i>
                </label>
                <input type="radio" id="center" name="align" hidden>
                <label for="center">
                  <i class="fa fa-align-center" aria-hidden="true"></i>
                </label>
                <input type="radio" id="right" name="align" hidden>
                <label for="right">
                  <i class="fa fa-align-right" aria-hidden="true"></i>
                </label>
                <input type="radio" id="justify" name="align" hidden>
                <label for="justify">
                  <i class="fa fa-align-justify" aria-hidden="true"></i>
                </label>
                
                <input id="newblock" type="button" value="Добавить блок">
                
              </div>

              <div class="template">
                
                <div class="window">
                  
                  <div id="preview" class="preview">
                    
                  </div>
                  
                </div>
                
                <div class="blocks">
                  
                  <h3>Выбранный элемент</h3>
                  
                  <label for="text">Текст</label>
                  <input type="text" name="text">
                  
                  <label for="width">Ширина (%)</label>
                  <input class="onlyNum" type="text" name="width">
                  
                  <label for="height">Высота (%)</label>
                  <input class="onlyNum" type="text" name="height">
                  
                  <label for="index">№ слоя</label>
                  <input class="onlyNum" type="text" name="index">
                  
                  <p></p>
                  <h3>Общее</h3>
                  
                  <label for="count">Количество (шт)</label>
                  <input id="count" class="onlyNum" type="text" name="count" value="<?php echo $order[2]; ?>">
                  
                  <label for="picture">Фон</label>
                  <select id="picture" name="picture">
                    
                    <?php 
                    
                    if($images) {
                      $rows = mysqli_num_rows($images);
                      for($i = 0; $i < $rows; $i++) {
                        $row = mysqli_fetch_row($images);
                        echo '<option value="'.$row[0].'" path="'.$row[2].'">'.iconv("UTF-8", "UTF-8", $row[1]).'</option>';
                      }
                    }
                    
                    ?>
                    
                  </select>
                  
                  <p></p>
                  
                  <div class="tools">
                  
                    <input type="file" id="file" accept="image/*">
                    <label for="file" class="long"><i class="fa fa-upload" aria-hidden="true"></i></label>

                    <input id="sendfile" type="button" value="Отправить">

                    <div class="ajax-respond"></div>

                  </div>
                  
                </div>
                
              </div>
            
              <div>
                
                <div class="tools">
                  
                  <select id="maket" name="maket" onchange="LoadMaket()">
                    
                    <?php 
                    
                    if(isset($order)) {
                      
                      if($makets) {
                        $rows = mysqli_num_rows($makets);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($makets);
                          echo '<option value="'.$row[0].'" path="'.$row[2].'"';
                        
                          if($row[0] == $order[0]){
                            echo " selected";
                          }
                          echo '>'.iconv("UTF-8", "UTF-8", $row[1]).'</option>';
                        }
                      }
                      
                    } else {
                      
                      if($makets) {
                        $rows = mysqli_num_rows($makets);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($makets);
                          echo '<option value="'.$row[0].'" path="'.$row[2].'"';
                        
                          if($row[3] == 0) {
                            echo " hidden";
                          }
                          echo '>'.iconv("UTF-8", "UTF-8", $row[1]).'</option>';
                        }
                      }
                      
                    }
                    
                    ?>
                  </select>
                  
                  <label for="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></label>
                  <input id="refresh" type="button" onclick="SetAction()" hidden>
                  
                  <select id="paper_format" name="paper_format">
                                        
                    <?php 
                    
                    if(isset($order)){
                      
                      if($paper_format) {
                        $rows = mysqli_num_rows($paper_format);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($paper_format);
                          if($row[0] == $order[3]){
                            echo '<option value="'.$row[0].'" selected>'.$row[1].'</option>';
                          } else {
                            echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                          }
                        }
                      }
                      
                    } else {
                      
                      if($paper_format) {
                        $rows = mysqli_num_rows($paper_format);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($paper_format);
                          echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                        }
                      }
                      
                    }
                    
                    
                    ?>
                    
                  </select>
                  
                  <select id="paper_type" name="paper_type">
                    
                    <?php
                    
                    if(isset($order)){
                      
                      if($paper_type) {
                        $rows = mysqli_num_rows($paper_type);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($paper_type);
                          if($row[0] == $order[4]){
                            echo '<option value="'.$row[0].'" selected>'.$row[1].'</option>';
                          } else {
                            echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                          }
                        }
                      }

                    } else {
                    
                      if($paper_type) {
                        $rows = mysqli_num_rows($paper_type);
                        for($i = 0; $i < $rows; $i++) {
                          $row = mysqli_fetch_row($paper_type);
                          echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                        }
                      }
                      
                    }
                    
                    ?>
                    
                  </select>
                  
                </div>
                
                <div>
                  <label for="comment">Комментарий</label>
                  <textarea maxlength="256" id="comment" name="comment"><?php if(isset($order)){ echo $order[1];} ?></textarea>
                  <p></p>
                  <input id="submiter" type="submit" value="Отправить">
                </div>
                
              </div>
              
          </div>
        </form>
      </div>
      
    </div>

<script>
  
  var files;
  
  $('input[type=file]').change(function(){
    files = this.files;
    $(".content .line form .editor .tools label.long").html('<i class="fa fa-upload" aria-hidden="true"></i> ' + this.files[0].name);
  });
  
  SetAction();
  
  LoadMaket();
  
  cp = ColorPicker(
    document.getElementById('slide'),     document.getElementById('picker'), 
    function(hex, hsv, rgb, mousePicker, mouseSlide) {
      currentColor = hex;
      ColorPicker.positionIndicators(
          document.getElementById('slide-indicator'),
          document.getElementById('picker-indicator'),
          mouseSlide, mousePicker);
      $(".editor .tools #colorlabel").css("background-color", hex);
      $(".draggable.active").css("color", hex);
    });
  cp.setHex('#D4EDFB');
  
</script>