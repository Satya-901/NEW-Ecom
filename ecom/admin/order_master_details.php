<?php
require('top.inc.php');
$order_id = get_safe_value($con,$_GET['id']);



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
                     <th >products</th>
                     <th >name of products</th>
                     <th>Price</th>
                     <th>Quantity</th>
                     <th>Total</th>
                                           
                                        </tr>
                                    </thead>
						
						 <tbody>
							<?php
                           
                             $qry = "select DISTINCT(p_order_detail.id), 
                             p_order_detail.*,product.name,product.image,porder.address,porder.city,porder.pincode from p_order_detail,product,porder where p_order_detail.order_id = '$order_id'  and p_order_detail.product_id = product.id";
                             
                            // echo $qry;
                             //die();
                             $res = mysqli_query($con,$qry);
                             $total_price =0;
                               while($row = mysqli_fetch_assoc($res))
                               {
                                $total_price = $total_price+($row['price']*$row['qty']);
                                $address = $row['address'];
                                $city = $row['city'];
                                $pincode = $row['pincode'];
                               
                             
                             
							?>
							<tr>
                            <td class="product-thumbnail"><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"  /></a></td>
                                        <td class="product-name"><a href="#"><?php echo $row['name']?></a>
                                        <td class="product-name"><a href="#"><?php echo $row['price']?></a>
                                        <td class="product-name"><a href="#"><?php echo $row['qty']?></a>
                                        <td class="product-name"><a href="#"><?php echo $row['price']*$row['qty']?></a>

                                        </tr>
										<?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>Total Price</td>
                                            <td><?php echo $total_price;?></td>
                                        </tr>
							
						 </tbody>
					  </table>
                      <strong>Address</strong>
                      <?php echo $address; ?><br>
                      <?php echo $city; ?> <br>
                      <?php echo $pincode; ?><br>

                      <strong>Order Status</strong>
           <?php 
           $order_status = mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,porder where porder.id='$order_id' and porder.order_status=order_status.id"));
           echo  $order_status['name'];
           ?>           
				   </div>
  <div>
  <form  method="post" action="update_status.php">
 <input type="hidden" name="order_id" value="<?php echo $order_id ;?>" />
  <select class="form-control" name="update_order_status" >
										<option>Select Status</option>
										<?php
										$res=mysqli_query($con,"select id,name from order_status order by name asc");
										while($row=mysqli_fetch_assoc($res)){
											if($row['id']==$categories_id){
												echo "<option selected value=".$row['id'].">".$row['name']."</option>";
											}else{
												echo "<option value=".$row['id'].">".$row['name']."</option>";
											}
											
										}
										?>
									</select>
                                    <br>
                <input type="submit" class="form-control" name="submit" value="submit"/>

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