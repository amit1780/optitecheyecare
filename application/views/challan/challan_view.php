<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
			</div>
			 <div class="col-sm-6">
				<div class="float-right">
				<?php if($challanInfo->is_deleted == 'N'){ ?>
					<a href="<?php echo site_url('dispatchNote'); ?>/<?php echo $challanInfo->challan_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Dispatch Note"> <i class="far fa-sticky-note"></i></a> &nbsp; 
					
					
					
					<?php if(!(($ordersInfo->currency == 'INR') && ($customerInfo->country_id == '99'))){ ?>
					<a href="<?php echo site_url('sli/createSli'); ?>?challan_id=<?php echo $challanInfo->challan_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php if(!empty($challanInfo->sli_id)){ echo 'Print Sli'; }else{ echo "Create SLI"; } ?>"> <i class="fas fa-plus"></i></a> &nbsp;
					<?php } ?>

					&nbsp; <a href="<?php echo site_url('challanPrint'); ?>/<?php echo $challanInfo->challan_id; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="top" title="Challan Print"> <i class="fas fa-print"></i></a> &nbsp;
					
					<a href="#" class="btn btn-primary" id="mailbox" data-toggle="tooltip" data-placement="top" title="Email"><i class="fas fa-envelope"></i></a> &nbsp;

					<a href="<?php echo site_url('challan/downloadPdf'); ?>?challan_id=<?php echo $challanInfo->challan_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> &nbsp; 
				<?php } ?>
				</div>
			</div> 	
		</div>
	</div>
	
	<?php if(isset($success)){ ?>
		<div class="alert alert-success">
		  <?php echo $success; ?>
		</div>
	<?php } ?>
	
	<style>
		.quote_view p{margin-bottom:0px;}		
		.borderbox{border:2px solid black;}
		.quote_view .border_left{border-left:2px solid black;}
		.quote_view .border_right{border-right:2px solid black;}
		.quote_view .border_bottom{border-bottom:2px solid black;}
		.quote_view .border_top{border-top:2px solid black;}
		
		table {
			table-layout:fixed;
		}
		
		.table-bordered td{
			border: 0px solid black;			
		}
		
		.space_bottom{margin-bottom:15px;}
		.card{border: 0px solid rgba(0,0,0,.125);}
	</style>
	
	<div class="card mb-3">	
		<div class="card-body">
			<?php if($challanInfo->is_deleted == 'Y'){ ?>
				<h3 style="text-align:center;">Challan Deleted</h3>
			<?php } else { ?>
			<h3 style="text-align:center;"><div style="font-size: 15px;float: left;margin-left: -15px;" >Outstanding Balance : <b><?php echo $outstand_balance; ?></b></div>DISPATCH CHALLAN From <?php echo $challanInfo->store_name; ?></h3>
			<div class="row quote_view borderbox">				
				<!-- <div class="col-sm-12 justify-content-center">
					<div style="text-align:center;">
						
						<p><b>TARUN ENTERPRISES</b></p>
						<p><?php echo $challanInfo->store_address; ?></p>
						<p>Phone: <?php echo $challanInfo->store_phone; ?></p>
						<p>Email: <?php echo $challanInfo->store_email; ?></p>
						<p>GST No: <?php echo $challanInfo->store_gst_no; ?>
						<?php if($challanInfo->store_name == 'Allahabad'){  ?>
							Drug Licence: <?php echo $challanInfo->drug_licence_no; ?> Dt. <?php echo $challanInfo->drug_date; ?>
						<?php } ?></p>
					</div>
				</div> -->	
				
				<div class="col-sm-6  border_right">
					<p><b>Bill to:</b></p>
					<?php $billingAddress=nl2br($challanInfo->billing_details);
						while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
							print "<b>$matcher[1]</b>";
							$billingAddress=after($matcher[0],$billingAddress);
							break;
						}						?>
					<?php echo $billingAddress; ?>
					
					<?php if($customerInfo->gst){ ?>
					<p>GST No.: <?php echo $customerInfo->gst; ?></p>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<p>Reg. No.: <?php echo $customerInfo->company_registration_no; ?></p>
					<?php } ?>
					<?php if($customerInfo->drug_licence_no){ ?>
					<p>Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></p>
					<?php } ?>	
				</div>
				
				<div class="col-sm-6 ">
					<p><b>Ship to:</b></p>
					<?php $shippingAddress=nl2br($challanInfo->shipping_details);
						while(preg_match("/(.*?)\n/is",$shippingAddress,$matcher)){
							print "<b>$matcher[1]</b>";
							$shippingAddress=after($matcher[0],$shippingAddress);
							break;
						}						?>
					<?php echo $shippingAddress; ?>					
					
					<?php if($customerInfo->gst){ ?>
					<p>GST No.: <?php echo $customerInfo->gst; ?></p>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<p>Reg. No.: <?php echo $customerInfo->company_registration_no; ?></p>
					<?php } ?>
					<?php if($customerInfo->drug_licence_no){ ?>
					<p>Drug Licence no.: <?php echo $customerInfo->drug_licence_no; ?></p>
					<?php } ?>	
				</div>
				
				<div class="col-sm-6 border_top border_right border_bottom">					
					<p style=""><b style="width:40%;float:left;">Challan No.</b> <?php echo getChallanNo($challanInfo->challan_id); ?> </p>						
				</div>
				
				<div class="col-sm-6 border_top border_bottom">
					<p style=""><b style="float:left;width:40%;">Invoice No:</b> <?php echo $challanInfo->invoice_no; ?></p>	
				</div>
				
				<div class="col-sm-6  border_right border_bottom">					
					<p style=""><b style="float:left;width:40%;">Challan Date:</b> <?php echo dateFormat('F, d, Y', $challanInfo->challan_date); ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom">
					
					<p style=""><b style="float:left;width:40%;">Invoice Date:</b> <?php echo dateFormat('F, d, Y', $challanInfo->invoice_date); ?></p>
				</div>
				
			<?php if($challanInfo->manual_challan_no){ ?>
				<div class="col-sm-6  border_right border_bottom">					
					<p style=""><b style="width:40%;float:left;">Manual Challan No.:</b> <?php echo $challanInfo->manual_challan_no; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom">
					<p style=""><b style="width:40%;float:left;">Manual Challan Date:</b> <?php echo dateFormat('F, d, Y', $challanInfo->manual_challan_date); ?></p>
				</div>
			<?php } ?>
			
				<div class="col-sm-6  border_right border_bottom">					
					<p style=""><b style="width:40%;float:left;">Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom">
					<p style=""><b style="width:40%;float:left;">Method Of Shipment:</b> <?php if($challanInfo->sli_name){ echo $challanInfo->sli_name; }else{ echo $challanInfo->method_of_shipment; } ?> </p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom">					
					<p style=""><b style="width:40%;float:left;">Order No:</b> <?php echo getOrderNo($challanInfo->order_id); ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom">					
					<p style=""><b style="float:left;width:40%;">Date Of Shipment:</b> <?php echo dateFormat('F, d, Y', $challanInfo->date_of_shipment);  ?></p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom">					
					<p style=""><b style="float:left;width:40%;">Sales Person:</b> <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom">							
					<p style=""><b style="float:left;width:40%;">Docket No:</b> <?php echo $challanInfo->docket_no; ?></p>						
				</div>
				
				<div class="col-sm-6 border_right border_bottom">
					<p><b style="float:left;width:40%;">Dispatched From:</b> <?php echo $challanInfo->store_name; ?></p>
					
				</div>
				
				<div class="col-sm-6 border_bottom">
					<p><b style="float:left;width:40%;">SB Number:</b> <?php echo $challanInfo->sb_number; ?></p>							
				</div>
				
				<div class="col-sm-6 border_right border_bottom">
					<p><b style="float:left;width:40%;">Terms of Delivery:</b> <?php echo $ordersInfo->delivery; ?></p>
					
				</div>
				
				<div class="col-sm-6 border_bottom">
					<p><b style="float:left;width:40%;">E-Way Bill:</b> <?php echo $challanInfo->eway_bill; ?></p>							
				</div>
				
				<div class="col-sm-6 border_right ">
					<p><b>Special Information:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->special_instruction; ?></p>
				</div>
				<div class="col-sm-6">
					<p><b>Terms of Payments:</b></p>
					<p style="margin-bottom: 15px;"><?php if($challanInfo->payment_terms){ echo $challanInfo->payment_terms; } ?></p>
				</div>					
				
				<div class="col-sm-12 border_top border_right border_bottom">
					<p><b>Terms & Conditions:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->terms_conditions; ?></p>
				</div>
				
				
				<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
					<tr>
						<th class="border_right" style="border-bottom:2px solid black;border-left:2px solid black;border-right:2px solid black;width:4%;">S.N.</th>
						<th class="border_right" style="width:27%;">Product Description</th>
						<th class="border_right" style="width:7%;text-align:center;">HSN<?php if(($ordersInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '-GST'; ?><?php } ?></th>
						<th class="border_right" style="width:5%;text-align:center;">Unit</th>
						<th class="border_right" style="width:6%;text-align:center;">Qty</th>
						<th class="border_right" style="width:8%;text-align:center;">Rate</th>
						<th class="border_right" style="width:12%;text-align:center;">Batch No</th>									
						<th class="border_right" style="width:12%;text-align:center;">Mfg Dt./Exp Dt.</th>
						<th class="border_right" style="width:8%;text-align:center;">Discount/Unit</th>									
						<th style="text-align:right;">Net Amount</th>	
					</tr>
					
					<?php
						$net_total = 0;
						$i=1;
						foreach($challanInfoProduct as $challanProduct){ 
							$net_total = $net_total + $challanProduct['net_total'];
							
						    $mgfDate  = new DateTime($challanProduct['batch_mfg_date']);
						    $expDate = new DateTime($challanProduct['batch_exp_date']);
							$freight_charge = $challanProduct['freight_charges'];
							$returnTitle='';
							$returnQuantityHtml='';
							if(!empty($challanProduct['return_qty'])){
								$returnTitle=$challanProduct['return_qty']." Quantity returned.";
								$returnQuantityHtml="<br><font color='red'><b>(-".$challanProduct['return_qty'].")</b></font>";
							}
					?>						
						<tr class="prtr">
							<td class="border_right border_top"><?php echo $i; ?></td>
							<td align="left" class="border_right border_top"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>
							<td align="center" class="border_right border_top"><?php echo $challanProduct['pro_hsn']; ?><?php if(($ordersInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '<br>'.$challanProduct['product_gst']; ?> %<?php } ?></td>
							<td align="center" class="border_right border_top"><?php echo $challanProduct['pro_unit']; ?></td>
							<td align="center" class="border_right border_top" title="<?php echo $returnTitle;?>">
								<?php echo $challanProduct['qty']; ?>
								<?php echo $returnQuantityHtml; ?>
							</td>
							<td align="center" class="border_right border_top"><?php echo round((float)$challanProduct['rate'], 2); //number_format((float)$challanProduct['rate'], 4, '.', ''); ?></td>
							<td align="center" class="border_right border_top"><?php echo $challanProduct['batch_no']; ?></td>
							<td align="center" class="border_right border_top"><?php echo dateFormat('m-Y', $challanProduct['batch_mfg_date']); ?>/<?php echo dateFormat('m-Y', $challanProduct['batch_exp_date']); ?></td>
							<td align="center" class="border_right border_top"><?php echo round((float)$challanProduct['discount'], 2); //number_format((float)$challanProduct['discount'], 4, '.', ''); ?></td>
							<td class="border_top" align="right"><?php echo round((float)$challanProduct['net_total'], 2); // number_format((float)$challanProduct['net_total'], 2, '.', ''); ?></td>							
						</tr>
					
					<?php $i++; } ?>					
					<tr class="nettottr">
						<td class="border_right border_top" colspan="9" align="right" ><b>Net Total</b></td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="net_total"><?php echo round((float)$net_total, 2); //number_format((float)$net_total, 2, '.', ''); ?></span></td>
					</tr>
					<tr class="ftr">
						<td class="border_right border_top" colspan="9" align="right" ><b>Freight Charges</b></td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; 
						<span id="freight_charge"><?php echo round((float)$freight_charge, 2); //number_format((float)$freight_charge, 2, '.', ''); ?></span></td>
					</tr>
							<?php
								if(($ordersInfo->currency == 'INR') && ($customerInfo->countryId == '99')){
									if($productgst){ 
										$totwithgst = 0;								
										foreach($productgst as $progst){																
											$totwithgst = $totwithgst + $progst['gst_total_amount'];								
									?>
						
										<tr>
											<td class="border_right border_top" colspan="9" align="right" ><b>GST @ <?php echo $progst['gst_rate']; ?>%</b></td>
											<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$progst['gst_total_amount'], 2); //number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?></td>
										</tr>
									<?php } ?>


								<?php } ?>
							<?php } ?>
						
						<?php
							//number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', '');
							$grandTotal = (float)($net_total + $freight_charge + $totwithgst);
						?>						
					<tr class="grndtr">
						<td class="border_right border_top" colspan="9" align="right" ><b>Grand Total</b></td>
						<td class="border_right border_top" align="right"> <b><i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="grand_total"><?php echo round((float)$grandTotal, 2);  //number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', ''); ?></span></b></td>
					</tr>
				</table>
			</div>			
			<div class="row">
				<div class="col-sm-12" style="padding-left:0px;margin-top:15px;">
					<p style="margin: 0px;">Doc No. TE/F-7.5-07 For Tarun Enterprises | BANK AD CODE: <?php echo $bankInfo->bank_ad_code;  ?></p> 
					<p style="margin: 0px;">Prepared by <?php echo $challanInfo->created_user; ?> | &nbsp;&nbsp;Packed by <?php echo $challanInfo->packer_full_name; ?></p>
				</div>					
			</div>
			<br>
			<div class="row">
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
						<p style="margin: 0px;">Remit to:</p>
					</div>
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Payment :</b></p><p style="margin: 0px;float:left;">100% T/T(wire)</p>
						</div>	
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Beneficiary's Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->beneficiary_name; ?></p>
						</div>
						
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_name; ?></p>
						</div>
						
					</div>
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Details for</b></p><p style="margin: 0px;float:left;"> (<?php echo $ordersInfo->currency; ?>)</p>
						</div>	
						<div style="width:100%;float:left;">	
							<p style="margin: 0px;width:40%;float:left;"><b>Account No.:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->account_number; ?></p>
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
					
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:20%;float:left;"><b>Bank Address :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_address; ?></p>
						</div>										
					</div>				
									
				</div>
			
		</div>	
		<?php } ?>
	</div>	
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="challanMailForm" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="<?php echo $ordersInfo->contact_email; ?>" autocomplete='off'  id="email_to" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">CC :</div>															
							<div class="col-sm-10"> <input type="text" name="email_cc" value=""  id="email_cc" autocomplete='off' class="form-control"></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Subject:</div>															
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Challan / Performa Invoice - <?php echo getChallanNo($challanInfo->challan_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10">
							<textarea class="form-control" rows="7" name="email_massage" id="email_massage">Dear <?php echo $customerInfo->person_title; ?> <?php echo $ordersInfo->contact_person; ?>,

Please find the Order as attached in email bellow.

Thank you,
Optitech Eye Care</textarea>
							</div>
						</div>						
					</div>
					
					<div id="challanfiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">File:</div>															
							<div class="col-sm-10">
								<div id="challanfile"></div>
							</div>
						</div>						
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="sendMail" class="btn btn-primary float-right"> Send Mail</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>

<script>
	$(document).ready(function(){	
		$("#mailbox").click(function(){			
			$.ajax({
				url:'<?php echo site_url('challan/challanSavePdf'); ?>',
				method: 'post',
				data: 'challan_id=<?php echo $challanInfo->challan_id; ?>', 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
				    if(response){						
						var htm = '';
						var hiddentext = '';						
						$.each(response, function(i,res) {
							
							htm += '<a href="<?php echo base_url(); ?>'+ res.challan_file +'" target="_blank" > '+ res.challan_file_name +' </a> &nbsp;';
							
							hiddentext += '<input type="hidden" name="challan_file" value="'+res.challan_file+'">';							
						});						
						$("#challanfile").html(htm);
						
						$("#challanfiletextbox").html(hiddentext); 
					}
					$("#myModal").modal();		
				}
			});				
		});
		
		$("#sendMail").click(function(){		
			var data_form = $('#challanMailForm').serialize();
			$.ajax({
				url:'<?php echo site_url('challanSendMail'); ?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					$("#alert-danger").html('');
					var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
					$("#alert-danger").html(htm);
					setTimeout(function(){
						$("#myModal .close").click();
						$("#alert-danger").html('');
					}, 3000);
				}
			});				
		});	
	});
</script>

<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>