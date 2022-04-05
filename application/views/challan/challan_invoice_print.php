<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto; font-size:12px;">
		<div style="border:0px solid black;">
				<div style="width:100%;float:left;">
					<table style="font-size:12px;border-collapse: collapse;border-top:1.5px solid gray;" >
						
						<?php
							$net_total = 0;
							$i=1;
							foreach($challanInfoProduct as $challanProduct){ 
								$net_total = $net_total + $challanProduct['net_total'];
								
								$mgfDate  = new DateTime($challanProduct['batch_mfg_date']);
								$expDate = new DateTime($challanProduct['batch_exp_date']);
								$freight_charge = $challanProduct['freight_charges'];	
						?>		
						<?php
							if(empty($ordersInfo->currency_html)){
								$ordersInfo->currency_html='<img src="'.base_url().'/assets/img/rupee.png" style="width:6px;">';
							}
						?>
							
							
							<tr class="prtr">
								<td  style="width:30px;border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" ><?php echo $i; ?></td>
								<td  style="width:360px;border-top:1.5px solid gray;border-right:1.5px solid gray;"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?><br>
									<i>Batch</i> : <?php echo $challanProduct['batch_no']; ?><br>
									<i>Mfg Dt</i> :  <?php echo dateFormat('m-Y', $challanProduct['batch_mfg_date']); ?> <br>
									<i>Expiry</i>  :  <?php echo dateFormat('m-Y', $challanProduct['batch_exp_date']); ?>
								</td>
								<td align="center" style="width:100px;border-top:1.5px solid gray;border-right:1.5px solid gray;"><?php echo $challanProduct['pro_hsn']; ?></td>
								
								<td align="center" style="width:74px;border-top:1.5px solid gray;border-right:1.5px solid gray;"><?php echo $challanProduct['qty']; ?></td>
								<td align="center" style="width:100px;border-top:1.5px solid gray;border-right:1.5px solid gray;"><?php echo $ordersInfo->currency_html; ?>&nbsp;<?php echo number_format((float)$challanProduct['rate'], 2, '.', ''); ?></td>
								<td align="center" style="width:50px;border-top:1.5px solid gray;border-right:1.5px solid gray;"><?php echo $challanProduct['pro_unit']; ?></td>
								
								<td style="width:140px;border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"><?php echo $ordersInfo->currency_html; ?>&nbsp;<?php echo number_format((float)$challanProduct['net_total'], 2, '.', ''); ?></td>							
							</tr>
						
						<?php $i++; } ?>
						
						<tr class="ftr">												
							<td  style="width:30px;border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" >&nbsp;</td>
							<td  style="width:360px;border-top:1.5px solid gray;border-right:1.5px solid gray;text-align:right;"><b><i>FREIGHT CHARGES EXPORT GST</i></b></td>
							<td style="border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;text-align:center;" >90185090</td>							
							<td align="center" style="width:74px;border-top:1.5px solid gray;border-right:1.5px solid gray;">&nbsp;</td>
							<td align="center" style="width:100px;border-top:1.5px solid gray;border-right:1.5px solid gray;">&nbsp;</td>
							<td align="center" style="width:50px;border-top:1.5px solid gray;border-right:1.5px solid gray;">&nbsp;</td>
							
							<td style="width:140px;border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"><?php echo $ordersInfo->currency_html; ?>&nbsp; 
						<span id="freight_charge"><?php echo number_format((float)$freight_charge, 2, '.', ''); ?></span></td>	
						</tr>
						<!--<tr class="nettottr">
							<td  style="border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" colspan="6" align="right" ><b>Net Total</b></td>
							<td  style="border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; <span id="net_total"><?php echo number_format((float)$net_total, 2, '.', ''); ?></span></td>
						</tr>
						<tr class="ftr">
							<td style="border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" colspan="6" align="right" ><b>Freight Charges</b></td>
							<td style="border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; 
							<span id="freight_charge"><?php echo number_format((float)$freight_charge, 2, '.', ''); ?></span></td>
						</tr> -->
								 <?php
									/* if(($ordersInfo->currency == 'INR') && ($customerInfo->countryId == '99')){
										if($productgst){ 
										$totwithgst = 0;
										
										foreach($productgst as $progst){									
										$totwithgst = $totwithgst + $progst['gst_total_amount'];  */
								?>
							
								<!-- <tr>
									<td style="border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" colspan="6" align="right" ><b>GST @ <?php echo $progst['gst_rate']; ?>%</b></td>
									<td style="border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; <?php echo number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?></td>
								</tr> -->
							<?php //} ?>
							<?php //} ?>
							<?php //} ?> 
							
						<tr class="grndtr">
							<td style="border-left:1.5px solid gray;border-top:1.5px solid gray;border-right:1.5px solid gray;" colspan="6" align="right" ><b>Total</b></td>
							<td style="border-top:1.5px solid gray;border-right:1.5px solid gray;" align="right"> <b><?php echo $ordersInfo->currency_html; ?>&nbsp; <span id="grand_total"><?php echo number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', ''); ?></span></b></td>
						</tr>
					</table>
				</div>
		</div>
		
		
		<div style="width:100%;float:left;border-bottom:1.5px solid gray;border-top:1.5px solid gray;border-left:1.5px solid gray;border-right:1.5px solid gray;padding-left:3px;font-size:11px;">
			<div style="width:93%;float:left;margin-top:3px;">Amount Chargeable (in words)</div><div style="float:right;margin-top:3px;"><i>E.& O.E</i></div>
			<div style="width:100%;float:left;"><b>
			<?php 
				$grand_total = number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', '');
				echo $ordersInfo->currency.' '.numberTowords($grand_total);
			?></b></div>
			<div style="width:100%;float:left;height:0px;">&nbsp;</div>
			<div style="width:47%;float:left;">&nbsp;</div><div style="float:right;">Company's Bank Details </div>
			<div style="width:47%;float:left;"> &nbsp; </div><div style="float:left;">Bank Name : <b><?php echo $bankInfo->bank_name; ?></b> - <?php echo $bankInfo->account_number; ?> </div>
			<div style="width:47%;float:left;font-size:9px;"><i>Remarks:</i></div><div style="float:right;">A/c No   : <b><?php echo $bankInfo->account_number; ?></b></div>
			<div style="width:47%;float:left;">EWAY BILL # <?php echo $challanInfo->docket_no; ?></div><div style="float:right;">Branch & IFS Code    : <b><?php echo $bankInfo->ifsc_code; ?></b></div>
			<div style="width:47%;float:left;border-right:1.5px solid gray;">Company's PAN/ IEC Code : ACBPJ0823B 068900813 </br>
				<div >Declaration</div>
				<div>We declare that this invoice shows the actual price of the goods </div>
				<div>described and that all particulars are true and correct.</div>
			</div>
					
			<div style="float:right;border-top:1.5px solid gray;text-align:right;">for Tarun Enterprises<br><br><br>Authorised Signatory</div>
			
		</div>
		<div style="width:100%;float:left;padding-left:3px;font-size:11px;text-align:center;margin-top:3px;">SUBJECT TO ALLAHABAD JURISDICTION	</div>
		<!-- <div style="width:100%;float:left;padding-left:3px;font-size:11px;text-align:center;margin-top:3px;">This is a Computer Generated Invoice</div> -->
		
		
</div>
<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>