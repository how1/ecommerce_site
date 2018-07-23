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
        echo "Query failed: " . mysqli_error($connection);
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
        <div class="col-xs-4 col-md-4 col-sm-4" style="margin-bottom: 15px">
            <div class="card" style="height:375px">
                    <a href="item.php?id={$row['product_id']}"><img class="card-img-top" style="height: 10rem;" src="$image_path" alt="product image"></a>
                    <div class="caption" style="margin:10px">
                        <h4 class="float-right">&#36;{$row['product_price']}</h4>
                        <h4><a style="text-decoration:none; color:black" href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
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
<a href='category.php?id=$cat_id' class='list-group-item-action'>$cat_title</a>
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
            <div class="col-xs-4 col-md-4 col-sm-4" style="margin-bottom: 15px">
            <div class="card" style="height:375px">
                    <a href="item.php?id={$row['product_id']}"><img class="card-img-top" style="height: 10rem;" src="$image_path" alt="product image"></a>
                    <div class="caption" style="margin:10px">
                        <h4 class="float-right">&#36;{$row['product_price']}</h4>
                        <h4><a style="text-decoration:none; color:black" href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                     <a href="#" class="btn btn-primary">More Info</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default"></a>
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
            <div class="col-xs-4 col-md-4 col-sm-4" style="margin-bottom: 15px">
            <div class="card" style="height:375px">
                    <a href="item.php?id={$row['product_id']}"><img class="card-img-top" style="height: 10rem;" src="$image_path" alt="product image"></a>
                    <div class="caption" style="margin:10px">
                        <h4 class="float-right">&#36;{$row['product_price']}</h4>
                        <h4><a style="text-decoration:none; color:black" href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                     <a class="btn btn-primary" href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
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
        $row = fetch_array($query);
        if (mysqli_num_rows($query) == 0){
            set_message("<h4 class='text-center bg-warning'>Your Username and/or Password is wrong</h4>");
            // redirect("index.php");
        } else {
            if (isset($_POST['remember_me'])){
                $expiration = time() + (60*60*24*7);
                setcookie("remember_me",'remember',$expiration);
                $expiration = time() + (60*60*24*7);
                setcookie("auto-login",'login',$expiration);
                $expiration = time() + (60*60*24*7);
                setcookie("username",$username,$expiration);
                $expiration = time() + (60*60*24*7);
                setcookie("password",$password,$expiration);
            }
            if ($row['user_role'] == 'Admin') {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                set_message('Welcome to Admin');
                redirect('admin');
            }
            else {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                set_message("<h4 class='text-center bg-success'>Welcome $username</h4>");
                // redirect($_SERVER['REQUEST_URI']);
            }
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
        $product_brand = show_product_brand($row['product_category_id']);
        if ($row['product_featured'] == 'featured'){
            $featured = "<p><span class='glyphicon glyphicon-ok'></span></p>";
        } else {
            $featured = "";
        }
        $product = <<<DELIMITER
        
          <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br><a href="index.php?edit_product&id={$row['product_id']}">
            <img style="height:100px" src="{$product_image}"></a></td>
            <td>{$product_category}</td>
            <td>{$product_brand}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td>{$featured}</td>
            <td><a onClick="javascript: return confirm('Are you sure you want to delete product: {$row['product_title']}?');" class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
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
        $p_featured = escape($_POST['product_featured']);
        if (empty($_POST['product_featured'])){
            $p_featured = 'notfeatured';
        }
        $p_image = escape($_FILES['file']['name']);
        $image_temp_location = $_FILES['file']['tmp_name'];
        $p_tags = escape($_POST['product_tags']);
        $p_brand = escape($_POST['product_brand_id']);

        move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $p_image);


        $query = query("INSERT INTO products 
            (product_title, 
            product_price, 
            product_category_id, 
            product_description, 
            short_desc, 
            product_quantity, 
            product_image, 
            product_tags, 
            product_brand_id
            product_featured) 
            VALUES (
            '{$p_title}',
            '$p_price',
            '$p_cat_id',
            '{$p_desc}',
            '{$p_short_desc}',
            '{$p_quantity}',
            '{$p_image}',
            '{$p_tags}',
            '{$p_brand}',
            '{$p_featured}')");
        confirm($query);
        set_message("New product \"{$p_title}\" added");
        redirect("index.php?products");
    }

}

// edit products in admin
function edit_product($product_image){

    if (isset($_POST['publish']) && isset($_GET['id'])){
        $p_title = escape($_POST['product_title']);
        $p_cat_id = escape($_POST['product_category_id']);
        $p_desc = escape($_POST['product_description']);
        $p_short_desc = escape($_POST['product_short_desc']);
        $p_quantity = escape($_POST['product_quantity']);
        $p_price = escape($_POST['product_price']);
        $p_featured = escape($_POST['product_featured']);
        if (empty($_POST['product_featured'])){
            $p_featured = 'notfeatured';
        }
        if ($_FILES['file']['name'] == ""){
            $p_image = $product_image;
        } else { 
            $p_image = $_FILES['file']['name'];
        }
        $image_temp_location = $_FILES['file']['tmp_name'];
        $p_tags = escape($_POST['product_tags']);
        $p_brand = escape($_POST['product_brand_id']);
       
        move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $p_image);
        $query = query("
            UPDATE products SET 
            product_title ='{$p_title}', 
            product_price = '{$p_price}', 
            product_category_id = '{$p_cat_id}', 
            product_description = '{$p_desc}', 
            short_desc = '{$p_short_desc}', 
            product_quantity = '{$p_quantity}', 
            product_image = '{$p_image}', 
            product_tags = '{$p_tags}', 
            product_brand_id = '{$p_brand}',
            product_featured = '{$p_featured}' 
            WHERE product_id = {$_GET['id']}");
        confirm($query);
        set_message("Product \"{$p_title}\" edited");
        redirect("index.php?products");
    }

}

