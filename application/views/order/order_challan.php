<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> (<a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order_id; ?>"><?php echo getOrderNo($order_id); ?></a>)</h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->	 

<!--Pending Challan --> 	 
  <div class="card mb-3">
	<div class="card-header">
		  <i class="fas fa-table"></i>
		 Pending Challan</div>
	<div class="card-body">		
		<div class="table-responsive">
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				  <thead>
					<tr>
					  <th>Product Description</th>
					  <th>Order Qty</th>
					  <th>Pending Qty</th>
					  <th>Pack</th>
					  <th>Rate</th>
					  <th>Discount</th>
					  <th>Net Amount</th>
					  <!-- <th>Action</th> -->
					 </tr>
				  </thead>
				  <tbody>
					<?php if($pendingChallanLists){ $i=0; ?>
						<?php foreach($pendingChallanLists as $pendingChallanList){ ?>
							<?php if($pendingChallanList['qty'] != $pendingChallanList['challan_qty']){ ?>
							<tr class="alert-danger">
								<td><?php echo $pendingChallanList['description']; ?></td>
								<td><?php echo $pendingChallanList['qty']; ?></td>
								<td><b><?php echo ($pendingChallanList['qty'] - $pendingChallanList['challan_qty']); ?></b></td>
								<td><?php echo $pendingChallanList['unit']; ?></td>
								<td><?php echo $pendingChallanList['rate']; ?></td>
								<td><?php echo $pendingChallanList['discount']; ?></td>
								<td><?php echo $pendingChallanList['net_amount']; ?></td>
								<!-- <td></td> -->
							</tr>
							<?php $i++; } ?>						
							<?php } ?>						
						<?php } ?>
						<?php if($i==0){ ?>
							<tr>
								<td class="text-center" colspan="7">No results!</td>
							</tr>
						<?php } ?> 
				  </tbody>
			</table>
		</div>
	</div>	
  </div>
<!--End Pending Challan -->  
  
 <!-- Complete Challan --> 
  <div class="card mb-3">
	<div class="card-header">
		  <i class="fas fa-table"></i>
		 Complete Challan</div>
	<div class="card-body">		
		<div class="table-responsive">
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				 <thead>
					<tr>
					  <th>Product Description</th>
					  <th>Order Qty</th>
					  <th>Challan Qty</th>
					  <th>Pack</th>
					  <th>Rate</th>
					  <th>Discount</th>
					  <th>Net Amount</th>
					  <!-- <th>Action</th> -->
					 </tr>
				  </thead>
				  <tbody>
					<?php if($completeChallanLists){ ?>
						<?php foreach($completeChallanLists as $completeChallanList){ ?>
							<tr>
								<td><?php echo $completeChallanList['description']; ?></td>
								<td><?php echo $completeChallanList['ord_qty']; ?></td>
								<td><?php echo $completeChallanList['challan_qty']; ?></td>
								<td><?php echo $completeChallanList['unit']; ?></td>
								<td><?php echo $completeChallanList['rate']; ?></td>
								<td><?php echo $completeChallanList['discount']; ?></td>
								<td><?php echo $completeChallanList['net_total']; ?></td>
								<!-- <td></td> -->
							</tr>
						<?php } ?>
						<?php } else { ?>
							<tr>
								<td class="text-center" colspan="7">No results!</td>
							</tr>
						<?php } ?> 
				  </tbody>
			</table>
		</div>
	</div>	
  </div>
<!-- End Complete Challan -->
  
</div>