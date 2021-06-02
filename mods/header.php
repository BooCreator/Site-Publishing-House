<?php
  $pos = strpos($ORGNAME, ' ');
?>

<header class="page">

  <div class="logo">
    <i class="fa fa-quora" aria-hidden="true"></i>
    <p>
      <?php echo substr($ORGNAME, 0, $pos) ?>
      <br/>
      <?php echo substr($ORGNAME, $pos, strlen($ORGNAME)-$pos) ?>
    </p>
  </div>

  <div class="contacts">
    <div class="phones">
      <div>
        <i class="fa fa-phone" aria-hidden="true"></i>
        <p><?php echo $PHONEFAX; ?></p>
      </div>
      <div>
        <i class="fa fa-phone" aria-hidden="true"></i>
        <p><?php echo $PHONE; ?></p>
      </div>
    </div>
    <div class="phones">
      <div>
        <div class="mts"></div>
        <p><?php echo $PHONEMTS; ?></p>
      </div>
      <div>
        <div class="vel"></div>
        <p><?php echo $PHONEA1; ?></p>
      </div>
    </div>
    <div class="phones">
      <div>
        <div class="life"></div>
        <p><?php echo $PHONELIFE; ?></p>
      </div>
      <div>
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <p><?php echo $EMAIL; ?></p>
      </div>
    </div>
  </div>

</header>