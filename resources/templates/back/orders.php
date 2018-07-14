<div id="page-wrapper">

    <div class="container-fluid">

        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Orders
</h1>
<ol class="breadcrumb">
  <li class="active">
      <i class="fa fa-bar-chart-o"></i> Orders
  </li>
</ol>
<h3 class="text-center bg-success"><?php display_message(); ?></h3>
</div>

<div class="row">
<table class="table table-hover">
    <thead>
      <tr>
           <th>ID</th>
           <th>Amount</th>
           <th>Transaction</th>
           <th>Currency</th>
           <th>Status</th>
      </tr>
    </thead>
    <tbody>
       <?php display_orders(); ?>
    </tbody>
</table>
</div>
</div>
            <!-- /.container-fluid -->
</div>
<!-- #page-wrapper -->