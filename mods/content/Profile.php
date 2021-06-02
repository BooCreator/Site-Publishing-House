<div class="content page">
  
  <?php
    
    $role = GetLoginedUser("role");
  
    $mysqli = MySQLConnect();

    switch($role) {
      case 2:
        include "role/admin.php";
        include "role/manager.php";
        include "role/user.php";
        break;
      case 1:
        include "role/manager.php";
        include "role/user.php";
        break;
      default: 
        include "role/user.php";
    }
    
    MySQLClose($mysqli);
  
  ?>
  
</div>