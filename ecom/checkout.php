<?php
include('top.php');

//prx(count($_SESSION['cart']));
if(isset($_SESSION['cart']) && count($_SESSION['cart'])==0)
{
	?>
	  <script>
	    window.location.href='index.php';
	  </script>
	<?php
}

$cart_total = 0;
if(isset($_POST['submit']))
{
	 $address = get_safe_value($con,$_POST['address']);
	 $city = get_safe_value($con,$_POST['city']);
	 $pincode = get_safe_value($con,$_POST['pincode']); 
	 $payment_type = get_safe_value($con,$_POST['payment_type']);
	 $user_id = $_SESSION['USER_ID'];
	 
	 foreach ($_SESSION['cart'] as $key => $val)
	 {
                 $productArr = get_product($con, '', '', $key);
                 $price = $productArr[0]['price'];
                 $qty = $val['qty'];
                 $cart_total = $cart_total + ($price * $qty);
	 }
	 $total_price = $cart_total;
	 
	 $payment_status = "pending";
	 if($payment_type =='cod')
	 {
		 $payment_status = 'pending';
	 }
	 $order_status = '1';
	 $added_on =  date('Y-m-d h:m:s');

     $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	 
	 mysqli_query($con,"insert into porder(user_id,address,city,pincode,
	 payment_type,total_price,payment_status,order_status,addes_on)values('$user_id',
	 '$address','$city','$pincode','$payment_type',$total_price,'$payment_status',
	 '$order_status','$added_on')");
	 
	 $order_id = mysqli_insert_id($con);
	 
	 
	 foreach ($_SESSION['cart'] as $key => $val)
	 {
           $productArr = get_product($con, '', '', $key);
           $price = $productArr[0]['price'];
		   $product_id = $productArr[0]['id'];
           $qty = $val['qty'];
           $cart_total = $cart_total + ($price * $qty);
		   
		   mysqli_query($con,"insert into p_order_detail(order_id,product_id,qty,price)values('$order_id','$product_id','$qty','$price')");
		   
	 }
    

	 //unset($_SESSION['cart']);

     if($payment_type=='payu'){
		$MERCHANT_KEY = "gtKFFx"; 
		$SALT = "eCwWELxi";
		$hash_string = '';
		//$PAYU_BASE_URL = "https://secure.payu.in";
		$PAYU_BASE_URL = "https://test.payu.in";
		$action = '';
		$posted = array();
		if(!empty($_POST)) {
		  foreach($_POST as $key => $value) {    
			$posted[$key] = $value; 
		  }
		}
		
		$userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$user_id'"));
		
		$formError = 0;
		$posted['txnid']=$txnid;
		$posted['amount']=$total_price;
		$posted['firstname']=$userArr['name'];
		$posted['email']=$userArr['email'];
		$posted['phone']=$userArr['mobile'];
		$posted['productinfo']="productinfo";
		$posted['key']=$MERCHANT_KEY ;
		$hash = '';

       // prx($_POST);
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($posted['hash']) && sizeof($posted) > 0) {
		  if(
				  empty($posted['key'])
				  || empty($posted['txnid'])
				  || empty($posted['amount'])
				  || empty($posted['firstname'])
				  || empty($posted['email'])
				  || empty($posted['phone'])
				  || empty($posted['productinfo'])
				 
		  ) {
			$formError = 1;
		  } else {    
			$hashVarsSeq = explode('|', $hashSequence);
			foreach($hashVarsSeq as $hash_var) {
			  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			  $hash_string .= '|';
			}
			$hash_string .= $SALT;
			$hash = strtolower(hash('sha512', $hash_string));
			$action = $PAYU_BASE_URL . '/_payment';
		  }
		} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		}

      // prx($action);
       
		$formHtml ='<form method="post" name="payuForm" 
        id="payuForm" action="'.$action.'">
        <input type="hidden" name="key" value="'.$MERCHANT_KEY.'" />
        <input type="hidden" name="hash" value="'.$hash.'"/>
        <input type="hidden" name="txnid" value="'.$posted['txnid'].'" />
        <input name="amount" type="hidden" value="'.$posted['amount'].'" />
        <input type="hidden" name="firstname" id="firstname" value="'.$posted['firstname'].'" />
        <input type="hidden" name="email" id="email" value="'.$posted['email'].'" />
        <input type="hidden" name="phone" value="'.$posted['phone'].'" />
        <textarea name="productinfo" style="display:none;">'.$posted['productinfo'].'</textarea>
        <input type="hidden" name="surl" value="'.SITE_PATH.'payment_complete.php" />
        <input type="hidden" name="furl" value="'.SITE_PATH.'payment_fail.php"/>
        <input type="submit" style="display:none;"/></form>';
		echo $formHtml;

       // echo "okk";
        //die();
		echo '<script>document.getElementById("payuForm").submit();</script>';
	}else{	

		?>
		<script>
			window.location.href='thank_you.php';
		</script>
		<?php
	}	

  
}

