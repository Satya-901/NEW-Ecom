<?php 
require('top.php');

$order_id = get_safe_value($con,$_GET['id']);

?>

 <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
        	$uid = $_SESSION['USER_ID'];
            $qry = "select DISTINCT(p_order_detail.id), p_order_detail.*,product.name,product.image from p_order_detail,product,porder where p_order_detail.order_id = '$order_id' and porder.user_id ='$uid' and p_order_detail.product_id = product.id";
            
           // echo $qry;
           // die();
            $res = mysqli_query($con,$qry);
            $total_price =0;
              while($row = mysqli_fetch_assoc($res))
              {
               $total_price = $total_price+($row['price']*$row['qty']);
              
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
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                       
                                    
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        
										
<?php require('footer.php')?>        