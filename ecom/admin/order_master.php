<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from contact_us where id='$id'";
		mysqli_query($con,$delete_sql);
	}
}

$sql="select * from contact_us order by id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Master </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						
                         <thead>
                                <tr>
         <th><span class="nobr">Order ID</span></th>
    <th>OrderDate</th>
    <th ><span class="nobr">Address</span></th>
 <th>Payment Type</th>
    <th> Payment Status </th>
<th >Order Status</th>
                                            </tr>
                                        </thead>
						
						 <tbody>
							<?php
                            
                             //echo $uid;
                             //die();
$a = "select  porder.*,order_status.name as order_status_name  from
porder, order_status where  porder.order_status = order_status.id ";
                             // echo $a;
                             // die();
                       
                        $res = mysqli_query($con,$a);
                             //$res = mysqli_query($con,"select * from porder where user_id = '$uid'");
                             
                             while($row = mysqli_fetch_assoc($res))
                             {
                                  $id = $row['id'];
                                   $date   = $row['addes_on'];
                                   $address = $row['address'];
                                   $city = $row['city'];
                                   $pincode = $row['pincode'];
                                   $order_status_name = $row['order_status_name'];

                             
							?>
							<tr>
                            <td class="product-add-to-cart"><a href="order_master_details.php?id=<?php echo $row['id']; ?>"> <?php echo $row['id']; ?> </a></td>
                                                <td class="product-remove"><a href="#"><?php echo $date; ?></a></td>
                                                <td class="product-thumbnail"><a href="#">
												<?php  echo $address; ?><br>
												
												<?php  echo $row['city']; ?><br>
												<?php echo $row['pincode']; ?>
												</a></td>
                                                <td class="product-name"><a href="#"><?php  echo $row['payment_type']; ?></a></td>
                                                <td class="product-price"><span class="amount"><?php echo  $row['payment_status']; ?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo  $order_status_name; ?></span></td>
    
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
                      <div>
                      
                      </div>
                  <form>

                  </form>

				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php
require('footer.inc.php');
?>