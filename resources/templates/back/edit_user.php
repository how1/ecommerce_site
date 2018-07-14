<div id="page-wrapper">

            <div class="container-fluid">






<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit User

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">
<?php 

$query = query("SELECT * FROM users WHERE user_id=" . escape($_GET['id']));
confirm($query);
while($row = fetch_array($query)){
    $username = escape($row['username']);
    $user_email = escape($row['user_email']);
    $password = escape($row['password']);
    $user_role = escape($row['user_role']);
}


 ?>

<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Username</label>
        <input required type="text" name="username" class="form-control" value="<?php echo $username ?>">
       
    </div>


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Password</label>
        <input required type="password" name="password" class="form-control" size="60" value="<?php echo $password ?>">
      </div>
    </div>  


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Email</label>
        <input type="email" name="user_email" class="form-control" size="60" value="<?php echo $user_email ?>">
      </div>
    </div>

 <div class="form-group">
         <label for="product-title">User Role</label>
        
         <select name="user_role" id="" required class="form-control">
            <?php if ($user_role == "Admin"){
                echo "<option value='Admin' selected>Admin</option>";
                echo "<option value='User'>User</option>";
            } else {
                echo "<option value='User' selected>User</option>";
                echo "<option value='Admin'>Admin</option>";
            }?>
        </select>

</div>


    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     <?php edit_user(); ?>
     <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Save">
    </div>

</aside><!--SIDEBAR-->

   
    
</form>



                



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

