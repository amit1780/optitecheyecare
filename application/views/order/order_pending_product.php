<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> </h1> <?php echo $this->breadcrumbs->show(); ?>
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->	 
	 
  <div class="card mb-3">	
	<div class="card-body">
	
		<form role="form" class="needs-validation" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Product Name / Description</div> 
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" >					
				  </div>
				</div>
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Model name</div> 
					<input type="text" name="model_name" value="<?php if(!empty($this->input->get('model_name'))){ echo $this->input->get('model_name'); } ?>" id="model_name" class="form-control" >					
				  </div>
				</div>				
			</div>	
			<div class="row">	
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="submit" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>			
			</div> 	
		</form>
		
		<div class="table-responsive">
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				<thead>
					<tr>					  
						<th>Product Name</th>					
						<th>Model</th>					
						<th>In Stock</th>					
						<th>Stock in Pending</th>					
						<th>TotalOrdQty</th>						
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if($orders){ ?>
					<?php foreach($orders as $order){ ?>
						<?php
							$in_stock = ($order['in_stock'] - $order['out_qty']) + $order['return_qty'];
							$in_stock2 = ($order['in_stock'] - $order['out_qty']) + $order['return_qty'];
							if($in_stock == 0){
								$in_stock = "<b style='color:red;'>".$in_stock."</b>";
							}
							
							$order_qty = $order['order_qty'];
							if($order['order_qty'] > $in_stock2){
								$order_qty = "<b style='color:red;'>".$order['order_qty']."</b>";
							}
						?>
					
						<tr>
							<td><a target="_blank" href="<?php echo site_url('productView');?>/<?php echo $order['prod_id']; ?>"><?php echo $order['prod_name']; ?></a></td>
							<td><?php echo $order['model_name']; ?></td>
							<td><?php echo $in_stock; ?></td>
							<td><?php if($order['pending_stock']){ echo $order['pending_stock']; } else { echo '0'; } ?></td>
							<td><?php echo $order_qty; ?></td>							
							<td><a style="padding-left:7px;" href="<?php echo site_url('orderPendingProductView'); ?>/<?php echo $order['prod_id']; ?>" title="Order List" ><i class="fas fa-eye"></i></a></td>
						</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $pagination; ?>
  </div>
  
</div>