<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;margin-right: auto;margin-left: auto; font-size:12px;">		
	<div style="display: flex;flex-wrap: wrap;">
		<table style="font-size:12px;border-collapse: collapse;">
		  <thead>
			<tr>
			  <th style="border-bottom: 2px solid black;border-left: 2px solid black;border-right:2px solid black;border-top:2px solid black;text-align:left;">Store name</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Product Name</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Model</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Qty</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Pack Unit</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Batch No</th>
			  <th style="border-bottom: 2px solid black;border-right:2px solid black;border-top:2px solid black;">Expiry Date</th>
			</tr>
		  </thead>		 
		  <tbody>
			<?php if(isset($stocks)){ ?>
				<?php foreach($stocks as $stock){ ?>						
						
					  <tr>
						<td style="border-bottom: 2px solid black;border-left: 2px solid black;border-right:2px solid black;text-align:left;"><?php echo $stock['store_name']; ?></td>
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo $stock['product_name']; ?></td>
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo $stock['model']; ?></td>
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo ($stock['qty'] - $stock['challan_qty']) + $stock['return_qty']; ?></td>
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo $stock['unit_name']; ?></td>
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo $stock['batch_no']; ?></td>						
						<td style="border-bottom: 2px solid black;border-right:2px solid black;"><?php echo dateFormat('m/Y', $stock['s_exp_date']); ?></td>
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	</div>
</div>