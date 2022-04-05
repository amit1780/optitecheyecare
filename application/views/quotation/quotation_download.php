<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto; font-size:12px;">	
	<div style="width:100%;padding-top:30px;padding-bottom:50px;">
		<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
	</div>	
	<div style="width:90%;float:left;font-size:15px;text-align:center;">Quotation / Performa Invoice</div>
	<div style="width:10%;float:left;"><b style="font-size:18px;"><?php echo str_pad($quotationInfo->quote_id, 6, "Q-00000", STR_PAD_LEFT); ?></b></div>
</div> -->

<div style="padding-right: 25px;padding-left: 25px;font-size:12px;padding-bottom: 50px;">	
	<div style="border: 0px solid black;padding-top:-1px;">	
		
			<div style="border-right: 2px solid black;width: 50%;float:left;padding:3px;border-left:2px solid black;">
				<div style="width:100%;float:left;"><b>Exporter:</b></div>
				<div style="width:100%;float:left;"><b>TARUN ENTERPRISES</b></div>
				<div style="width:100%;float:left;"><?php echo $quotationInfo->store_address; ?> </div>
				<div style="width:100%;float:left;">Phone: <?php echo $quotationInfo->store_phone; ?></div>
				<div style="width:100%;float:left;">Email: <?php echo $quotationInfo->store_email; ?></div>
				<div style="width:100%;float:left;">GST No: <?php echo $quotationInfo->store_gst_no; ?></div>
				<?php if($quotationInfo->store_name == 'Allahabad'){  ?>
					<div style="width:100%;float:left;">Drug Licence: <?php echo $quotationInfo->drug_licence_no; ?></div>
					<div style="width:100%;float:left;">Dt. <?php echo $quotationInfo->drug_date; ?></div>
				<?php } else { ?>
					<div style="width:100%;float:left;">&nbsp;</div>
					
				<?php } ?>				
			</div>		
			
			<div style="width: 48.6%;float:left;">
				<div>
					<div style="border-right:2px solid black; border-bottom:2px solid black; width: 48%;float:left;padding:3px;height:38px;">
						<div style="width:100%;float:left;"><b>Quotation No:</b></div>
						<div style="width:100%;float:left;"><?php echo getQuotationNo($quotationInfo->quote_id); ?></div>
					</div>
					<div style="border-bottom:2px solid black;float:left;padding:3px;height:38px;border-right:2px solid black;">
						<div style="width:100%;float:left;"><b>Quotation Date:</b></div>											
						<div style="width:100%;float:left;"><?php echo dateFormat('F, d, Y',$quotationInfo->quotation_date);  ?></div>
					</div>
				</div>
				<div>
					<div style="border-right:2px solid black; border-bottom:2px solid black;width: 48%;float:left;padding:3px;height:38px;">
						<div style="width:100%;float:left;"><b>Issued From:</b></div>
						<div style="width:100%;float:left;"><?php echo $quotationInfo->store_name; ?></div>
						
					</div>
					<div style="border-bottom:2px solid black;float:left;padding:3px;height:38px;border-right:2px solid black;">
						<div style="width:100%;float:left;"><b>Currency:</b></div>
						<div style="width:100%;float:left;"><?php echo $quotationInfo->currency; ?></div>
						
					</div>
				</div>
				<div>
					<div style="border-right:2px solid black;width: 48%;float:left;padding:3px;height:39px;">
						<div style="width:100%;float:left;"><b>Insurance:</b></div>
						<div style="width:100%;float:left;"><?php echo $quotationInfo->insurance; ?></div>
					</div>
					<div style="float:left;padding:3px;height:39px;border-right:2px solid black;">
						<div style="width:100%;float:left;"><b>Sales Person:</b></div>
						<div style="width:100%;float:left;"><?php echo $quotationInfo->firstname .' '.$quotationInfo->lastname; ?></div>
					</div>
				</div>
			</div>	
		
		<div  style="border-left:2px solid black;border-top:2px solid black;border-right:2px solid black;width: 50%;float:left;padding:3px;">
			<div style="width:100%;float:left;"><b>Customer(Bill to):</b></div>
			<div style="width:100%;float:right;">				
				<?php $billingAddress=nl2br($quotationInfo->billing_details);
					while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
						print "<b>$matcher[1]</b>";
						$billingAddress=after($matcher[0],$billingAddress);
						break;
					}						?>
				<?php echo $billingAddress; ?>				
			</div>			
			<?php if($customerInfo->gst){ ?>
			<div style="width:100%;float:left;">GST No.: <?php echo $customerInfo->gst ; ?></div>
			<?php } ?>
			<?php if($customerInfo->company_registration_no){ ?>
			<div style="width:100%;float:left;">Reg. No.: <?php echo $customerInfo->company_registration_no ; ?></div>
			<?php } ?>	
			<?php if($customerInfo->drug_licence_no){ ?>
			<div style="width:100%;float:left;">Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></div>
			<?php } ?>
		</div>
		
		<div style="border-top:2px solid black;float:left;padding:3px;border-right:2px solid black;">
			<div style="width:100%;float:left;"><b>Consingee(Ship to):</b></div>					
			<div style="width:100%;float:right;">
				<?php $shippingAddress=nl2br($quotationInfo->shipping_details);
					while(preg_match("/(.*?)\n/is",$shippingAddress,$matcher)){
						print "<b>$matcher[1]</b>";
						$shippingAddress=after($matcher[0],$shippingAddress);
						break;
					}						?>
				<?php echo $shippingAddress; ?>
			</div>			
			<?php if($customerInfo->gst){ ?>
			<div style="width:100%;float:left;">GST No.: <?php echo $customerInfo->gst ; ?></div>
			<?php } ?>
			<?php if($customerInfo->company_registration_no){ ?>
			<div style="width:100%;float:left;">Reg. No.: <?php echo $customerInfo->company_registration_no ; ?></div>
			<?php } ?>
			<?php if($customerInfo->drug_licence_no){ ?>
			<div style="width:100%;float:left;">Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></div>
			<?php } ?>
		</div>
		<?php
			$delivery = str_word_count($quotationInfo->delivery);
			$payment_terms = str_word_count($quotationInfo->payment_terms);
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
		<div style="width: 100%;float:left;border-left:2px solid black;border-top:2px solid black;border-right:2px solid black; border-bottom:0px solid black;">
			<div>
				<div style="width: 50.3%;float:left;border-right:<?php echo $x; ?>px solid black;padding:3px;">
					<div style="width:100%;float:left;"><b>Terms of Delivery:</b> <?php echo $quotationInfo->delivery; ?></div>					
				</div>
				<div style="float:left;padding:3px;border-left:<?php echo $y; ?>px solid black;">
					<div style="width:100%;float:left;"><b>Terms of Payments:</b> <?php echo $quotationInfo->payment_terms; ?> </div>					
				</div>
			</div>
		</div>		
		<div style="width: 100%;float:left;border-right:2px solid black;border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;padding:3px;">
			<div style="width:100%;float:left;"><b>Terms & Conditions:</b> <?php echo $quotationInfo->terms_conditions; ?> </div>			
		</div>
		
		<div style="width: 100%;float:left;border-right:2px solid black;border-left:2px solid black;border-top:0px solid black;border-bottom:2px solid black;padding:3px;">
			<div style="width:100%;float:left;"><b>Special instruction:</b> <?php echo $quotationInfo->special_instruction; ?> </div>			
		</div>
		
		<div style="width:100%;float:left;">
			<table style="font-size:12px;border-collapse: collapse;" >
				<tr>
					<th style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black; width:4%;">Sl No</th>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '40.3%'; } else { '46.3%'; } ?>;">Product Description</th>					
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:7%;">HSN<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '-GST'; ?><?php } ?></th>
					<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ ?>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:6%;">MRP</th>
					<?php } ?>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:6%;">Qty</th>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:6%;">Unit</th>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:6%;">Rate</th>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;width:9%;">Discount/Unit</th>
					<th style="border-bottom:2px solid black;border-right:2px solid black;width:8.5%;" align="right">Net&nbsp;Amount</th>
				</tr>
				
				<?php
					$net_total = 0;
					$i=1;
					foreach($quoteProductInfo as $productInfo){ 
					$net_total = $net_total + $productInfo['net_amount'];					
				?>
				
				<tr>
					<td style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;"><?php echo $i; ?></td>
					<td style="border-bottom:2px solid black;border-right:2px solid black;"><b><?php echo $productInfo['model_name']; ?></b> | <?php echo $productInfo['description']; ?></td>					
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $productInfo['hsn']; ?><?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '<br>'.$productInfo['product_gst']; ?> %<?php } ?></td>
					<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ ?>
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $productInfo['mrp']; ?></td>
					<?php } ?>
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $productInfo['qty']; ?></td>
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $productInfo['unit']; ?></td>
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo round((float)$productInfo['rate'], 2); //number_format((float)$productInfo['rate'], 4, '.', ''); ?></td>
					<td align="center"  style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo round((float)$productInfo['discount'], 2); ?></td>
					<td  style="border-bottom:2px solid black;border-right:2px solid black;" align="right"><?php echo round((float)$productInfo['net_amount'], 2); ?></td>
				</tr>
					
				<?php $i++; } ?>
				<?php
					if(empty($quotationInfo->currency_html)){
						$quotationInfo->currency_html='<img src="'.base_url().'/assets/img/rupee.png" style="width:6px;">';
					}
				?>
				<tr>
					<th  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" >Net Total</th>
					<td  style="border-bottom:2px solid black;border-right:2px solid black;" align="right">  <?php echo $quotationInfo->currency_html; ?>&nbsp;<?php echo round((float)$net_total, 2); //number_format((float)$net_total, 2, '.', ''); ?></td>
				</tr>
				<tr>
					<th  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" >Freight Charges</th>
					<td  style="border-bottom:2px solid black;border-right:2px solid black;" align="right"><?php echo $quotationInfo->currency_html; ?>&nbsp;<?php echo round((float)$quotationInfo->freight_charge, 2); //number_format((float)$quotationInfo->freight_charge, 2, '.', ''); ?></td>
				</tr>
				<?php
					if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){
					#if($quotationInfo->currency == 'INR'){
					if($productgst){ 
					$totwithgst = 0;
					$freight_charge = $quotationInfo->freight_charge;
					$freight_gst = $quotationInfo->freight_gst;
					$flagFreightGST=1;# set 0 if GST% of freight charge is in the list of products.
					#i.e to cheate the row for GST @ 18% (Freight GST)
					foreach($productgst as $progst){									
						/*$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
						$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
						$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);	
						$totgst = number_format((float)$totgst, 2, '.', '');
						$totwithgst = $totwithgst + $totgst; */
						$perProFrchWthGst=0;
						if($freight_gst==0){
							$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
							$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
						}else if(!empty($freight_gst)){
							if($freight_gst==$progst['product_gst']){
								$perProFrchWthGst = ($freight_charge * $freight_gst)/100;
								$flagFreightGST=0;
							}
						}
						$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);
						$totgst = number_format((float)$totgst, 2, '.', '');
						$totwithgst = $totwithgst + $totgst;
				?>
				<tr>
					<th  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" >GST @ <?php echo $progst['product_gst']; ?>%</th>
					<td  style="border-bottom:2px solid black;border-right:2px solid black;" align="right"><?php echo $quotationInfo->currency_html; ?>&nbsp;<?php echo round((float)$totgst, 2); //number_format((float)$totgst, 2, '.', ''); ?></td>
				</tr>
				<?php } ?>
				
				    <?php if($flagFreightGST==1 && $freight_gst>0){ 
						$perProFrchWthGst = ($freight_charge * $freight_gst)/100;
						$totgst = $perProFrchWthGst;
						$totgst = number_format((float)$totgst, 2, '.', '');
						$totwithgst = $totwithgst + $totgst;
					?>
						<tr>
							<td style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>GST @ <?php echo $freight_gst; ?>%</b></td>
							<td style="border-bottom:2px solid black;border-right:2px solid black;" class="border_right border_top" align="right"> <i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$totgst, 2); //number_format((float)$totgst, 2, '.', ''); ?></td>
						</tr>
					<?php } ?>
				
				<?php } ?>
				<?php } ?>
				
				<?php
					//number_format((float)($net_total + $quotationInfo->freight_charge + $totwithgst), 2, '.', '');
					$grandTotal = (float)($net_total + $quotationInfo->freight_charge + $totwithgst);
				?>
				
				<tr>
					<th  style="border-left:2px solid black;border-bottom:2px solid black;border-right:2px solid black;" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" >Grand Total</th>
					<th  style="border-bottom:2px solid black;border-right:2px solid black;" align="right"> <?php echo $quotationInfo->currency_html; ?>&nbsp;<?php echo round((float)$grandTotal, 2); ?></th>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
			<!-- <p style="margin: 0px;">Thank you for your interest in our company and products. We trust you will find the quote</p> 
			<p style="margin: 0px;">satisfactory. We look forward to your business.</p> -->
			<p style="margin: 0px;text-align: justify;">Thank you for your interest in our range of equipment / supplies. We with pleasure offer the quotation as above for your kind consideration. We shall be happy to answer any of your questions in this regard. Banking details are as below.</p>
		</div>					
	</div>
	<br>
	<div class="row">
			<div class="col-sm-12" style="width:100%;padding-right: 0px;padding-left: 0px;">
				<p style="margin: 0px;">Remit to:</p>								
			</div>
			
			<div class="col-sm-6" style="width:50%;float:left;padding-right: 0px;padding-left: 0px;">				
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:40%;float:left;"><b>Payment :</b></p><p style="margin: 0px;float:left;">100% T/T(wire)</p>
				</div>
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:40%;float:left;"><b>Beneficiary's Name :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->beneficiary_name; ?></p>
				</div>
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:40%;float:left;"><b>Bank Name :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_name; ?></p>
				</div>
									
			</div>

			<div class="col-sm-6" style="width:48%;float:right;padding-right: 0px;padding-left: 0px;">
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:40%;float:left;"><b>Bank Details for :</b></p><p style="margin: 0px;float:left;"> (<?php echo $quotationInfo->currency; ?>)</p>
				</div>
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:40%;float:left;"><b>Account No. :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->account_number; ?></p>
				</div>
				
				<?php if($quotationInfo->currency == 'INR'){ ?>
					<?php if(!empty($bankInfo->ifsc_code)){ ?>
					<div style="width:100%;float:left;">
						<p style="margin: 0px;width:40%;float:left;"><b>IFSC Code :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->ifsc_code; ?></p>
					</div>
					<?php } ?>
				<?php } else { ?>
					<?php if(!empty($bankInfo->swift_code)){ ?>
					<div style="width:100%;float:left;">
						<p style="margin: 0px;width:40%;float:left;"><b>SWIFT Code :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->swift_code; ?></p>
					</div>
					<?php } ?>
				<?php } ?>				
			</div>	
			
			<div class="col-sm-12" style="width:100%;float:left;padding-right: 0px;padding-left: 0px;">				
				<div style="width:100%;float:left;">
					<p style="margin: 0px;width:20%;float:left;"><b>Bank Address :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_address; ?></p>
				</div>									
			</div>
			
			
			<div class="col-sm-12" style="width:100%;float:left;padding-right: 0px;padding-left: 0px;margin-top:50px;">				
				<div style="width:100%;float:left;">
				    <p style="margin: 0px;"><b>Bank remittance charge shall be paid by payer(buyer)</b></p><br>
					<p style="margin: 0px;float:left;">For Tarun Enterprises</p>
				</div>									
			</div>
			
			

			
	</div>
</div>
<div style="padding-right: 25px;padding-left: 25px;font-size:12px;">
	<div class="col-sm-12" style="width:100%;float:left;padding-right: 0px;padding-left: 0px;font-size:11px;">				
		<div style="width:100%;float:left;">
			<?php
				$created_time = dateFormat("Y-m-d", $quotationInfo->created_time);
				
				if($quotationInfo->valid_for){
					$valid_date = $quotationInfo->valid_for;
				} else {
					$valid_date = 45;
				}
				$valid_for = date('d-m-Y', strtotime($created_time ."+".$valid_date." days"));
				$valid_for = dateFormat("d-m-Y", $valid_for);
			?>
			<p style="margin: 0px;float:left;">Note - This quotation is valid  up to <?php echo $valid_for; ?> | Document created by - <?php echo $quotationInfo->created_user; ?></p>
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