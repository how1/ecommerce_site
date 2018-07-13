<?php

function set_message($msg){
    if (!empty($msg)){
        $_SESSION['message'] = $msg;
    } else {
        $msg = '';
        
    }
}

function display_message(){
    if (isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location){
    header("Location: $location");
}

function query($query){
    global $connection;
    return mysqli_query($connection, $query);
}

function confirm($query){
    global $connection;
    if (!$query){
        echo mysqli_error($connection);
    }
}

function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
    
}

function fetch_array($result){
    return mysqli_fetch_assoc($result);
}


//FRONT END FUNCTIONS


function get_products(){
    global $connection;
    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)){
        if (!$row['product_image']){
            $image_path = "http://placehold.it/320x150";
        } else {
            $image_path = "../resources/images/{$row['product_image']}";
        }
        $product = <<<DELIMITER
        
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id={$row['product_id']}"><img style="height:150px" src="$image_path" alt="product image"></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                    </h4>
                    <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                </div>

            </div>
        </div>
        
DELIMITER;
        
        echo $product;
    }
}


function get_categories(){
    $query = query("SELECT * FROM categories ");
    confirm($query);
    while ($row = fetch_array($query)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $category = <<<DELIMITER
<a href='category.php?id=$cat_id' class='list-group-item'>$cat_title</a>
DELIMITER;
    echo $category;
    }
}


function get_cat_page_products(){
    $query = query("SELECT * FROM products WHERE product_category_id = " . escape($_GET['id']) . " ");
    confirm($query);
    if (mysqli_num_rows($query) == 0){
        echo "<h1>No products currently in stock</h1>";
    } else {
        while($row = fetch_array($query)){
            if (!$row['product_image']){
                $image_path = "http://placehold.it/320x150";
            } else {
                $image_path = "../resources/images/{$row['product_image']}";
            }
            $cat_product = <<<DELIMITER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img style="height:150px" src="{$image_path}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Add to Cart</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMITER;
            echo $cat_product;
        }
    }
}


function get_shop_page_products(){
    $query = query("SELECT * FROM products");
    confirm($query);
    if (mysqli_num_rows($query) == 0){
        echo "<h1>No products currently in stock</h1>";
    } else {
        while($row = fetch_array($query)){
            if (!$row['product_image']){
                $image_path = "http://placehold.it/320x150";
            } else {
                $image_path = "../resources/images/{$row['product_image']}";
            }
            $cat_product = <<<DELIMITER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail"><a href="item.php?id={$row['product_id']}">
                    <img style="height:150px" src="{$image_path}" alt=""></a>
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Add to Cart</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMITER;
            echo $cat_product;
        }
    }
}

function login_user(){
    if (isset($_POST['submit'])){
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);
        if (mysqli_num_rows($query) == 0){
            set_message('Your Username and/or Password is wrong');
            redirect('login.php');
        } else {
            $_SESSION['username'] = $username;
            set_message('
            Welcome to Admin');
            redirect('admin');
        }
    }
    
}

function send_message(){
    if (isset($_POST['submit'])){
        $to = "hnryown@gmail.com";
        $from_name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        $headers = "From: {$from_name}";
        $result = mail($to, $subject, $message, $headers);
        if (!$result){
            set_message("Error");
        } else set_message("Sent");
        redirect("contact.php");
    }
}

//BACKEND FUNCTIONS
function display_orders(){
    $query = query("SELECT * FROM orders");
    confirm($query);
    while($row = fetch_array($query)){
        $order = <<<DELIMITER

        <tr>
            <td>{$row['order_id']}</td>
            <td>&#36;{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>

DELIMITER;
        echo $order;
    }
}

// Admin Products

function get_products_in_admin(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)){
        if (!$row['product_image']){
            $product_image = "http://placehold.it/320x150";
        } else {
            $product_image = "../../resources/images/" . $row['product_image'];
        }
        $product_category = show_product_category($row['product_category_id']);
        $product = <<<DELIMITER
        
          <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br><a href="index.php?edit_product&id={$row['product_id']}">
            <img style="height:100px" src="{$product_image}"></a></td>
            <td>{$product_category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
        
DELIMITER;
        
        echo $product;
    }
}


// add products in admin
function add_product(){
    if (isset($_POST['publish'])){
        $p_title = escape($_POST['product_title']);
        $p_cat_id = escape($_POST['product_category_id']);
        $p_desc = escape($_POST['product_description']);
        $p_short_desc = escape($_POST['product_short_desc']);
        $p_quantity = escape($_POST['product_quantity']);
        $p_price = escape($_POST['product_price']);
        $p_image = escape($_FILES['file']['name']);
        $image_temp_location = $_FILES['file']['tmp_name'];
        $p_tags = escape($_POST['product_tags']);
        $p_brand = escape($_POST['product_brand']);

        move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $p_image);


    $query = query("INSERT INTO products (product_title, product_price, product_category_id, product_description, short_desc, product_quantity, product_image, product_tags, product_brand) VALUES ('{$p_title}','$p_price','$p_cat_id','{$p_desc}','{$p_short_desc}','{$p_quantity}','{$p_image}','{$p_tags}','{$p_brand}')");
    confirm($query);
     set_message("New product \"{$p_title}\" added");
     redirect("index.php?products");
    }

}

// add products in admin
function edit_product(){

    if (isset($_POST['publish'])){
        $p_title = escape($_POST['product_title']);
        $p_cat_id = escape($_POST['product_category_id']);
        $p_desc = escape($_POST['product_description']);
        $p_short_desc = escape($_POST['product_short_desc']);
        $p_quantity = escape($_POST['product_quantity']);
        $p_price = escape($_POST['product_price']);
        $p_image = escape($_FILES['file']['name']);
        $image_temp_location = $_FILES['file']['tmp_name'];
        $p_tags = escape($_POST['product_tags']);
        $p_brand = escape($_POST['product_brand']);

        move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $p_image);


    $query = query("INSERT INTO products (product_title, product_price, product_category_id, product_description, short_desc, product_quantity, product_image, product_tags, product_brand) VALUES ('{$p_title}','$p_price','$p_cat_id','{$p_desc}','{$p_short_desc}','{$p_quantity}','{$p_image}','{$p_tags}','{$p_brand}')");
    confirm($query);
     set_message("New product \"{$p_title}\" added");
     redirect("index.php?products");
    }

}

function show_product_category($cat_id){
    $query = query("SELECT cat_title FROM categories WHERE cat_id=" . $cat_id);
    confirm($query);
    $row = fetch_array($query);
    return $row['cat_title'];
}

function show_admin_categories(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $category = <<<DELIMITER

        <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$cat_id}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMITER;
        echo $category;
    }
}


function add_category(){
    if (isset($_POST['submit'])){
        $cat_title = escape($_POST['cat_title']);

        $query = query("INSERT INTO categories (cat_title) VALUES ('{$cat_title}')");
    }
}





?>