?>

<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">checkout</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<!-- cart-main-area start -->


<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout__inner">
                    <div class="accordion-list">
                        <div class="accordion">
                            <?php
                            $accordion_class = 'accordion__title';
                            if (!isset($_SESSION['USER_LOGIN'])) {
                                $accordion_class = '.accordion__hide';
                            ?>
                                <div class="accordion__title">
                                    Checkout Method
                                </div>
                                <div class="accordion__body">
                                    <div class="accordion__body__form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkout-method__login">

                                                    <form action="#">
                                                        <h5 class="checkout-method__title">Login</h5>
                                                        <div class="single-input">
                                                            <label for="user-email">Email Address</label>
                                                            <input type="text" name="login_email" id="login_email" placeholder="Your Email*">
                                                        </div>
                                                        <span class="field_error" id="login_email_error"></span>
                                                        <div class="single-input">
                                                            <label for="user-pass">Password</label>
                                                            <input type="password" name="login_password" id="login_password" placeholder="Your Password*">
                                                        </div>
                                                        <span class="field_error" id="login_password_error"></span>

                                                        <div class="dark-btn">
                                                            <button type="button" class="fv-btn" onclick="user_login()">Login</button>
                                                        </div>
                                                    </form>

                                                    <div class="form-output login_msg">
                                                        <p class="form-messege field_error"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-method__login">
                                                    <form action="#">
                                                        <h5 class="checkout-method__title">Register</h5>
                                                        <div class="single-input">
                                                            <label for="user-email">Name</label>
                                                            <input type="email" id="user-email">
                                                        </div>
                                                        <div class="single-input">
                                                            <label for="user-email">Email Address</label>
                                                            <input type="email" id="user-email">
                                                        </div>

                                                        <div class="single-input">
                                                            <label for="user-pass">Password</label>
                                                            <input type="password" id="user-pass">
                                                        </div>
                                                        <div class="dark-btn">
                                                            <a href="#">Register</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>



                            <div class="<?php echo $accordion_class ?>">
                                Address Information
                            </div>
							<form method="post">
                            <div class="accordion__body">
                                <div class="bilinfo">
                                   
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" name="address" placeholder="Street Address">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" name="city" placeholder="City/State">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" name="pincode" placeholder="Post code/ zip">
                                                </div>
                                            </div>


                                        </div>
                                   
                                </div>
                            </div>
                            <div class="<?php echo $accordion_class ?>">
                                payment information
                            </div>
                            <div class="accordion__body">
                                <div class="paymentinfo">
                                    <div class="single-method">
                                        <input type="radio" value="payu" name="payment_type"> <i class="zmdi zmdi-long-arrow-right"></i>PayU
                                        <input type="radio" value="cod" name="payment_type"> <i class="zmdi zmdi-long-arrow-right"></i>COD
                                    </div>

                                </div>
                            </div>
                        </div>
						<input type="submit" name="submit" value="submit"/>
						</form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="order-details">
                    <h5 class="order-details__title">Your Order</h5>
                    <div class="order-details__item">

                        <?php
                        $cart_total = 0;
                        foreach ($_SESSION['cart'] as $key => $val) {
                            $productArr = get_product($con, '', '', $key);
                            $pname = $productArr[0]['name'];
                            $mrp = $productArr[0]['mrp'];
                            $price = $productArr[0]['price'];
                            $image = $productArr[0]['image'];
                            $qty = $val['qty'];
                            $cart_total = $cart_total + ($price * $qty);
                        ?>

                            <div class="single-item">
                                <div class="single-item__thumb">
                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>" alt="ordered item">
                                </div>
                                <div class="single-item__content">
                                    <a href="#"><?php echo $pname; ?></a>
                                    <span class="price"> $ <?php echo $price; ?></span>
                                </div>
                                <div class="single-item__remove">
                                    <a href="#" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="zmdi zmdi-delete"></i></a>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                    <div class="order-details__count">
                        <!-- <div class="order-details__count__single">
                                    <h5>sub total</h5>
                                    <span class="price">$909.00</span>
                                </div> -->
                        <!-- <div class="order-details__count__single">
                                    <h5>Tax</h5>
                                    <span class="price">$9.00</span>
                                </div> -->
                    </div>
                    <div class="ordre-details__total">
                        <h5>Order total</h5>
                        <span class="price">$<?php echo $cart_total; ?>.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>