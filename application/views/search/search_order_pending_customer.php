<table class="table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>					  
			<th>Customer Name</th>					
			<th>Email</th>					
			<th>Mobile</th>					
			<th>Currency</th>					
								
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if($orders){ ?>
		<?php foreach($orders as $order){ ?>
			<tr>
				<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $order['customer_id']; ?>"><?php echo $order['customer_name']; ?></a></td>
				<td><?php echo $order['contact_email']; ?></td>
				<td><?php echo $order['contact_phone']; ?></td>							
				<td><?php echo $order['currency']; ?></td>														
				<td><a target="_blank" style="padding-left:7px;" href="<?php echo site_url('orderPendingCustomerView'); ?>/<?php echo $order['customer_id']; ?>" title="" ><i class="fas fa-eye"></i></a></td>
			</tr>
		<?php } ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="5">No results!</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
		