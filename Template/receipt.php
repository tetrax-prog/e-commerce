<?php 
include "../header.php";

if(isset($_POST['finishOrder'])){
   $emptyCart = $Cart->emptyCart(1);
}
?>
<div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Shopping Cart</h5>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-9">
                <?php
                    if(!isset($_SESSION['invoice_no'])){
                        $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
                    }
                    // ?>
     <div class="py-4"> 
        <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
        <button type="button" onclick="downloadPDF('<?= $_SESSION['invoice_no']?>')" class="btn btn-warning saveCustomer">Download PDF</button>
    </div>
  <div id="myBillingArea">
        <table style="width:100%;">
                <tbody>
                    <tr>
                    <td style="text-align:center;" colspan='2'>
                        <h4 style="font-size:23px; line-height:30px; margin:2px; padding:0;">Tiles shop</h4>
                        <p  style="font-size:16px; line-height:24px; margin:2px; padding:0;">#555 Moi avenue</p>
                        <p  style="font-size:16px; line-height:24px; margin:2px; padding:0;">Shopping receipt</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:end;">
                        <h4 style="font-size:23px; line-height:30px; margin:0px; padding:0;">Invoice details</h4>
                        <p style="font-size:14px; line-height:20px; margin:0px; padding:0;">Invoice no:<?=$_SESSION['invoice_no']?></p>
                        <p style="font-size:14px; line-height:20px; margin:0px; padding:0;">Inovice date: <?= date('d M Y');?></p>
                        <p style="font-size:14px; line-height:20px; margin:0px; padding:0px;">Address 1st main road</p>
                    </td>
                </tr>
                    
                </tbody>
            </table>

            <div class="table-responsive">
        <table style="width:100%;" cellpadding="5" class="p-5">
            <thead>
                <th style="border-bottom: 1px solid #ccc;">Product name</th>
                <th style="border-bottom: 1px solid #ccc;">Price</th>>
                <!-- <th style="border-bottom: 1px solid #ccc;">Total price</th> -->
            </thead>
             <tbody>
                <?php
                 
                foreach ($product->getData('cart') as $item) :
                    $cart = $product->getProduct($item['item_id']);
                    $subTotal[] = array_map(function ($item){
                 ?>
                <tr>
                        <td style="border-bottom: 1px solid #ccc;" ><?=$item['item_name']?></td>
                        <td style="border-bottom: 1px solid #ccc;"><?=$item['item_price'] ?></td>
                        <td style="border-bottom: 1px solid #ccc;">
                    </td>
                </tr>
                <?php 
                      return $item['item_price'];
                    }, $cart); // closing array_map function
                endforeach;
                ?>
                <tr>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td><?php echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?></td>
                </tr>
                   
          </tbody>

       </table>
       <div class="py-4">
     <form method="post">
        <button type="submit" name="finishOrder" class='btn btn-lg btn-success m-b-10px'>
            <span class='glyphicon glyphicon-shopping-cart'></span>Finish Order
        </button>
     </form>
    </div>
            </div>
           
 </div>
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script>
    function printMyBillingArea(){
    var divContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open("","");
    a.document.write('<html><title>Order Records</title>');
    a.document.write('<body style="font-family:fangsong">');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print()
 }
 //function for downloading PDF in the id="myBillingArea" found in order-view-print.php
 window.jsPDF = window.jspdf.jsPDF;
 var docPDF = new jsPDF;
 function downloadPDF(invoiceNo){
    var elementHTML = document.querySelector("#myBillingArea");
    docPDF.html(elementHTML,{
        callback:function(){
            docPDF.save(invoiceNo+'.pdf')
        },
        x:15,
        y:15,
        width:170,
        windowWidth:650
    });
 }

    </script>

