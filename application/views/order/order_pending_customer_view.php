<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> ( <?php echo $orders[0]['customer_name']; ?> )</h1> <?php echo $this->breadcrumbs->show(); ?>	
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
							<td><?php if($order['order_qty']){ echo $order['order_qty']; } else { echo '0'; } ?></td>	
							<td><?php echo $order['order_qty'] - $order['challan_qty']; ?></td>
							<td><a style="padding-left:7px;" href="<?php echo site_url('orderCustomerView'); ?>/<?php echo $order['order_id']; ?>?customer_id=<?php echo $order['customer_id']; ?>" title="Order View" ><i class="fas fa-eye"></i></a></td>
						</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
  </div>
  
</div>