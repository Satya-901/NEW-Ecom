<?php
include('top.php');
?>





<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Wishlist</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- wishlist-area start -->
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="nobr">Order ID</span></th>
                                               <th class="product-thumbnail">OrderDate</th>
                                              <th class="product-name"><span class="nobr">Address</span></th>
                                            <th class="product-price"><span class="nobr"> Payment Type</span></th>
                                      <th class="product-stock-stauts"><span class="nobr"> Payment Status </span></th>
                                    <th class="product-add-to-cart"><span class="nobr">Order Status</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										  
												$uid = $_SESSION['USER_ID'];
												//echo $uid;
												//die();
	$a = "select  porder.*,order_status.name as order_status_name  from
    porder, order_status where porder.user_id = '$uid' and porder.order_status = order_status.id ";
                                                // echo $a;
                                                // die();
										  
										   $res = mysqli_query($con,$a);
												//$res = mysqli_query($con,"select * from porder where user_id = '$uid'");
												
												while($row = mysqli_fetch_assoc($res))
												{
													 $id = $row['id'];
													  $date   = $row['addes_on'];
													  $address = $row['address'];
                                            $order_status_name = $row['order_status_name'];

												
												?>
                                            <tr>
											    
	<td class="product-add-to-cart"><a href="my_order_details.php?id=<?php echo $row['id']; ?>"> <?php echo $row['id']; ?> </a></td>
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
												<?php
												}
												?>
										 
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Share on:</h4>
                                                        <div class="social-icon">
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>






<?php
include('footer.php');
?>