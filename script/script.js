function BindOrder(order, select){
  var workerID = document.getElementById(select).value;
  
  window.location.href = "app/order/bind.php?bind=1&order="+order+"&worker="+workerID;
}