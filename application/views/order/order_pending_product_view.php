<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> (<?php echo $orders[0]['prod_name']." # ".$orders[0]['model_name'] ; ?>)</h1> <?php echo $this->breadcrumbs->show(); ?>
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 
  <div class="card mb-3">	
	<div class="card-body">
	
		<div class="table-responsive">
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				<thead>
					<tr>					  
						<th>Order No</th>					
						<th>Quotation No</th>																		
						<th>Customer Name</th>																		
						<th>TotalOrdQty</th>
						<th>TotalPendingQty</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if($orders){ ?>
					<?php foreach($orders as $order){ ?>
						<tr>
							<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>"> <?php echo getOrderNo($order['order_id']); ?></a></td>
							<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $order['quotation_id']; ?>"><?php echo getQuotationNo($order['quotation_id']); ?></a></td>							
							<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $order['customer_id']; ?>"><?php echo $order['customer_name']; ?></a></td>	
							<td><?php echo $order['qty']; ?></td>	
							<td><?php echo ($order['qty'] - $order['challan_qty']); ?></td>
							<td><a style="padding-left:7px;" href="<?php echo site_url('orderProductView'); ?>/<?php echo $order['order_id']; ?>?product_id=<?php echo $product_id; ?>" title="Order View" ><i class="fas fa-eye"></i></a></td>
						</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
  </div>
  
</div>