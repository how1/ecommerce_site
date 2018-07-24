<?php require_once("../resources/config.php");?>
<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<?php include(TEMPLATE_FRONT . DS . "top_nav.php");?>

<body>

<div class="container" style="margin-top: 70px">
	<h1 class="text-center">Account<small></small></h1>
<a id="message" href="" style="text-decoration: none; color: white"><h4 class="text-center bg-danger"></h4></a>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="row">     
			   <?php update_account();?>	
		</div>
	</form>
    </div>
    <!-- /.container-fluid-->
</div>
<!-- /.page-wrapper -->
       
        
<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
