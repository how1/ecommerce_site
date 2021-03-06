<?php require_once("../resources/config.php");?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?> 
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>

    <!-- Page Content -->
<div class="container">

       <!-- Side Navigation -->

           <?php //include(TEMPLATE_FRONT . DS . "side_nav.php");?>
<?php 
    
$query = query(" SELECT * FROM products WHERE product_id = " . escape($_GET['id']) . " ");
while($row = fetch_array($query)){
    $product_title = $row['product_title'];
    $product_id = $_GET['id'];
    $product_price = $row['product_price'];
    $product_description = $row['product_description'];
    $short_desc = $row['short_desc'];
    $product_image = $row['product_image'];
}
?>
<div style="margin-top: 70px">
<div class="" style="margin: 0; padding: 0">

<!--Row For Image and Short Description-->

<div class="row">

    <div class="col-sm-7">
        <?php 
        if (!$product_image){
            $image_path = "http://placehold.it/320x150";
        } else {
            $image_path = "../resources/images/{$product_image}";
        }
         ?>
        
       <img class="img-fluid" src="<?php echo $image_path;?>" alt="">

    </div>

    <div class="col-sm-5">

        <div class="card">
         

    <div class="caption-full" style="margin: 10px">
        <h4><?php echo $product_title;?></h4>
        <h4 class="">&#36;<?php echo $product_price; ?></h4>

    <div class="ratings">
     
        <p>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
            <span class="fas fa-star-empty"></span>
            4.0 stars
        </p>
    </div>
          
        <p><?php echo $short_desc;?></p>

   
    <form action="">
        <div class="form-group">
             <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add=<?php echo $_GET['id']; ?>">Add to Cart</a>
        </div>
    </form>

    </div>
 
</div>

</div>


</div><!--Row For Image and Short Description-->


        <hr>


<!--Row for Tab Panel-->

<div class="row">

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-item"><a class="nav-link active" href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation" class="nav-item"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

<p></p>
           
    <p><?php echo $product_description;?></p>

    </div>
    <div role="tabpanel" class="tab-pane" id="profile" style="margin: 5%">

  <div class="col-md-6">

       <h3>2 Reviews From </h3>

        <hr>

        <div class="row">
            <div class="col-sm-12">
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star-empty"></span>
                Anonymous
                <span class="pull-right">10 days ago</span>
                <p>This product was great in terms of quality. I would definitely buy another!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-12">
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star-empty"></span>
                Anonymous
                <span class="pull-right">12 days ago</span>
                <p>I've alredy ordered another one!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-12">
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star-empty"></span>
                Anonymous
                <span class="pull-right">15 days ago</span>
                <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
            </div>
        </div>

    </div>


    <div class="col-sm-6">
        <h3>Add A review</h3>

     <form action="" class="form-inline">
        <div class="form-group">
            <label for="">Name</label>
                <input type="text" class="form-control" >
            </div>
             <div class="form-group">
            <label for="">Email</label>
                <input type="test" class="form-control">
            </div>

        <div>
            <h3>Your Rating</h3>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
            <span class="fas fa-star"></span>
        </div>

            <br>
            
             <div class="form-group">
             <textarea name="" id="" cols="60" rows="10" class="form-control"></textarea>
            </div>

             <br>
              <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="SUBMIT">
            </div>
        </form>

    </div>

 </div>

 </div>

</div>


</div><!--Row for Tab Panel-->




</div>
<!--col-md-9 ends here-->
</div>  
</div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . 'footer.php');?>