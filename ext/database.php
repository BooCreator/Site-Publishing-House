<?php
function MySQLConnect() {
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $db = "database";
  $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
  
  mysqli_set_charset($conn, "utf8");
  
  return $conn;
}

function MySQLClose($conn) {
  $conn -> close();
}

function GetLoginedUser($param) {
  
  $result = -1;
  
  if(isset($_COOKIE['userID'])) {
      
    $mysqli = MySQLConnect();

    $res = $mysqli->query("SELECT ".$param." FROM user WHERE id = ".$_COOKIE['userID']); 

    if($res) {
      if($res->num_rows > 0){
        $row = mysqli_fetch_row($res);
        $result = $row[0];
      }
    }

    mysqli_free_result($res);

    MySQLClose($mysqli);
    
  }
  return $result;
}

function GetLoginedUserPID() {
  $result = -1;
  if(isset($_COOKIE['userID'])) {
    $result = $_COOKIE['userID'];
  }
  return $result;
}

function MySQLGetMaxID($mysqli, $table) {
  
  $res = $mysqli->query("SELECT MAX(id) FROM ".$table); 

    if($res) {
      if($res->num_rows > 0){
        $row = mysqli_fetch_row($res);
        return $row[0];
      }
    }
  
  return -1;
  
}

function GetNewDate() {
    $date = new DateTime(date('Y-m-d'));
    $date->add(new DateInterval('P10D'));
    return $date->format('d.m.Y');
}

function GetNowDate() {
  $date = new DateTime(date('Y-m-d'));
  return $date->format('d.m.Y');
}

?>