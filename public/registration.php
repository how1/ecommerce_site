<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>
<?php require_once("../resources/phpass-0.5/PasswordHash.php");?>



    <!-- Navigation -->
    
    
 
    <!-- Page Content -->
    <div class="container-nav">
    
<section id="login">
<a id="message" href="#" style="text-decoration: none; color: white"></a>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="form-wrap">
                <h1 class="text-center">Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" required name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" required name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" required name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Re-Enter Password</label>
                            <input type="password" required name="password2" id="key2" class="form-control" placeholder="Re-Enter Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
</div>

<?php
if (isset($_POST['submit'])){
    
    $username = escape(strtolower($_POST['username']));
    $password = escape($_POST['password']);
    $password2 = escape($_POST['password2']);
    if ($password != $password2){
        set_message('Passwords do not match','danger'); 
        
    } else {
        if (strlen($password) > 72){
            set_message('Password must be less than 72 characters','danger'); 
        }
        $email = escape($_POST['email']);
        
        $check_unique_username = query("SELECT * FROM users WHERE username = '{$username}' ");
        confirm($check_unique_username);
        if (mysqli_num_rows($check_unique_username) != 0){
            set_message('Username already taken','warning'); 
        } else {
            $hasher = new PasswordHash(8, false);
            $password = $hasher->HashPassword($password);
            if (strlen($password) >=20){
                $query = "INSERT INTO users (username, user_email, password, user_role) ";
                $query .= "VALUES('{$username}', '{$email}', '{$password}', 'User')";
                $register_user_query = mysqli_query($connection, $query);
                if (!$register_user_query){
                    die("Query failed: " . mysqli_error($connection));
                }
                
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                set_message("Welcome $username", 'success');
                redirect($_SERVER['REQUEST_URI']);

            } else {
                set_message('Something went wrong','danger'); 
            }
        }
    }
} 

?>


<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
