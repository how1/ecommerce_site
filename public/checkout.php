<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>


<!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
        <h4 class="text-center bg-danger"><?php 
          
            display_message(); ?></h4>
      <h1>Checkout</h1>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="business" value="seller@henrywowen.com">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <tr>
                <?php cart();?>
            </tr>
        </tbody>
    </table>
<?php show_paypall();?>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php echo $_SESSION['num_items']; ?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">&#36;<?php echo $_SESSION['item_total']; ?></span></strong> </td>
</tr>




</tbody>

</table>


</div><!-- CART TOTALS-->


 </div><!--Main Content-->


           <hr>


<?php include(TEMPLATE_FRONT . DS . "footer.php");?>