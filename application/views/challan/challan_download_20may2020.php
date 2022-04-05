<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto; font-size:12px;">
	
		<!-- <div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div>
		<div style="width:90%;float:left;font-size:15px;text-align:center;">DISPATCH CHALLAN From <?php echo $challanInfo->store_name; ?></div><div style="width:10%;float:left;"><b style="font-size:18px;"><?php echo str_pad($challanInfo->challan_id, 6, "C00000", STR_PAD_LEFT); ?></b></div> -->
		
		<div style="border-top:0px solid black;border-left:2px solid black;border-right:2px solid black;margin-top:-16px;">
				<!-- <div class="col-sm-12 justify-content-center">
					<div style="text-align:center;">
						
						<div style="width:100%;"><b>TARUN ENTERPRISES</b></div>
						<div style="width:100%;"><?php echo $challanInfo->store_address; ?> </div>
						<div style="width:100%;">Phone: <?php echo $challanInfo->store_phone; ?></div>
						<div style="width:100%;">Email: <?php echo $challanInfo->store_email; ?></div>
						<div style="width:100%;">GST No: <?php echo $challanInfo->store_gst_no; ?> 
						<?php if($challanInfo->store_name == 'Allahabad'){  ?>
							Drug Licence: ALLD/5/21B/385,ALLD/5/20B/388 Dt. 06.05.2008
						<?php } ?></div>
					</div>
				</div> -->	
				
				<div style="width:50%;float:left;border-top:0px solid black;border-right:2px solid black;padding-left:3px;">
					<div style="width:100%;"><b>Bill to:</b></div>
					<?php $billingAddress=nl2br($challanInfo->billing_details);
						while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
							print "<b>$matcher[1]</b>";
							$billingAddress=after($matcher[0],$billingAddress);
							break;
						}
					?>
					<?php echo $billingAddress; ?>
					
					<?php if($customerInfo->gst){ ?>
					<div style="width:100%;"><b>GST No.:</b> <?php echo $customerInfo->gst; ?></div>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<div style="width:100%;"><b>Reg. No.:</b> <?php echo $customerInfo->company_registration_no; ?></div>
					<?php } ?>
					<?php if($customerInfo->drug_licence_no){ ?>
					<div style="width:100%;">Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></div>
					<?php } ?>	
				</div>
				
				<div style="float:left;border-top:0px solid black;padding-left:3px;">
					<div style="width:100%;"><b>Ship to:</b></div>					
					<?php $shippingAddress=nl2br($challanInfo->shipping_details);
						while(preg_match("/(.*?)\n/is",$shippingAddress,$matcher)){
							print "<b>$matcher[1]</b>";
							$shippingAddress=after($matcher[0],$shippingAddress);
							break;
						}
					?>
					<?php echo $shippingAddress; ?>
					<?php if($customerInfo->gst){ ?>
					<div style="width:100%;">GST No.: <?php echo $customerInfo->gst; ?></div>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<div style="width:100%;">Reg. No.: <?php echo $customerInfo->company_registration_no; ?></div>
					<?php } ?>
					<?php if($customerInfo->drug_licence_no){ ?>
					<div style="width:100%;">Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></div>
					<?php } ?>
				</div>
				
				<div style="width:50%;float:left;border-top: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Challan No.</b> </div> <div style="float:left;padding-left:5px;"> <?php echo getChallanNo($challanInfo->challan_id); ?> </div>						
				</div>						
				<div style="float:left;border-top: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Invoice No:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->invoice_no; ?> </b> </div>
				</div>				
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">
							
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Challan Date.</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->challan_date); ?></div>						
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">
				
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Invoice Date:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->invoice_date); ?></div>
				</div>
				
				
				
				<?php if($challanInfo->manual_challan_no){ ?>
				<div style="width:50%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Manual Challan No.:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->manual_challan_no; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Manual Challan Date:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->manual_challan_date); ?></div>
				</div>
				<?php } ?>
				
				<div style="width:50%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Customer Id:</b>  </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->customer_id; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Method Of Shipment:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->method_of_shipment; ?></div>
				</div>
				
				<div style="width:50%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1x solid gray;"><b >Order No:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo getOrderNo($challanInfo->order_id); ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Date Of Shipment:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->date_of_shipment); ?></div>
				</div>
				
				
				
				
				<div style="width:50%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Sales Person:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->firstname; ?><?php echo $challanInfo->lastname; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">							
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Docket No:</b> </div> <div style="float:left;padding-left:5px;"><?php echo $challanInfo->docket_no; ?></div>				
				</div>
				
				
				
				<div style="width:50%;float:left;border-right:2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Dispatched From:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->store_name; ?></div>							
				</div>
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >SB Number:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->sb_number; ?></div>							
				</div>
				
				<!-- <div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;"> -->
				
				<?php
					$delivery = str_word_count($ordersInfo->delivery);
					$payment_terms = str_word_count($ordersInfo->payment_terms);
					$x=0;
					$y=0;
					if($delivery > $payment_terms){
						$x=2;
					} else if($payment_terms > $delivery) {
						$y=2;
					} else {
						$x = 2;
					}
				?>		
					
				<div style="width:50%;float:left;border-right:<?php echo $x; ?>px solid black;padding-left:3px;">
					<div style="width:100%;"><b>Terms of Delivery : </b> <?php echo $ordersInfo->delivery; ?></div>					
				</div>
				<div style="float:left; border-left:<?php echo $y; ?>px solid black; padding-left:3px;">
					<div style="width:100%;"><b>Terms of Payments : </b> <?php echo $challanInfo->payment_terms; ?></div>					
				</div>
				
				<?php
					$terms_conditions = str_word_count($ordersInfo->terms_conditions);
					$special_instruction = str_word_count($ordersInfo->special_instruction);
					$x=0;
					$y=0;
					if($terms_conditions > $special_instruction){
						$x=2;
					} else if($special_instruction > $terms_conditions) {
						$y=2;
					} else {
						$x = 2;
					}
				?>		
				
				<div style="width:50%;float:left;border-right:<?php echo $x; ?>px solid black;padding-left:3px;border-top:2px solid black;border-bottom:0px solid black;">
					<div style="width:100%;"><b>Terms & Conditions : </b> <?php echo $ordersInfo->terms_conditions; ?></div>					
				</div>
				<div style="float:left;padding-left:3px; border-left:<?php echo $y; ?>px solid black; border-top:2px solid black;border-bottom:0px solid black;">
					<div style="width:100%;"><b>Special Information : </b> <?php echo $ordersInfo->special_instruction; ?></div>					
				</div>					
				
		</div>
		<div style="border:0px solid black;">
				<div style="width:100%;float:left;">
					<table style="font-size:12px;border-collapse: collapse;border-top:2px solid black;" >
						<tr>
							<th  style="width:4%;border-bottom:2px solid black;border-left:2px solid black;border-right:2px solid black;">S.N.</th>
							<th  style="width:25%;border-bottom:2px solid black;border-right:2px solid black;">Product Description</th>
							<th  style="width:7%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">HSN</th>
							<th  style="width:5%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Unit</th>
							<th  style="width:6%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Qty</th>
							<th  style="width:8%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Rate</th>
							<th  style="width:12%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Batch No</th>									
							<th  style="width:7%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Mfg Dt./Exp Dt.</th>
							<th  style="width:8%;border-bottom:2px solid black;border-right:2px solid black;text-align:center;">Discount/Unit</th>									
							<th style="width:18%;border-bottom:2px solid black;border-right:2px solid black;text-align:right;">Net Amount</th>	
						</tr>
						
						<?php
							$net_total = 0;
							$i=1;
							foreach($challanInfoProduct as $challanProduct){ 
								$net_total = $net_total + $challanProduct['net_total'];
								
								$mgfDate  = new DateTime($challanProduct['batch_mfg_date']);
								$expDate = new DateTime($challanProduct['batch_exp_date']);
								$freight_charge = $challanProduct['freight_charges'];	
						?>						
							
							<tr class="prtr">
								<td  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" ><?php echo $i; ?></td>
								<td  style="border-bottom:2px solid black;border-right:2px solid black;"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['pro_hsn']; ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['pro_unit']; ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['qty']; ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo number_format((float)$challanProduct['rate'], 4, '.', ''); ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['batch_no']; ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo dateFormat('m-Y', $challanProduct['batch_mfg_date']); ?>/<?php echo dateFormat('m-Y', $challanProduct['batch_exp_date']); ?></td>
								<td align="center" style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo number_format((float)$challanProduct['discount'], 4, '.', ''); ?></td>
								<td style="border-bottom:2px solid black;border-right:2px solid black;" align="right"><?php echo number_format((float)$challanProduct['net_total'], 2, '.', ''); ?></td>							
							</tr>
						
						<?php $i++; } ?>
						<?php
							if(empty($ordersInfo->currency_html)){
								$ordersInfo->currency_html='<img src="'.base_url().'/assets/img/rupee.png" style="width:6px;">';
							}
						?>
						<tr class="nettottr">
							<td  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="9" align="right" ><b>Net Total</b></td>
							<td  style="border-bottom:2px solid black;border-right:2px solid black;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; <span id="net_total"><?php echo number_format((float)$net_total, 2, '.', ''); ?></span></td>
						</tr>
						<tr class="ftr">
							<td style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="9" align="right" ><b>Freight Charges</b></td>
							<td style="border-bottom:2px solid black;border-right:2px solid black;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; 
							<span id="freight_charge"><?php echo number_format((float)$freight_charge, 2, '.', ''); ?></span></td>
						</tr>
								<?php
									if(($ordersInfo->currency == 'INR') && ($customerInfo->countryId == '99')){
										if($productgst){ 
										$totwithgst = 0;
										
										foreach($productgst as $progst){									
										$totwithgst = $totwithgst + $progst['gst_total_amount'];
								?>
							
								<tr>
									<td style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="9" align="right" ><b>GST @ <?php echo $progst['gst_rate']; ?>%</b></td>
									<td style="border-bottom:2px solid black;border-right:2px solid black;" align="right"> <?php echo $ordersInfo->currency_html; ?>&nbsp; <?php echo number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?></td>
								</tr>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							
						<tr class="grndtr">
							<td style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="9" align="right" ><b>Grand Total</b></td>
							<td style="border-bottom:2px solid black;border-right:2px solid black;" align="right"> <b><?php echo $ordersInfo->currency_html; ?>&nbsp; <span id="grand_total"><?php echo number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', ''); ?></span></b></td>
						</tr>
					</table>
				</div>
		</div>
			<div class="row" style="margin-top:20px;">
				<div class="col-sm-12" style="padding-left: 0px;">
					<div style="width:100%;">Doc No. TE/F-7.5-07 For Tarun Enterprises | BANK AD CODE: <?php echo $bankInfo->bank_ad_code;  ?></div> 
					<div style="width:100%;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?>|&nbsp;&nbsp;Packed by <?php echo $challanInfo->packer_full_name; ?></div>
				</div>					
			</div>
</div>

<div style="padding-right: 25px;padding-left: 25px;font-size:12px;margin-top:100px;">
	<div class="col-sm-12" style="width:100%;float:left;padding-right: 0px;padding-left: 0px;font-size:11px;">				
		<div style="width:100%;float:left;">
			<p style="margin: 0px;float:left;">This is a computer-generated document. No signature is required.</p>
		</div>									
	</div>
</div>
<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>