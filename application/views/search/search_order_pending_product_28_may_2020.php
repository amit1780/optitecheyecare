<table class="table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>					  
			<th>Product Name</th>					
			<th>Model</th>
			<th>Pending Orders</th>			
			<th>In Stock</th>					
			<th>Stock To Approve</th>									
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
				
				$pending_qty = $order['order_qty'] - $order['challan_qty'];
				if($order['order_qty'] > $in_stock2){
					$pending_qty = "<b style='color:red;'>".$order['order_qty']."</b>";
				}
			?>
		
			<tr>
				<td><a target="_blank" href="<?php echo site_url('productView');?>/<?php echo $order['prod_id']; ?>"><?php echo $order['prod_name']; ?></a></td>
				<td><?php echo $order['model_name']; ?></td>
				<td><?php echo $pending_qty; ?></td>
				
				<td><?php echo $in_stock; ?></td>
				<td><?php if($order['pending_stock']){ echo $order['pending_stock']; } else { echo '0'; } ?></td>
											
				<td><a target="_blank" style="padding-left:7px;" href="<?php echo site_url('orderPendingProductView'); ?>/<?php echo $order['prod_id']; ?>" title="Order List" ><i class="fas fa-eye"></i></a></td>
			</tr>
		<?php } ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="6">No results!</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
		