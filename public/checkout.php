<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>



<!-- Page Content -->
    <div class="container" style="margin-top: 70px">
<a id="message" href="" style="text-decoration: none; color: white"><h4 class="text-center bg-danger"></h4></a>

<!-- /.row --> 
  <h1>Checkout</h1>
  <?php calculate_cart(); ?>
<?php 
  if (isset($_SESSION['username'])){
    show_user_info();
  } else {
?>
      <label for="exampleFormControlInput1">First Name</label>
      <input class="form-control"  type="text" required name="first_name" placeholder="John">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Last Name</label>
      <input class="form-control"  type="text" required name="last_name" placeholder="Doe">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Address 1</label>
      <input class="form-control"  type="text" required name="address1" placeholder="9 Elm Street">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Address 2</label>
      <input class="form-control"  type="text" required name="address2" placeholder="Apt 5">
  </div>

  <div class="form-group">
  <label for="exampleFormControlInput1">City</label>
      <input class="form-control"  type="text" required name="city" placeholder="Berwyn">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">State</label>
    <select class="form-control" required name="state">
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DE">Delaware</option>
    <option value="DC">District Of Columbia</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
    <option value="IA">Iowa</option>
    <option value="KS">Kansas</option>
    <option value="KY">Kentucky</option>
    <option value="LA">Louisiana</option>
    <option value="ME">Maine</option>
    <option value="MD">Maryland</option>
    <option value="MA">Massachusetts</option>
    <option value="MI">Michigan</option>
    <option value="MN">Minnesota</option>
    <option value="MS">Mississippi</option>
    <option value="MO">Missouri</option>
    <option value="MT">Montana</option>
    <option value="NE">Nebraska</option>
    <option value="NV">Nevada</option>
    <option value="NH">New Hampshire</option>
    <option value="NJ">New Jersey</option>
    <option value="NM">New Mexico</option>
    <option value="NY">New York</option>
    <option value="NC">North Carolina</option>
    <option value="ND">North Dakota</option>
    <option value="OH">Ohio</option>
    <option value="OK">Oklahoma</option>
    <option value="OR">Oregon</option>
    <option value="PA">Pennsylvania</option>
    <option value="RI">Rhode Island</option>
    <option value="SC">South Carolina</option>
    <option value="SD">South Dakota</option>
    <option value="TN">Tennessee</option>
    <option value="TX">Texas</option>
    <option value="UT">Utah</option>
    <option value="VT">Vermont</option>
    <option value="VA">Virginia</option>
    <option value="WA">Washington</option>
    <option value="WV">West Virginia</option>
    <option value="WI">Wisconsin</option>
    <option value="WY">Wyoming</option>
    </select>   
  </div>

  <div class="form-group">
  <label for="exampleFormControlInput1">Zip Code</label>
      <input class="form-control"  type="text" required name="zip" placeholder="12345">
  </div>

  <div class="form-group">
  <label for="exampleFormControlInput1">Phone Number</label>
      <input class="form-control"  type="text" required name="night_phone_a" placeholder="555 555 5555">

  </div>

      <input type="hidden" name="night_phone_b" value="555">
      <input type="hidden" name="night_phone_c" value="1234">
  <div class="form-group">
  <label for="exampleFormControlInput1">Email address</label>
      <input class="form-control" type="text" required name="email" placeholder="jdoe@example.com">

  </div> 
  <?php } ?>  
  <?php show_paypall(); ?>
  
</div>  
<div class="col-md-1"></div>        
<div class="col-sm-3">
    <table class="table table-striped" style="margin: 10px;">
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
</form>



<!--  ***********CART TOTALS*************-->
            
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


</div><!-- CART TOTALS-->
<div class="col-md-1"></div>        
</div>


 </div><!--Main Content-->
</div>

           


<?php include(TEMPLATE_FRONT . DS . "footer.php");?>