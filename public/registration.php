<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>
<?php require_once("../resources/functions.php");?>
<h3 class="text-center bg-success"><?php set_message(); ?></h3>
<?php
if (isset($_POST['submit'])){
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    if (strlen($username) !== 0 && strlen($password) !== 0 && strlen($email) !== 0){
    
        $username = escape($username);
        $password = escape($password);
        $email = escape($email);
        $check_unique_username = query("SELECT * FROM users WHERE username = '{$username}'");
        confirm($check_unique_username);
        if (mysqli_num_rows($check_unique_username) != 0){
            set_message("Username already taken");
        } else {
            // $query = "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);

            // if (!$select_randsalt_query){
            //     die("Query failed " . mysqli_error($connection));
            // }

            // $row = mysqli_fetch_assoc($select_randsalt_query);
            // $salt = $row['randSalt'];
            // $password = crypt($password, $salt);


            $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
            $query .= "VALUES('{$username}', '{$email}', '{$password}', 'User')";
            $register_user_query = mysqli_query($connection, $query);
            if (!$register_user_query){
                die("Query failed: " . mysqli_error($connection));
            }
            set_message("Your registration has been submitted");
        }
    }
} 

?>

    <!-- Navigation -->
    
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
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
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