function show_product_category($cat_id){
    $query = query("SELECT cat_title FROM categories WHERE cat_id=" . $cat_id);
    confirm($query);
    $row = fetch_array($query);
    return $row['cat_title'];
}
function show_product_brand($id){
    $query = query("SELECT brand_title FROM brands WHERE brand_id=" . $id);
    confirm($query);
    $row = fetch_array($query);
    return $row['brand_title'];
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
            <td><a onClick="javascript: return confirm('Are you sure you want to delete?');" class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$cat_id}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMITER;
        echo $category;
    }
}


function get_cat_name($cat_id){
    $query = query("SELECT cat_title FROM categories WHERE cat_id={$cat_id}");
    confirm($query);
    $row = fetch_array($query);
    $cat_title = $row['cat_title'];
    return $cat_title;
}


function add_category(){
    if (isset($_POST['submit'])){
        $cat_title = escape($_POST['cat_title']);

        $query = query("INSERT INTO categories (cat_title) VALUES ('{$cat_title}')");
        set_message("Category created");
        redirect("index.php?categories");
    }
}

function display_users(){
    $query = query("SELECT * FROM users");
    confirm($query);
    while($row = fetch_array($query)){
        $username = escape($row['username']);
        $email = escape($row['user_email']);
        $password = escape($row['password']);
        $user_role = escape($row['user_role']);
        $id = escape($row['user_id']);
        $users = <<<DELIMITER
         <tr>
            <td>{$id}</td>
            <td><img class="admin-user-thumbnail user_image" src="http://placehold.it/62x62" alt=""></td>
            <td>{$username}</td>
            <td>{$user_role}</td>
            <td>
                <a onClick="javascript: return confirm('Are you sure you want to delete user: {$username}?');" class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$id}"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
            <td>
                <a class="btn btn-primary" href="index.php?edit_user&id={$id}"><span class="glyphicon glyphicon-edit"></span></a>
            </td>
        </tr>

DELIMITER;
        echo $users;
    }
}

function add_user(){
    if (isset($_POST['submit'])){
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        $email = escape($_POST['user_email']);
        $user_role = escape($_POST['user_role']);
        $query = query("INSERT INTO users (username, password, user_email, user_role) VALUES ('{$username}','{$password}','{$email}','{$user_role}')");
        confirm($query);
        set_message("User \"{$username}\" added");
        redirect("index.php?users");
    }
}

function edit_user(){
    if (isset($_POST['submit'])){
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        $email = escape($_POST['user_email']);
        $user_role = escape($_POST['user_role']);
        $query = query("UPDATE users SET 
            username = '{$username}',
            password = '{$password}',
            user_email = '{$email}', 
            user_role = '{$user_role}' 
            WHERE user_id=" . $_GET['id']);
        confirm($query);
        set_message("User \"{$username}\" changes made");
        redirect("index.php?users");
    }
}

function display_reports(){ 
    $query = query("SELECT * FROM reports");
    confirm($query);
    while($row = fetch_array($query)){
        $report = <<<DELIMITER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td>{$row['order_id']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMITER;
        echo $report;
    }
}

function show_featured_products(){
    $query = query("SELECT * FROM products WHERE product_featured='featured'");
    confirm($query);
    $num_slides = mysqli_num_rows($query);
    for($x = 0; $x < $num_slides; $x++){
        if ($x == 0){
        echo "<li data-target='#demo' data-slide-to='0' class='active'></li>";
        }
        else {
        echo "<li data-target='#demo' data-slide-to='{$x}'></li>";
        }
    }
echo "</ul> <div class='carousel-inner'>";
    $count = 0;
    while($row = fetch_array($query)){
        if ($count > 0){
            $class = "carousel-item";
        } else {
            $class = "carousel-item active";
        }
        $product_image = $row['product_image'];
        if ($product_image == ""){
            $product_image = "http://placehold.it/900x300";
        } else {
            $product_image = "../resources/images/{$product_image}";
        }
        $product_id = $row['product_id'];
        $featured = <<<DELIMITER
        <div style="width:100%; height:350px"; class="{$class}">
            <a href="item.php?id={$product_id}"><img style="width:100%; height:100%" src="{$product_image}" alt="">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Featured Item</h4>
                    <p>Deals on these products</p>
                </div>
            </a>

        </div>
DELIMITER;
        echo $featured;
        $count++;
    }

}

?>