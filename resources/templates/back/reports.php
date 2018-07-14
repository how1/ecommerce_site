<div id="page-wrapper">

    <div class="container-fluid">

        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   Reports
</h1>
<ol class="breadcrumb">
  <li class="active">
      <i class="fa fa-bar-chart-o"></i> Reports
  </li>
</ol>
<h3 class="text-center bg-success"><?php display_message(); ?></h3>
</div>

<div class="row">
<table class="table table-hover">
    <thead>
      <tr>
           <th>Report ID</th>
           <th>Product ID</th>
           <th>Product Title</th>
           <th>Product Price</th>
           <th>Product Quantity</th>
           <th>Order ID</th>
      </tr>
    </thead>
    <tbody>
       <?php display_reports(); ?>
    </tbody>
</table>
</div>
</div>
            <!-- /.container-fluid -->
</div>
<!-- #page-wrapper -->
