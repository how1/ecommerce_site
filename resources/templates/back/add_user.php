<div id="page-wrapper">

            <div class="container-fluid">






<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add User

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Username</label>
        <input required type="text" name="username" class="form-control">
       
    </div>


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Password</label>
        <input required type="password" name="password" class="form-control" size="60">
      </div>
    </div>  


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Email</label>
        <input type="email" name="user_email" class="form-control" size="60">
      </div>
    </div>

 <div class="form-group">
         <label for="product-title">User Role</label>
        
         <select name="user_role" id="" required class="form-control">
        <option value="" disabled selected>Select Role</option>
         <option value='Admin'>Admin</option>
         <option value='User'>User</option>
        </select>

</div>


    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     <?php add_user(); ?>
     <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Add User">
    </div>

</aside><!--SIDEBAR-->

   
    
</form>



                



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

