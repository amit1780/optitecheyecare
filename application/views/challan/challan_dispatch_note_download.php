<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto;font-size:12px;">
	
		<!-- <div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div>

			<div style="width:100%;font-size:15px;text-align:center;">DISPATCH NOTE</div> -->
		<div style="border-top:0px solid black;border-left:2px solid black;border-right:2px solid black;margin-top:-16px;"> 
				
				<div style="text-align:center;">							
					<div style="width:100%;">Thank You for valued order.</div>								
				</div>
				
				<div style="width:50.4%;float:left;border-top:2px solid black;border-right:2px solid black;padding-left:3px;">
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
					<div style="width:100%;"><b>Drug Licence no.:</b> <?php echo $customerInfo->drug_licence_no; ?></div>
					<?php } ?>
				</div>
				
				<div style="float:left;border-top:2px solid black;padding-left:3px;">
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
					<div style="width:100%;"><b>Drug Licence no.:</b> <?php echo $customerInfo->drug_licence_no; ?></div>
					<?php } ?>
					
				</div>
				
				<div style="width:50.4%;float:left;border-top: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Challan No.</b> </div> <div style="float:left;padding-left:5px;"> <?php echo getChallanNo($challanInfo->challan_id); ?> </div>						
				</div>						
				<div style="float:left;border-top: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Invoice No:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->invoice_no; ?> </b> </div>
				</div>				
				
				<div style="width:50.4%;float:left;border-top: 0px solid black;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">		
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Challan Date.</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->challan_date); ?></div>						
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">
				
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Invoice Date:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->invoice_date); ?></div>
				</div>
				
				
				
				<?php if($challanInfo->manual_challan_no){ ?>
				<div style="width:50.4%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Manual Challan No.:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->manual_challan_no; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Manual Challan Date:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->manual_challan_date); ?></div>
				</div>
				<?php } ?>
				
				
				
				<div style="width:50.4%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Customer Id:</b>  </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->customer_id; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Method Of Shipment:</b> </div> <div style="float:left;padding-left:5px;">  <?php if($challanInfo->sli_name){ echo $challanInfo->sli_name; }else{ echo $challanInfo->method_of_shipment; } ?> </div>
				</div>
				
				
				
				
				
				<div style="width:50.4%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Order No:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo getOrderNo($challanInfo->order_id); ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Date Of Shipment:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo dateFormat('F, d, Y', $challanInfo->date_of_shipment); ?></div>
				</div>
				
				<div style="width:50.4%;float:left;border-right: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Sales Person:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->firstname; ?><?php echo $challanInfo->lastname; ?></div>					
				</div>						
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">							
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >Docket No:</b> </div> <div style="float:left;padding-left:5px;"><?php echo $challanInfo->docket_no; ?></div>				
				</div>
				
				
				
				<div style="width:50.4%;float:left;border-right:2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b>Dispatched From:</b> </div> <div style="float:left;padding-left:5px;"> <?php echo $challanInfo->store_name; ?></div>							
				</div>
				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >SB Number:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->sb_number; ?></div>							
				</div>
				
				<?php
					$delivery = str_word_count($ordersInfo->delivery);
					$payment_terms = str_word_count($challanInfo->payment_terms);
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
				
				<div style="width:50.4%;float:left;border-right:<?php echo $x; ?>px solid black;padding-left:3px;border-bottom: 2px solid black;">
					<div style="width:100%;"><b>Terms of Delivery : </b> <?php echo $ordersInfo->delivery; ?></div>					
				</div>

				<div style="float:left;border-bottom: 2px solid black;padding-left:3px;">
					<div style="width:40%;float:left;border-right: 1px solid gray;"><b >E-Way Bill:</b> </div> <div style="float:left;padding-left:5px;">  <?php echo $challanInfo->eway_bill; ?></div>
				</div>
				<div style="width:50.4%;float:left;border-right:<?php echo $x; ?>px solid black;padding-left:3px;border-bottom: 2px solid black;">
					<div style="width:100%;"><b>Special Information : </b> <?php echo $ordersInfo->special_instruction; ?></div>
				</div>
				<div style="float:left;padding-left:3px;border-bottom: 2px solid black;border-left:<?php echo $y; ?>px solid black;">
					<div style="width:100%;"><b>Terms of Payments : </b> <?php if($challanInfo->payment_terms){ echo $challanInfo->payment_terms; }  ?></div>					
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
				
				
				
				
				<div style="float:left;padding-left:3px;border-bottom: 2px solid black;border-left:<?php echo $y; ?>px solid black;">
					<div style="width:100%;"><b>Terms & Conditions : </b> <?php echo $ordersInfo->terms_conditions; ?></div>										
				</div>
					
		</div>
		<div style="border:0px solid black;">						
				<div style="width:100%;float:left;">
					<table style="font-size:12px;border-collapse: collapse;" >
						<tr>
							<th style="width:2%;border-bottom:2px solid black;border-left:2px solid black;border-right:2px solid black;">S.N.</th>
							<th style="width:70%;border-bottom:2px solid black;border-right:2px solid black;">Product Description</th>							
							<th style="width:12%;border-bottom:2px solid black;border-right:2px solid black;">Unit</th>
							<th style="width:18%;border-bottom:2px solid black;border-right:2px solid black;">Qty</th>							
						</tr>
						
						<?php
							$net_total = 0;
							$i=1;
							foreach($challanInfoProduct as $challanProduct){ 
								$net_total = $net_total + $challanProduct['net_total'];
								
								$expDate = new DateTime($challanProduct->batch_exp_date);
								$mgfDate = new DateTime($challanProduct->batch_mfg_date);							
						?>						
							
							<tr class="prtr">
								<td style="border-bottom:2px solid black;border-left:2px solid black;border-right:2px solid black;"><?php echo $i; ?></td>
								<td style="border-bottom:2px solid black;border-right:2px solid black;"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>							
								<td style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['pro_unit']; ?></td>
								<td style="border-bottom:2px solid black;border-right:2px solid black;"><?php echo $challanProduct['qty']; ?></td>													
							</tr>
						
						<?php $i++; } ?>					
					</table>
				</div>
			</div>
			<div class="row" style="">
				<div class="col-sm-12" style="padding-left:0px;margin-top:20px;">
					<div style="width:100%;">Doc No. TE/F-7.5-07 For Tarun Enterprises</div> 
					<div style="width:100%;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;<?php echo $challanInfo->lastname; ?>&nbsp;&nbsp;|&nbsp;&nbsp;Packed by  <?php echo $challanInfo->packer_full_name; ?></div>
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
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Details for :</b></p><p style="margin: 0px;float:left;"> (<?php echo $ordersInfo->currency; ?>)</p>
						</div>
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Account No. :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->account_number; ?></p>
						</div>
						
						<?php if($ordersInfo->currency == 'INR'){ ?>
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
			
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">						
						<p style="margin: 0px;">Bank remittance charge shall be paid by payer(buyer)</p><br>
						<p style="margin: 0px;">For Tarun Enterprises</p><br><br>
						<p style="margin: 0px;">Order Processing Team</p><br>					
					</div>					
				</div>		
</div>

<div style="padding-right: 25px;padding-left: 25px;font-size:12px;margin-top:50px;">
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