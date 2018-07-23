<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>

    <!-- Page Content -->
    <div class="container" style="margin-top: 70px">

        <!-- Jumbotron Header -->
        <header>
            <h1> <?php echo get_cat_name($_GET['id']); ?></h1>
        </header>


        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row">
            <?php
                get_cat_page_products();
            ?>
        </div>
        <!-- /.row -->


<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
