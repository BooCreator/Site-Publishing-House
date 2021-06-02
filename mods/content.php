<?php  

  if($page == 0)
    include "mods/content/Main.php";
    
  if($page == 1)
    include "mods/content/Portfolio.php";
    
  if($page == 2)
    include "mods/content/Price.php";
      
  if($page == 3)
    include "mods/content/News.php";
        
  if($page == 4)
    include "mods/content/Clients.php";
    
  if($page == 5)
    include "mods/content/Contacts.php";

  if($page == 6)
    include "mods/content/Editor.php";

  if($page == 7)
    include "mods/content/Registration.php";

  if($page == 8)
    include "mods/content/Enter.php";

  if($page == 9)
    include "app/exit.php";

  if($page == 10)
    include "mods/content/Profile.php";

?>