 <!-- Navigation -->
    <nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark" role="navigation">
      <div class="container">
            <div>
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_cart.php">Cart</a>
                    </li>
                </ul>
                <!-- Top Menu Items -->
            <ul class="navbar-nav dropdown" >
              <?php 

              if (isset($_SESSION['username'])){
                 echo"
<div class='dropdown show'>
  <a class='btn btn-primary dropdown-toggle' href='#'' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    {$_SESSION['username']}
  </a>

  <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
    <a class='dropdown-item' href='admin/logout.php'>Logout</a>
    
  </div>
</div>";
              
                          
              } else {
                if (isset($_COOKIE['remember_me'])){
                  if ($_COOKIE['auto-login'] == 'login'){
                    $_POST['username'] = $_COOKIE['username'];
                    $_POST['password'] = $_COOKIE['password'];
                  }
                }
              login_user();

             echo "
  <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
      Login
    </button>
<div class='dropdown-menu dropdown-menu-right'>
  <form class='px-4 py-3' action='{$_SERVER['REQUEST_URI']}' method='post' enctype='multipart/form-data'>

   
    <div class='form-group'>
      <label for='exampleDropdownFormEmail1'>Username</label>";

if (isset($_COOKIE['remember_me'])){
        $username = $_COOKIE['username'];
        $password = $_COOKIE['password'];
              
    echo "<input type='text' required class='form-control' name='username' id='DropdownFormEmail' value='{$username}'>
            </div>
            <div class='form-group'>
              <label for='exampleDropdownFormPassword1'>Password</label>
              <input type='password' required class='form-control' name='password' id='DropdownFormPassword' value='{$password}'>
              </div>
          <div class='form-check'>
          <input type='checkbox' checked class='form-check-input' name='remember_me' value='remember' id='remember_me'>";
} else { 
      unset($_COOKIE['username']);
      unset($_COOKIE['password']);
      unset($_COOKIE['auto-login']);
      echo "<input type='text' required class='form-control' name='username' id='DropdownFormEmail' placeholder='Username'>
    </div>
    <div class='form-group'>
      <label for='exampleDropdownFormPassword1'>Password</label>
      <input type='password' required class='form-control' name='password' id='DropdownFormPassword' placeholder='Password'>
       <div class='form-check'>
          <input type='checkbox' class='form-check-input' name='remember_me' value='remember' id='remember_me'>";

    }
      $form = <<<DELIMITER
    
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" name="remember_me" value="remember" id="remember_me">
      <label class="form-check-label" for="dropdownCheck">
        Remember me
      </label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
  </form>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">New around here? Sign up</a>
  <a class="dropdown-item" href="#">Forgot password?</a>
</div>
</div>
    </ul>

DELIMITER;
echo $form;
}
?>
            </ul>
            <!-- /.navbar-collapse-->
          </div> 
        <!-- /.container -->
    </nav>

