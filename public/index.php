<?php require_once("../resources/config.php");?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>


    <!-- Page Content -->
    <div class="container" style="margin-top: 70px">
    <a id="message" href="#" style="text-decoration: none; color: white"></a>
        <div class="row">

<!--           Categories Here-->
            <?php include(TEMPLATE_FRONT . DS . "side_nav.php");?>

            <div class="col-sm-9">

                <div class="row carousel-holder">

                    <div class="col-sm-12">
<!--                        Carosel Here-->
                   <?php include(TEMPLATE_FRONT . DS . "slider.php");?>
                    </div>
                    <div class="row" style="margin: 15px 0 0 0;">
                
                   <?php get_products();?>

                </div>
                </div>
<!--row starts here-->

                
<!--row ends here-->
            </div>

        </div>

    </div>
    <!-- /.container -->


   <?php include(TEMPLATE_FRONT . DS . "footer.php");?>