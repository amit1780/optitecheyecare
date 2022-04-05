<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;margin-right: auto;margin-left: auto; font-size:12px;">
	<div class="row">		
		<div class="col-sm-12">			
			<span>Customer Name: <b><?php echo $customerInfo->company_name; ?></b></span>&nbsp; | &nbsp;
			
			<span>Total Bills: <b><?php if($ChallanTotal['currency_id'] == 1){ echo '<l class="fas fa-rupee-sign"></i>'; } else { echo $ChallanTotal['currency_html']; } ?> <?php echo number_format((float)($ChallanTotal['net_total']), 2, '.', '') ; ?></b></span>&nbsp;  &nbsp;
			
			<span>Outstanding Balance: <b><?php if($ChallanTotal['currency_id'] == 1){ echo '<l class="fas fa-rupee-sign"></i>'; } else { echo $ChallanTotal['currency_html']; } ?> <?php echo number_format((float)($ChallanTotal['net_total'] - $total_amount), 2, '.', '') ; ?></b></span>		
		</div>
	</div><br>
	<div style="display: flex;flex-wrap: wrap;">		
		<table style="font-size:12px;border-collapse:collapse;" align="center">
			  <thead>
				<tr>
				  <th style="border-bottom: 1px solid black;border-left: 1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:left;">Date</th>
				  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:center;width:150px;">Reference Number</th>
				  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Out</th>
				  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">In </th>
				  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:right;width:150px;">Balance</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php $CI =& get_instance(); ?>
				<?php
					$in = 0;
					$inTot = 0;
					$out = 0;
					$outTot = 0;
					$avil = 0;
				?>
				<?php foreach($paymentSummary as $payment){  ?>
				<?php
					$returnAmount=0;
					if($payment['in']){
						$in = $in + $payment['in'];
					}									
					if($payment['out']){
						$out = $out + $payment['out'];		
						$returnAmount = $CI->customer_model->getGoodsReturnAmountForChallan($payment['cid'],$this->input->get('customer_id'));			
						$returnAmount=round($returnAmount);								
					}
					if(!empty($returnAmount)){
						$in = $in + $returnAmount;
						$inTot = $inTot + $returnAmount;
					}
					$avil = $in - $out;
					$inTot = $inTot + $payment['in'];
					$outTot = $outTot + $payment['out'];
				?>
					<tr>
						<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right:1px solid black;text-align:left;"><?php echo dateFormat('d-m-Y',$payment['date_time']); ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:center;"><?php echo $payment['challan_id']; ?></td>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:center;width:150px;"><?php if($payment['out'] > 0){ echo $payment['currency_faclass'].' '.number_format((float)($payment['out']), 2, '.', ''); } ?></td>
						<?php if(!empty($returnAmount)){ ?>
							<td style="color:red;border-bottom: 1px solid black;border-right:1px solid black;text-align:center;width:150px;"><?php if($returnAmount > 0){  echo $payment['currency_faclass'].' '.number_format((float)($returnAmount), 2, '.', ''); } ?><br><i>Goods return</i></td>	
						<?php }else{ ?>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:center;width:150px;"><?php if($payment['in'] > 0){  echo $payment['currency_faclass'].' '.number_format((float)($payment['in']), 2, '.', ''); } ?></td>	
						<?php } ?>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:right;width:150px;"><?php  echo number_format((float)($avil), 2, '.', '');  ?></td>
					</tr>
				<?php } ?>
				<tr>
						<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right:1px solid black;text-align:left;">&nbsp;</td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;">&nbsp;</td>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:center;"><b><?php  echo number_format((float)($outTot), 2, '.', '');  ?></b></td>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;text-align:center;"><b><?php  echo number_format((float)($inTot), 2, '.', ''); ?></b></td>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;">&nbsp;</td>
					</tr>
			</tbody>
		</table>
		
		
		
	</div>
</div>