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
    set_message("product deleted");
    $_SESSION['item_total'] = 0;
    unset($_SESSION['num_items']);
    redirect("../public/view_cart.php");
}

function cart(){
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
                <td><a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="glyphicon glyphicon-minus"></span></a>
                <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
                <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
                </tr>


                

                <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                <input type="hidden" name="quantity_{$item_quantity}" value="{$value}">
                <input type="hidden" name="first_name" value="John">
                <input type="hidden" name="last_name" value="Doe">
                <input type="hidden" name="address1" value="9 Elm Street">
                <input type="hidden" name="address2" value="Apt 5">
                <input type="hidden" name="city" value="Berwyn">
                <input type="hidden" name="state" value="PA">
                <input type="hidden" name="zip" value="19312">
                <input type="hidden" name="night_phone_a" value="610">
                <input type="hidden" name="night_phone_b" value="555">
                <input type="hidden" name="night_phone_c" value="1234">
                <input type="hidden" name="email" value="jdoe@zyzzyu.com">
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

function show_paypall(){
    if ($_SESSION['item_total'] > 0){
    $paypal_button = <<<DELIMITER
    <input type="image" style="float:right" name="upload" 
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
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
        echo "<h1 class='text-center''>Thank you for shopping with us.</h1>";
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


?>