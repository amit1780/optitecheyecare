<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto; font-size:12px;">
			
		<div style="border-top:0px solid black;border-left:2px solid black;border-right:2px solid black;margin-top:-16px;">
				<?php $order_date = new DateTime($orderInfo->order_date); ?>
				
				<div style="width:50%;float:left;border-top: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<p style="margin-bottom:0px;"><b>Order No: <?php echo getOrderNo($challanInfo->order_id); ?></b> &nbsp;&nbsp;&nbsp; <b>Order date :</b> <?php echo dateFormat('d-m-Y', $orderInfo->order_date); ?></p>							
				</div>
				
				<div style="float:left;border-top: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<p style="margin-bottom:0px;"><b>Invoice No:</b> <?php echo $challanInfo->invoice_no; ?> &nbsp;&nbsp;&nbsp; <b>Dt:</b> <?php echo dateFormat('F, d, Y', $challanInfo->invoice_date);  ?> </p>
				</div>				
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid black;border-bottom: 0px solid black;padding-left:3px;">
					<p style="margin-bottom:0px;"><b>Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 0px solid black;padding-left:3px;">
					<p style="margin-bottom:0px;"><b>Customer Name:</b> <?php echo $customerInfo->company_name; ?></p>
				</div>
				
		</div>
		<div style="border:0px solid black;">
				<div style="width:100%;float:left;">
					<table style="font-size:12px;border-collapse: collapse;border-top:2px solid black;" >
						<tr>
							<th  style="width:4%;border-bottom:2px solid black;border-left:2px solid black;border-right:2px solid black;">S.N.</th>
							<th  style="width:25%;border-bottom:2px solid black;border-right:2px solid black;">Challan No</th>
							<th  style="width:7%;border-bottom:2px solid black;border-right:2px solid black;text-align:left;">Product Description</th>							
							<th  style="width:12%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Batch No</th>							
							<th  style="width:5%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Exp. Date</th>
							<th  style="width:6%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Qty Sold</th>
							<th  style="width:8%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Qty Returns</th>																
							<th  style="width:7%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Return Date</th>
						</tr>
						
						<?php 
							$i=1; foreach($challanProInfo as $challanPro){ 
							$expDate = date('m/Y',strtotime($challanPro['batch_exp_date']));
							if(($challanPro['return_datetime'] == '0000-00-00 00:00:00') || ($challanPro['return_qty'] == '')){
								continue;
							}
						?>						
							
							<tr class="prtr">
								<td  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" ><?php echo $i; ?></td>
								<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><b><?php echo getChallanNo($challanPro['challan_id']); ?></td>
								<td align="left" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanPro['pro_description']; ?></td>
								
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanPro['batch_no']; ?></td>
								
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $expDate; ?></td>
								
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanPro['qty']; ?></td>								
								
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php if($challanPro['return_qty']){ echo $challanPro['return_qty'];} else { echo "0"; } ?></td>
								
								
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo dateFormat('d-m-Y', $challanPro['return_datetime']); ?></td>
													
							</tr>
						
						<?php $i++; } ?>
					
												
					</table>
				</div>
				
				
				<div class="row" style="font-size:16px;margin-top:20px;">
						<div class="col-sm-12" style="padding-left: 0px;">
							<p style="margin: 0px;"><b>Return Note</b></p> 
							<?php if($returnNotes->return_note){ echo $returnNotes->return_note;}	?>
						</div>					
					</div>	
				
		</div>

</div>