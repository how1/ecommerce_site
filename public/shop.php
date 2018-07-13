<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php require_once("../resources/functions.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header>
            <h1>Shop</h1>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">
            <?php
                get_shop_page_products();
            ?>
        </div>
        <!-- /.row -->

        <hr>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
