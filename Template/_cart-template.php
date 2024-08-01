<!-- Shopping cart section  -->
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['delete-cart-submit'])){
            $deletedrecord = $Cart->deleteCart($_POST['item_id']);
        }
        //this commented code is for a  save for later function but it didn't work so I'll work on it later
        // if (isset($_POST['wishlist-submit'])){
        //     $Cart->saveForLater($_POST['item_id']);
        // }
        }
        //code for getting details from modal
        if(isset($_POST['pay_items'])){
            $payment_phone = $_POST['phone'];
            $amount = $_POST['amount'];
            $firstDigits = substr($payment_phone,0,3);
            if($firstDigits == '254'){
                $payment_phone = $payment_phone;
            }else{
                $payment_phone = '254'.(int)$payment_phone;
            }
            //stk push code
            include 'accessToken.php';
            date_default_timezone_set('Africa/Nairobi');
            $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $callbackurl = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/callback.php';
            $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
            $BusinessShortCode = '174379';
            $Timestamp = date('YmdHis');
            // ENCRIPT  DATA TO GET PASSWORD
            $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
            $phone = $payment_phone;//phone number to receive the stk push
            $money = (int) round($amount);
            $PartyA = $phone;
            $PartyB = '254796028800';
            $AccountReference = 'account';
            $TransactionDesc = 'stkpush test';
            $Amount = $money;
            $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];
            //INITIATE CURL
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
            $curl_post_data = array(
              //Fill in the request parameters with valid values
              'BusinessShortCode' => $BusinessShortCode,
              'Password' => $Password,
              'Timestamp' => $Timestamp,
              'TransactionType' => 'CustomerPayBillOnline',
              'Amount' => $Amount,
              'PartyA' => $PartyA,
              'PartyB' => $BusinessShortCode,
              'PhoneNumber' => $PartyA,
              'CallBackURL' => $callbackurl,
              'AccountReference' => $AccountReference,
              'TransactionDesc' => $TransactionDesc
            );
            
            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            echo $curl_response = curl_exec($curl);
            //ECHO  RESPONSE
            $data = json_decode($curl_response);
            $CheckoutRequestID = $data->CheckoutRequestID;
            $ResponseCode = $data->ResponseCode;
            if ($ResponseCode == "0") {
              echo '<script>window.location.href="Template/receipt.php"</script>';
              echo "The CheckoutRequestID for this transaction is : " . $CheckoutRequestID;
            }else{
                echo '<script>alert("something went wrong")</script>';
            }
        }
?>

<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Shopping Cart</h5>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-9">
                <?php
                    foreach ($product->getData('cart') as $item) :
                        $cart = $product->getProduct($item['item_id']);
                        $subTotal[] = array_map(function ($item){
                ?>
                <!-- cart item -->
                <div class="row border-top py-3 mt-3">
                    <div class="col-sm-2">
                        <img src="<?php echo $item['item_image'] ?? "./assets/products/1.png" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                    </div>
                    <div class="col-sm-8">
                        <h5 class="font-baloo font-size-20"><?php echo $item['item_name'] ?? "Unknown"; ?></h5>
                        <small>by <?php echo $item['item_brand'] ?? "Brand"; ?></small>
                        <!-- product rating -->
                        <div class="d-flex">
                            <div class="rating text-warning font-size-12">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="far fa-star"></i></span>
                            </div>
                            <a href="#" class="px-2 font-rale font-size-14">20,534 ratings</a>
                        </div>
                        <!--  !product rating-->

                        <!-- product qty -->
                        <div class="qty d-flex pt-2">
                            <div class="d-flex font-rale w-25">
                                <button class="qty-up border bg-light" data-id="<?php echo $item['item_id'] ?? '0'; ?>"><i class="fas fa-angle-up"></i></button>
                                <input type="text" data-id="<?php echo $item['item_id'] ?? '0'; ?>" class="qty_input border px-2 w-100 bg-light" disabled value="1" placeholder="1">
                                <button data-id="<?php echo $item['item_id'] ?? '0'; ?>" class="qty-down border bg-light"><i class="fas fa-angle-down"></i></button>
                            </div>

                            <form method="post">
                                <input type="hidden" value="<?php echo $item['item_id'] ?? 0; ?>" name="item_id">
                                <button type="submit" name="delete-cart-submit" class="btn font-baloo text-danger px-3 border-right">Delete</button>
                            </form>

                            <!-- <form method="post">
                                <input type="hidden" value="<?php echo $item['item_id'] ?? 0; ?>" name="item_id">
                                <button type="submit" name="wishlist-submit" class="btn font-baloo text-danger">Save for Later</button>
                            </form> -->


                        </div>
                        <!-- !product qty -->

                    </div>

                    <div class="col-sm-2 text-right">
                        <div class="font-size-20 text-danger font-baloo">
                            $<span class="product_price" data-id="<?php echo $item['item_id'] ?? '0'; ?>"><?php echo $item['item_price'] ?? 0; ?></span>
                        </div>
                    </div>
                </div>
                <!-- !cart item -->
                <?php
                            return $item['item_price'];
                        }, $cart); // closing array_map function
                    endforeach;
                ?>
            </div>
            <!-- subtotal section-->
            <div class="col-sm-3">
                <div class="sub-total border text-center mt-2">
                    <!-- <h6 class="font-size-12 font-rale text-success py-3"><i class="fas fa-check"></i> Your order is eligible for FREE Delivery.</h6> -->
                    <div class="border-top py-4">
                        <h5 class="font-baloo font-size-20">Subtotal ( <?php echo isset($subTotal) ? count($subTotal) : 0; ?> item):&nbsp; <span class="text-danger">ksh<span class="text-danger" id="deal-price"><?php echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?></span> </span> </h5>
                        <button type="submit" class="btn btn-warning mt-3" data-toggle='modal' data-target='#exampleModal'>Proceed to Buy</button>
                    </div>
                </div>
            </div>
            <!-- !subtotal section-->
        </div>
        <!--  !shopping cart items   -->
    </div>

    <!-- Modal to be triggered when payment button is clicked -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">M-pesa payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <form id="dataForm" method="POST">
        <label for="phone">Phone:(format is 254)</label>
        <input type="text" value="2547" id="phone" name="phone" required><br><br>
        <label for="phone">Amount</label>
        <input type="number" value="<?php echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?>" id="amount" name="amount" required><br><br>
    
        <!-- <button type="submit">Submit</button> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="pay_items" class="btn btn-primary">Submit</button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>

</section>
<!-- !Shopping cart section  -->