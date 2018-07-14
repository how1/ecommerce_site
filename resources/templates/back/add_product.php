<div id="page-wrapper">

            <div class="container-fluid">






<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add Product

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <div class="form-group">
           <label for="product-title">Product Short Description</label>
      <textarea name="product_short_desc" id="" cols="15" rows="2" class="form-control"></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" step="0.01" name="product_price" class="form-control" size="60">
      </div> 

      <div class="col-xs-3">
        <label for="product-price">Product Quantity</label>
        <input type="number" name="product_quantity" class="form-control" size="60">
      </div>

    <div class="col-xs-3">
        <label for="product-featured">Is Featured</label>
        <input type="checkbox" name="product_featured" class="form-control" value="featured">
      </div>
    </div>
      



    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     <?php add_product(); ?>
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="publish" class="btn btn-primary btn-lg" value="Publish">
    </div>


     <!-- Product Categories-->
            <hr>

    <div class="form-group">
         <label for="product-title">Product Category</label>
        
         <select name="product_category_id" id="" class="form-control">
        <option value="" disabled selected>Select Category</option>
         <?php 
         $query = query("SELECT * FROM categories");
         confirm($query);
         while($row = fetch_array($query)){
            echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
}
          ?>
        </select>


</div>

    <!-- Product Brands-->


    <div class="form-group">
         <label for="product-title">Product Brand</label>
        
         <select name="product_brand" id="" class="form-control">
        <option value="" disabled selected>Select Brand</option>
         <?php 
         $query = query("SELECT * FROM brands");
         confirm($query);
         while($row = fetch_array($query)){
            echo "<option value='{$row['brand_id']}'>{$row['brand_title']}</option>";
}
          ?>
        </select>

</div> 
<!-- Product Tags -->


    <div class="form-group">
          <label for="product-title">Product Keywords</label>
          
        <input type="text" name="product_tags" class="form-control">
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
      
    </div>
<hr>


</aside><!--SIDEBAR-->


    
</form>



                



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

