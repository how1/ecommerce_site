<div id="page-wrapper">

            <div class="container-fluid">






<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product

</h1>
</div>
               

<?php 

edit_product();


if (isset($_GET['id'])){
    $query = query("SELECT * FROM products WHERE product_id=" . $_GET['id']);
    confirm($query);
    while($row = fetch_array($query)){
      $product_title = escape($row['product_title']);
      $product_category_id = escape($row['product_category_id']);
      $product_description = escape($row['product_description']);
      $product_price = escape($row['product_price']);
      $short_desc = escape($row['short_desc']);
      $product_image = escape($row['product_image']);
      $product_quantity = escape($row['product_quantity']);
      $product_tags = escape($row['product_tags']);
      $product_brand = escape($row['product_brand']);
    }
    $query = query("SELECT * FROM brands WHERE brand_id=" . $product_brand);
    confirm($query);
    $row = fetch_array($query);
    $product_brand_title = $row['brand_title'];
    $query = query("SELECT * FROM categories WHERE cat_id=" . $product_category_id);
    confirm($query);
    $row = fetch_array($query);
    $product_cat_title = $row['cat_title'];

    $form = <<<DELIMITER

    <form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value="{$product_title}">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control">{$product_description}</textarea>
    </div>
    <div class="form-group">
           <label for="product-title">Product Short Description</label>
      <textarea name="product_short_desc" id="" cols="15" rows="2" class="form-control">{$short_desc}</textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" step="0.01" name="product_price" class="form-control" size="60" value="{$product_price}">
      </div>
    </div>  


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Quantity</label>
        <input type="number" name="product_quantity" class="form-control" size="60" value="{$product_quantity}">
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
        <option value="{$product_brand}" disabled selected>{$product_cat_title}</option>
DELIMITER;
         echo $form;
         
         $query = query("SELECT * FROM categories");
         confirm($query);
         while($row = fetch_array($query)){
            echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
        }

          $form = <<<DELIMITER
        </select>


</div>

    <!-- Product Brands-->


    <div class="form-group">
         <label for="product-title">Product Brand</label>
        
         <select name="product_brand" id="" class="form-control">
        <option value="{$product_brand}" disabled selected>{$product_brand_title}</option>
DELIMITER;
         echo $form;

         $query = query("SELECT * FROM brands");
         confirm($query);
         while($row = fetch_array($query)){
            echo "<option value='{$row['brand_id']}'>{$row['brand_title']}</option>";
}
          $form = <<<DELIMITER
        </select>

</div> 
<!-- Product Tags -->


    <div class="form-group">
          <label for="product-title">Product Keywords</label>
          
        <input type="text" name="product_tags" class="form-control" value="{$product_tags}">
    </div>

    <!-- Product Image -->
    <img style="width:75px" src="../../resources/images/{$product_image}" alt="">
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
      
    </div>
<hr>


</aside><!--SIDEBAR-->


    
</form>

DELIMITER;
echo $form;
}

?>



                



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
