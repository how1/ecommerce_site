<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>



<!-- Page Content -->
    <div class="container" style="margin-top: 70px">
<a id="message" href="" style="text-decoration: none; color: white"><h4 class="text-center bg-danger"><?php 
          
            display_message(); ?></h4></a>

<!-- /.row --> 
  <h1>Cart</h1>

<div class="row">
        
<div class="col-lg-8">
    <table class="table table-striped" style="margin: 10px">
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
                <?php view_cart();?>
            </tr>
        </tbody>
    </table>
</form>
</div>



<!--  ***********CART TOTALS*************-->
            
<div class="col-sm-4">
<h2>Cart Totals</h2>

<table class="table table-bordered" style="margin:10px" cellspacing="0">

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

<a href="checkout.php" class="btn btn-primary float-right">Checkout</a>

</div><!-- CART TOTALS-->

 </div><!--Main Content-->


           


<?php include(TEMPLATE_FRONT . DS . "footer.php");?>