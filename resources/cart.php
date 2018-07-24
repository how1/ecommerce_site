<?php require_once("config.php"); ?>

<?php


if (isset($_GET['add'])){
    
    $query = query("SELECT * FROM products WHERE product_id=" . escape($_GET['add']) . " ");  
    confirm($query);

    while($row = fetch_array($query)){
        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
            $_SESSION['product_' . $_GET['add']]+=1;
            redirect("../public/view_cart.php");
        } else {
            set_message("We only have " . $row['product_quantity'] . " available");
            redirect("../public/view_cart.php");
        }
    }
    
}

if (isset($_GET['remove'])){
    $_SESSION['product_' . $_GET['remove']]--;
    if ($_SESSION['product_' .  $_GET['remove']] < 1){
        set_message("product removed");
        redirect("../public/view_cart.php");
    } else {
        redirect("../public/view_cart.php");
    }
}

if (isset($_GET['delete'])){
    $_SESSION['product_' . $_GET['delete']] = '0';
    set_message("Product Deleted");
    $_SESSION['item_total'] = 0;
    unset($_SESSION['num_items']);
    redirect("../public/view_cart.php");
}
function view_cart(){
    $total = 0;
    $item_quantity = 1;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $item_total = 0;
    $_SESSION['num_items'] = 0;
    $_SESSION['item_total'] = 0;
    foreach($_SESSION as $name => $value){
        if(substr($name, 0,8) == "product_"){
            $_SESSION['num_items']+= $value;
            if ($value > 0){
                $query = query("SELECT * FROM products WHERE product_id=" . substr($name, 8, strlen($name) - 8) . " ");
                confirm($query);
                while($row = fetch_array($query)) {
                    $subtotal = $value * $row['product_price'];
                    if (!$row['product_image']){
                        $product_image = "http://placehold.it/320x150";
                    } else {
                        $product_image = "../resources/images/" . $row['product_image'];
                    }
                    $product = <<<DELIMITER
                <tr>
                <td>{$row['product_title']}<br><a href="item.php?id={$row['product_id']}"><img style="height:50px" src="$product_image" alt=""></a></td>
                <td>&#36;{$row['product_price']}</td>
                <td>{$value}</td>
                <td>$subtotal</td>
                <td>
                <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="fas fa-plus"></span></a>
                <a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="fas fa-minus"></span></a>
                <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="fas fa-times"></span></a>
                </td>
                </tr>
DELIMITER;
                echo $product;
                $_SESSION['item_total'] = $total += $subtotal;
                $item_name++;
                $item_number++;
                $amount++;
                $item_quantity++;
                }
            }
        }
    }
}

function calculate_cart(){
    $form = <<<DELIMITER

 <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

<div class="row">
<div class="col-md-7">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="seller@henrywowen.com">
  <div class="form-group">

DELIMITER;
    echo $form;

    $total = 0;
    $item_quantity = 1;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $item_total = 0;
    $_SESSION['num_items'] = 0;
    $_SESSION['item_total'] = 0;
    foreach($_SESSION as $name => $value){
        if(substr($name, 0,8) == "product_"){
            $_SESSION['num_items']+= $value;
            if ($value > 0){
                $query = query("SELECT * FROM products WHERE product_id=" . substr($name, 8, strlen($name) - 8) . " ");
                confirm($query);
                while($row = fetch_array($query)) {
                    $subtotal = $value * $row['product_price'];
                    if (!$row['product_image']){
                        $product_image = "http://placehold.it/320x150";
                    } else {
                        $product_image = "../resources/images/" . $row['product_image'];
                    }
                    $form = <<<DELIMITER
                  <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                  <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                  <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                  <input type="hidden" name="quantity_{$item_quantity}" value="{$value}">
DELIMITER;
                echo $form;
                    $_SESSION['item_total'] = $total += $subtotal;
                    $item_name++;
                    $item_number++;
                    $amount++;
                    $item_quantity++;
                    
                }
                
            }
        }
    }
}


