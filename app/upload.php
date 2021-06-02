<?php
 
// Здесь нужно сделать все проверки передаваемых файлов и вывести ошибки если нужно

include "../ext/database.php";

$data = array();
 
$id = -1;
$path = "";
$filename = "Image";
$error = false;

// Массив с названиями ошибок
$errorMessages = [
  UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
  UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
  UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
  UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
  UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
  UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
  UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
];

// Зададим неизвестную ошибку
$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';


if(isset( $_GET['uploadfiles'] ) ) {
   
  $uploaddir = '../data/img/'; // папка хранения файлов
 
  // Создадим папку если её нет

  if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

  // переместим файлы из временной директории в указанную
  if(!$error){
    foreach( $_FILES as $file ){
      if(is_uploaded_file($file['tmp_name'])){
      
        if( move_uploaded_file( $file['tmp_name'], $uploaddir.basename($file['name']) ) ){
          
          $mysqli = MySQLConnect();
          
          $id = MySQLGetMaxID($mysqli, "images") + 1;
          $filename = $file['name'];
          $path = $uploaddir.$file['name'];
          
          if(!$mysqli->query("INSERT INTO images(id,title,path) values(".$id.",'".$filename."','".$path."')")){
            $error = true;
            $err = array('0' => $mysqli->error);
          }
          
          MySQLClose($mysqli);
          
        } else {
          $error = true;
          $err = array('0' => "Ошибка копирования файла!");
        }
      } else {
        
        $errorCode = $file['error'];
        
        $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
        
        $error = true;
        $err = array('0' => $outputMessage);
      }
    }
  }

  $data = $error ? array('error' => $err) : array('text' => "<option value=".$id." path='".$path."'>".$filename."</option>" );
 
  echo json_encode( $data );
  
}