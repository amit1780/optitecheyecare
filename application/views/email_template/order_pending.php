<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pending orders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <p><b>List of Pending orders</b></p>
    <div style="overflow-x: scroll; margin-top:0px;">
  <table cellspacing="0" cellpadding="1" border="0" width="100%">					

		<tr>
			<td><b>Sr.</b></td>
			<td><b>Order Id</b></td>
			<td><b>Quotation Id</b></td>
			<td><b>Date</b></td>
			<td><b>Customer Name</b></td>					   
			<td><b>Currency</b></td>
			<td><b>Net Amount</b></td>
			
		</tr>
		<?php $i=1; foreach($pendingOrders as $pendingOrder){ ?>		
			<tr>
			    <td><?php echo $i; ?></td>
				<td><b><?php echo str_pad($pendingOrder['order_id'], 6, "O00000", STR_PAD_LEFT); ?></b></td>
				<td><?php echo str_pad($pendingOrder['quotation_id'], 6, "Q00000", STR_PAD_LEFT); ?></td>
				<td><?php echo date('d-m-Y',strtotime($pendingOrder['date_added'])); ?></td>
				<td><?php echo $pendingOrder['customer_name']; ?></td>				
				<td><?php echo $pendingOrder['currency']; ?></td>				
				<td><?php echo $pendingOrder['net_amount']; ?></td>				
			</tr>		
		<?php $i++; } ?>
	</table>
  </div>
</body>
</html>