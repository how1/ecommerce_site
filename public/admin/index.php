<?php require_once("../../resources/config.php");?>
<?php include(TEMPLATE_BACK . DS . "header.php")?>

<!-- validate session -->
<?php if (!isset($_SESSION['username'])){
    redirect("../../public");
}
?>

<?php 
if ($_SERVER['REQUEST_URI'] == "/ecommerce_website/public/admin/" || $_SERVER['REQUEST_URI'] == "/ecommerce_website/public/admin/index.php"){
    include(TEMPLATE_BACK . DS . "admin_content.php");

}
else if (isset($_GET['orders'])){
    include(TEMPLATE_BACK . DS . "orders.php");
}

else if (isset($_GET['add_product'])){
    include(TEMPLATE_BACK . DS . "add_product.php");
}else if (isset($_GET['products'])){
    include(TEMPLATE_BACK . DS . "products.php");
}
else if (isset($_GET['edit_product'])){
    include(TEMPLATE_BACK . DS . "edit_product.php");
}
else if (isset($_GET['categories'])){
    include(TEMPLATE_BACK . DS . "categories.php");
}
else if (isset($_GET['users'])){
    include(TEMPLATE_BACK . DS . "users.php");
}
else if (isset($_GET['products'])){
    include(TEMPLATE_BACK . DS . "products.php");
}
else if (isset($_GET['reports'])){
    include(TEMPLATE_BACK . DS . "reports.php");
}
?>

        </div>
        <!-- /#page-wrapper -->

<?php include(TEMPLATE_BACK . DS . "footer.php")?>
