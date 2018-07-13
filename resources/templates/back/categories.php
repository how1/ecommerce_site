<div id="page-wrapper">

            <div class="container-fluid">

            

            

<h1 class="page-header">
  Product Categories

</h1>

<h3 class="bg bg-success text-center"><?php display_message(); ?></h3>
<div class="col-md-4">
    <?php add_category();?>
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control" name="cat_title">
        </div>

        <div class="form-group">
            
            <input type="submit" class="btn btn-primary" value="Add Category" name="submit">
        </div>      


    </form>


</div>


<div class="col-md-8">

    <table class="table">
            <thead>

        <tr>
            <th>ID</th>
            <th>Title</th>
        </tr>
            </thead>


    <tbody>
        <?php
       show_admin_categories();
         ?>
    </tbody>

        </table>

</div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->