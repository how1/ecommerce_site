<?php

function set_message($msg, $bg){
    ?>
    <script>
        document.getElementById('message').innerHTML = "<h3 id='message2' class='text-center bg-<?php echo $bg?>'><?php echo $msg ?></h3>";
    </script>

    <?php
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
require_once("phpass-0.5/Passwordhash.php");
function login_user(){
    if (isset($_POST['top_nav_submit'])){
        $hasher = new PasswordHash(8, false);
        $username = escape($_POST['top_nav_username']);
        $password = escape($_POST['top_nav_password']);
        if (strlen($password) > 72){ 
            set_message("Password must be 72 characters or less", "danger");
            // redirect($_SERVER['REQUEST_URI']);
        }
        $stored_hash = "*";

        $query = query("SELECT * FROM users WHERE username = '{$username}'");
        confirm($query);
        if (mysqli_num_rows($query) == 0){
            set_message("Your Username and/or Password is wrong", 'warning');
            redirect($_SERVER['REQUEST_URI']);
        }

        $row = fetch_array($query);
        $stored_hash = $row['password'];
        $check = $hasher->CheckPassword($password, $stored_hash);
        if ($check){
            if ($row['user_role'] == 'Admin') {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                set_message('Welcome to Admin', "success");
                redirect('admin');
            }
            else {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                set_message("Welcome $username", "success");
                redirect($_SERVER['REQUEST_URI']);
            }
        } else {
            // if (isset($_POST['remember_me'])){
            //     $expiration = time() + (60*60*24*7);
            //     setcookie("remember_me",'remember',$expiration);
            //     $expiration = time() + (60*60*24*7);
            //     setcookie("auto-login",'login',$expiration);
            //     $expiration = time() + (60*60*24*7);
            //     setcookie("username",$username,$expiration);
            //     $expiration = time() + (60*60*24*7);
            //     setcookie("password",$password,$expiration);
            // }
            set_message("Your Username and/or Password is wrong", "warning");
            // redirect($_SERVER['REQUEST_URI']);
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
            set_message("Error", "danger");
        } else set_message("Sent", "success");
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
        set_message("New product \"{$p_title}\" added", "success");
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
        set_message("Product \"{$p_title}\" edited", "success");
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
        set_message("Category created", "success");
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
        set_message("User \"{$username}\" added", "success");
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
        set_message("User \"{$username}\" changes made", "success");
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

function update_account(){

if (isset($_SESSION['username'])){
    $the_username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$the_username}' ";
    $select_user_query = query($query);
    while ($row = fetch_array($select_user_query)){
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $user_addr1 = $row['user_addr1'];
        $user_addr2 = $row['user_addr2'];
        $user_city = $row['user_city'];
        $user_zipcode = $row['user_zipcode'];
        $user_state = $row['user_state'];
        $user_phone_number = $row['user_phone_number'];
        $username = $row['username'];
        $user_email = $row['user_email'];
    }
                            
    if (isset($_POST['update_profile'])){
       $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_addr1 = $_POST['user_addr1'];
        $user_addr2 = $_POST['user_addr2'];
        $user_city = $_POST['user_city'];
        $user_zipcode = $_POST['user_zipcode'];
        $user_state = $_POST['user_state'];
        $user_phone_number = $_POST['user_phone_number'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_addr1 = '{$user_addr1}', ";
        $query .= "user_addr2 = '{$user_addr2}', ";
        $query .= "user_city = '{$user_city}', ";
        $query .= "user_state = '{$user_state}', ";
        $query .= "user_zipcode = '$user_zipcode', ";
        $query .= "user_phone_number = '$user_phone_number', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}' ";
        $query .= "WHERE username = '{$the_username}' ";
        $query = query($query);
        
        confirm($query);
        set_message("Changes Saved", "success");
    }

    $account_form = <<<DELIMITER
    <div class = "col-md-7">
    <div class="form-group">
        <label for="post_author">Firstname</label>
        <input type="text" value="{$user_firstname}" class="form-control" name="user_firstname">
    </div>
       
    <div class="form-group">
        <label for="post_status">Lastname</label>
        <input type="text" value="{$user_lastname}" class="form-control" name="user_lastname">
    </div>
       
    <div class="form-group">
        <label for="post_tags">Username</label>
        <input type="text" value="{$username}" class="form-control" name="username">
    </div>    
       
    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="email" value="{$user_email}" class="form-control" name="user_email">
    </div>
      
    <div class="form-group">
        <label for="post_tags">Street Address 1</label>
        <input type="text" value="{$user_addr1}" class="form-control" name="user_addr1">
    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
        <label for="post_tags">Street Address 2</label>
        <input type="text" value="{$user_addr2}" class="form-control" name="user_addr2">
    </div> 

    <div class="form-group">
        <label for="post_tags">City</label>
        <input type="text" value="{$user_city}" class="form-control" name="user_city">
    </div>

    <div class="form-group">
        <div class="form-group">
            <label for="exampleFormControlInput1">State</label>
            <select class="form-control" required name="user_state">
            <option value="{$user_state}" selected>{$user_state}</option>
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
    </div>

    <div class="form-group">
        <label for="post_tags">ZIP Code</label>
        <input type="number" value="{$user_zipcode}" class="form-control" name="user_zipcode">
    </div>

    <div class="form-group">
        <label for="post_tags">Phone Number</label>
        <input type="tel" value="{$user_phone_number}" class="form-control" name="user_phone_number">
    
    </div>
    <div class="form-group">
        <label for=""></label>
        <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
    </div>

DELIMITER;
    echo $account_form;
    }
}


?>