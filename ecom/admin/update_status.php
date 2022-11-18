<?php
include('connection.inc.php');
if(isset($_POST['submit']))
{
    $order_id = $_POST['order_id'];
     $update_order_status = $_POST['update_order_status'];
     mysqli_query($con,"update porder set order_status ='$update_order_status'  where id = '$order_id' ");
     header('location:order_master.php');
}


?>