function cart(){
    $total = 0;
    $item_quantity = 1;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $item_total = 0;
    foreach($_SESSION as $name => $value){
        if(substr($name, 0,8) == "product_"){
            if ($value > 0){
                $query = query("SELECT * FROM products WHERE product_id=" . substr($name, 8, strlen($name) - 8) . " ");
                confirm($query);
                while($row = fetch_array($query)) {
                    $subtotal = $value * $row['product_price'];
                    if (!$row['product_image']){
                        $product_image = "http://placehold.it/320x150";
                    } else {
                        $product_image = "../resources/images/" . $row['product_image'];
                    }
                    $product = <<<DELIMITER
                <tr>
                <td>{$row['product_title']}</td>
                <td>&#36;{$row['product_price']}</td>
                <td>{$value}</td>
                <td>$subtotal</td>
                </tr>


DELIMITER;
                echo $product;
                }
            }
        }
    }
}

function show_paypall(){
    if ($_SESSION['item_total'] > 0){
    $paypal_button = <<<DELIMITER
    <input type="image" style="float:right" name="upload" 
src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png"
alt="PayPal - The safer, easier way to pay online">
DELIMITER;
    echo $paypal_button;
    } 
}

function last_id(){
    global $connection;
    return mysqli_insert_id($connection);
}

function process_transaction(){
    if (isset($_GET['tx'])){
        $tx = $_GET['tx'];
        $amt = $_GET['amt'];
        $currency = $_GET['cc'];
        $status = $_GET['st'];
        if($status != "Completed"){
            set_message("Transaction not completed");
            redirect("view_cart.php");
        }
        echo "<h1 class='text-center' style='margin-top:70px'>Thank you for shopping with us.</h1>";
        $total = 0;
        $item_quantity = 1;
        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        $_SESSION['num_items'] = 0;
        foreach($_SESSION as $name => $value){
            if(substr($name, 0,8) == "product_"){
                $_SESSION['num_items']+= $value;
                if ($value > 0){
                    $p_id = substr($name, 8, strlen($name) - 8);

                    $send_order = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) VALUES ('{$amt}', '{$tx}','{$status}','{$currency}')");
                    $last_id = last_id();
                    confirm($send_order);

                    $query = query("SELECT * FROM products WHERE product_id=" . $p_id . " ");
                    confirm($query);
                    $row = fetch_array($query);
                    $p_price = $row['product_price'];
                    $p_title = $row['product_title'];
                    $query = query("INSERT INTO reports (product_id, product_title, order_id, product_price, product_quantity) VALUES ('{$p_id}','{$p_title}', '{$last_id}', '{$p_price}', '{$value}') ");
                }
            }
        }
        session_destroy();
    } else {
        redirect("index.php");
    }
}

function show_user_info(){

    $query = query("SELECT * FROM users WHERE username='{$_SESSION['username']}' ");
    confirm($query);
    $row = fetch_array($query);
    $firstname = escape($row['user_firstname']);
    $lastname = escape($row['user_lastname']);
    $addr1 = escape($row['user_addr1']);
    $addr2 = escape($row['user_addr2']);
    $user_city = escape($row['user_city']);
    $user_state = escape($row['user_state']);
    $user_zipcode = escape($row['user_zipcode']);
    $user_phone = escape($row['user_phone_number']);
    $user_email = escape($row['user_email']);

    $user_info = <<<DELIMITER
        <label for="exampleFormControlInput1">First Name</label>
      <input class="form-control"  type="text" required name="first_name" value="{$firstname}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Last Name</label>
      <input class="form-control"  type="text" required name="last_name" value="{$lastname}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Address 1</label>
      <input class="form-control"  type="text" required name="address1" value="$addr1">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">Address 2</label>
      <input class="form-control"  type="text" required name="address2" value="{$addr2}">
  </div>

  <div class="form-group">
  <label for="exampleFormControlInput1">City</label>
      <input class="form-control"  type="text" required name="city" value="{$user_city}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">State</label>
    <select class="form-control" required name="state">
    <option selected value="{$user_state}">{$user_state}</option>
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
      <input class="form-control"  type="text" required name="zip" value="{$user_zipcode}">
  </div>

  <div class="form-group">
  <label for="exampleFormControlInput1">Phone Number</label>
      <input class="form-control"  type="text" required name="night_phone_a" value="$user_phone">

  </div>

      <input type="hidden" name="night_phone_b" value="555">
      <input type="hidden" name="night_phone_c" value="1234">
  <div class="form-group">
  <label for="exampleFormControlInput1">Email address</label>
      <input class="form-control" type="text" required name="email" value="{$user_email}">

  </div>   

DELIMITER;
  echo $user_info;
}


?>