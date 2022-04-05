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
				<?php if($quotationInfo->is_deleted == 'N'){ ?>
					<?php if(empty($quotationInfo->order_id)){ ?>
						<a href="<?php echo site_url('editQuotation'); ?>/<?php echo $quotationInfo->quote_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a> &nbsp;
						<a href="<?php echo site_url('order'); ?>?quotation_id=<?php echo $quotationInfo->quote_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Generate Order"> <i class="fas fa-plus"></i></a>&nbsp;
					<?php } ?>					
						<a href="#" class="btn btn-primary" id="mailbox" data-toggle="tooltip" data-placement="top" title="Email"><i class="fas fa-envelope"></i></a> &nbsp;					
						<a href="<?php echo site_url('quotation/downloadPdf'); ?>?quotation_id=<?php echo $quotationInfo->quote_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download"> <i class="fas fa-download"></i></a> &nbsp; 
				<?php } ?>
				</div>
			</div>
		</div>
	</div>	
	<style>
		.quote_view p{margin-bottom:0px;}
		
		.borderbox{border:2px solid gray;}
		.quote_view .border_left{border-left:2px solid gray;}
		.quote_view .border_right{border-right:2px solid gray;}
		.quote_view .border_bottom{border-bottom:2px solid gray;}
		.quote_view .border_top{border-top:2px solid gray;}
		
		table {
			table-layout:fixed;
		}
		
		.table-bordered td{
			border: 0px solid gray;			
		}
		
		.space_bottom{margin-bottom:15px;}
		.card {border:0px solid rgba(0,0,0,.125);}
	</style>
	
	<div class="card mb-3">	
		<div class="card-body">
			<?php if($quotationInfo->is_deleted == 'Y'){ ?>
				<h4 align="center">Quotation Deleted</h4>
			<?php } else { ?>
			<div class="row quote_view borderbox">
				<div class="col-sm-6 border_right">
					<p><b>Exporter:</b></p>
					<p><b>TARUN ENTERPRISES</b></p>
					<p><?php echo $quotationInfo->store_address; ?></p>
					<p>Phone: <?php echo $quotationInfo->store_phone; ?></p>
					<p>Email: <?php echo $quotationInfo->store_email; ?></p>
					<p>GST No: <?php echo $quotationInfo->store_gst_no; ?></p>
					<?php if($quotationInfo->store_name == 'Allahabad'){  ?>
						<p>Drug Licence: <?php echo $quotationInfo->drug_licence_no; ?></p>
						<p>Dt. <?php echo $quotationInfo->drug_date; ?></p>
					<?php } else { ?>
						<p>&nbsp;</p>
						
					<?php } ?>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Quotation No:</b></p>
							<p style="margin-bottom: 15px;"><?php echo getQuotationNo($quotationInfo->quote_id); ?></p>
						</div>
						<div class="col-sm-6 border_bottom">
							<p><b>Quotation Date:</b></p>
							<p style="margin-bottom: 15px;"><?php echo dateFormat('F, d, Y',$quotationInfo->quotation_date); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Issued From:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $quotationInfo->store_name; ?></p>
							
						</div>
						<div class="col-sm-6 border_bottom">
							<p><b>Currency:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $quotationInfo->currency; ?></p>
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border_right ">
							<p><b>Insurance:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $quotationInfo->insurance; ?></p>
						</div>
						<div class="col-sm-6 ">
							<p><b>Sales Person:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $quotationInfo->firstname .' '.$quotationInfo->lastname; ?></p>
						</div>
					</div>
				</div>
				
				<div class="col-sm-6 border_top border_right">
					<p><b>Customer(Bill to):</b></p>					
					<?php $billingAddress=nl2br($quotationInfo->billing_details);
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
				
				<div class="col-sm-6 border_top">
					<p><b>Consingee(Ship to):</b></p>					
					<?php $shippingAddress=nl2br($quotationInfo->shipping_details);
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
				
				<div class="col-sm-6 border_right border_top border_bottom">
					<p><b>Terms of Delivery:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $quotationInfo->delivery; ?></p>
				</div>
				<div class="col-sm-6 border_top border_bottom">
					<p><b>Terms of Payments:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $quotationInfo->payment_terms; ?></p>
				</div>
				
				
				<div class="col-sm-12  border_bottom">
					<p><b>Terms & Conditions:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $quotationInfo->terms_conditions; ?></p>
				</div>
				
				<div class="col-sm-12  border_bottom">
					<p><b>Special instruction:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $quotationInfo->special_instruction; ?></p>
				</div>
				
				<table class="table-sm table-bordered" width="100%" cellspacing="0">
					<tr>
						<th class="border_right text" style="width:4%;">S.N.</th>
						<th class="border_right" style="width:<?php if(($quotationInfo->currency == 'INR') && ($quotationInfo->quote_id > 1343)){ echo '34.3%'; } else { '40.3%'; } ?>;">Product Description</th>						
						<th class="border_right" style="width:7%;text-align:center;">HSN<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '-GST'; ?><?php } ?></th>
						<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ ?>
						<th class="border_right" style="width:6%;text-align:center;">MRP</th>
						<?php } ?>
						<th class="border_right" style="width:6%;text-align:center;">Qty</th>
						<th class="border_right" style="width:6%;text-align:center;">Unit</th>
						<th class="border_right" style="width:6%;text-align:center;">Rate</th>
						<th class="border_right" style="width:9%;text-align:center;">Discount/Unit</th>
						<th style="width:10%;text-align:right;">Net&nbsp;Amount</th>
					</tr>
					
					<?php
						$net_total = 0;
						$i=1;
						foreach($quoteProductInfo as $productInfo){ 
						$net_total = $net_total + $productInfo['net_amount'];					
					?>
						
							<tr>
								<td class="border_right border_top"><?php echo $i; ?></td>
								<td  class="border_right border_top"><b><?php echo $productInfo['model_name']; ?></b> | <?php echo $productInfo['description']; ?></td>								
								<td align="center" class="border_right border_top"><?php echo $productInfo['hsn']; ?><?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){ echo '<br>'.$productInfo['product_gst']; ?> %<?php } ?></td>
								<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ ?>
								<td align="center" class="border_right border_top"><?php echo $productInfo['mrp']; ?></td>
								<?php } ?>
								<td align="center" class="border_right border_top"><?php echo $productInfo['qty']; ?></td>
								<td align="center" class="border_right border_top"><?php echo $productInfo['unit']; ?></td>
								<td align="center" class="border_right border_top"><?php echo round((float)$productInfo['rate'], 2); //number_format((float)$productInfo['rate'], 4, '.', ''); ?></td>
								<td align="center" class="border_right border_top"><?php echo round((float)$productInfo['discount'], 2); //number_format((float)$productInfo['discount'], 4, '.', ''); ?></td>
								<td class="border_top" align="right"><?php echo round((float)$productInfo['net_amount'], 2); //number_format((float)$productInfo['net_amount'], 2, '.', ''); ?></td>
							</tr>
					
					<?php $i++; } ?>					
					<tr>
						<td class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>Net Total</b></td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$net_total, 2); //number_format((float)$net_total, 2, '.', ''); ?></td>
					</tr>
					<tr>
						<td class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>Freight Charges</b></td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$quotationInfo->freight_charge, 2); //number_format((float)$quotationInfo->freight_charge, 2, '.', ''); ?></td>
					</tr>
							<?php
								if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99')){
									if($productgst){ 
										$totwithgst = 0;
										$freight_charge = $quotationInfo->freight_charge;
										$freight_gst = $quotationInfo->freight_gst;
										$flagFreightGST=1;# set 0 if GST% of freight charge is in the list of products.
										#i.e to cheate the row for GST @ 18% (Freight GST)
										foreach($productgst as $progst){
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
										<td class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>GST @ <?php echo $progst['product_gst']; ?>%</b></td>
										<td class="border_right border_top" align="right"> <i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$totgst, 2); //number_format((float)$totgst, 2, '.', ''); ?></td>
									</tr>
									<?php } ?>
										<?php if($flagFreightGST==1 && $freight_gst>0){ 
											$perProFrchWthGst = ($freight_charge * $freight_gst)/100;
											$totgst = $perProFrchWthGst;
											$totgst = number_format((float)$totgst, 2, '.', '');
											$totwithgst = $totwithgst + $totgst;
										?>
											<tr>
												<td class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>GST @ <?php echo $freight_gst; ?>%</b></td>
												<td class="border_right border_top" align="right"> <i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$totgst, 2); //number_format((float)$totgst, 2, '.', ''); ?></td>
											</tr>
										<?php } ?>
								<?php } ?>
							<?php } ?>
					
					<?php
						//number_format((float)($net_total + $quotationInfo->freight_charge + $totwithgst), 2, '.', '');
						$grandTotal = (float)($net_total + $quotationInfo->freight_charge + $totwithgst);
					?>
					<tr>
						<td class="border_right border_top" colspan="<?php if(($quotationInfo->currency == 'INR') && ($customerInfo->country_id == '99') && ($quotationInfo->quote_id > 1343)){ echo '8'; } else { echo '7'; } ?>" align="right" ><b>Grand Total</b></td>
						<td class="border_right border_top" align="right"> <b><i class="<?php echo $quotationInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo round((float)$grandTotal, 2);  ?></b></td>
					</tr>
				</table>
			</div>
			<br>
			<div class="row">
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
						<!-- <p style="margin: 0px;">Thank you for your interest in our company and products. We trust you will find the quote</p> 
						<p style="margin: 0px;">satisfactory. We look forward to your business.</p>	-->
						<p style="margin: 0px;text-align: justify;">Thank you for your interest in our range of equipment / supplies. We with pleasure offer the quotation as above for your kind consideration. We shall be happy to answer any of your questions in this regard. Banking details are as below. Please note, all banking charges shall be paid by the buyer.</p>
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
							<p style="margin: 0px;width:40%;float:left;"><b>Beneficiary's Name :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->beneficiary_name; ?></p>
						</div>
						
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Name :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_name; ?></p>
						</div>
						
					</div>
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
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
					
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:20%;float:left;"><b>Bank Address :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_address; ?></p>
						</div>										
					</div>	<br><br>

					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">					
						
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
							<p style="float:left;">Note - This quotation is valid  up to <?php echo $valid_for; ?> | Document created by - <?php echo $quotationInfo->created_user; ?></p>
															
					</div>	
					
				</div>
			<?php } ?>
		</div>		
	</div>	
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="max-width: 600px;">				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="quotationmailform" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="<?php echo $quotationInfo->contact_email; ?>" autocomplete='off'  id="email_to" class="form-control" required></div>
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
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Quotation / Performa Invoice - <?php echo getQuotationNo($quotationInfo->quote_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Message:</div>															
							<div class="col-sm-10">
							<textarea class="form-control" rows="7" name="email_massage" id="email_massage">Dear <?php echo $customerInfo->person_title; ?> <?php echo $quotationInfo->contact_person; ?>,

Please find the Quotation as attached in email bellow.

Thank you,
Optitech Eye Care</textarea>
							</div>
						</div>						
					</div>
					
					<div id="quotefiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Attachments:</div>															
							<div class="col-sm-10">
								<div id="quotefile"></div>
								<div id="product_file"></div>
								<div id="certificate_file"></div>
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

<div class="modal fade" id="myModalProCertificate" role="dialog">
	<div class="modal-dialog" style="max-width: 600px;">				
	  <!-- Modal content-->
		<div class="modal-content" style="height:550px;">
			<div class="modal-header">
				<h4 class="modal-title" id="file_heading">Product File</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body">
				<div class="list">
					
				</div>
			</div>
		</div>				  
	</div>
</div>
<script>
	$(document).ready(function(){	
		$("#mailbox").click(function(){	
			$("#product_file").html('');
			$("#certificate_file").html('');
			$.ajax({
				url:'<?php echo site_url('quotation/savePdf'); ?>',
				method: 'post',
				data: 'quotation_id=<?php echo $quotationInfo->quote_id; ?>', 
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
							if(i==0){
								htm += '<a href="<?php echo base_url(); ?>'+ res.quote_file +'" target="_blank" > '+ res.quote_file_name +' </a> <br>';
							}							
							hiddentext += '<input type="hidden" name="quote_file[]" value="'+res.quote_file+'">';							
						});						
						$("#quotefile").html(htm);						
						$("#quotefiletextbox").html(hiddentext);
						
						var product_count = '';
						if(response.product_count>0){
							product_count = '<a href="#">Product Files ('+response.product_count+' Numbers)</a>';							
							$("#product_file").html(product_count); 
						}					
						var certificate_count = '';
						if(response.certificate_count>0){
							certificate_count = '<a href="#">Certificates ('+response.certificate_count+' Numbers)</a>';
							$("#certificate_file").html(certificate_count); 
						}
						
					}
					$("#myModal").modal();		
				}
			});				
		});
		
		$("#sendMail").click(function(){		
			var data_form = $('#quotationmailform').serialize();
			$.ajax({
				url:'<?php echo site_url('sendMail'); ?>',
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
						$("#product_file").html('');
						$("#certificate_file").html('');
					}, 3000);
				}
			});				
		});
		
		$("#product_file").click(function(){			
			$("#file_heading").html("Product Files");
			$.ajax({
				url:'<?php echo site_url('quotation/quotationProductFile'); ?>',
				method: 'post',
				data: 'quotation_id=<?php echo $quotationInfo->quote_id; ?>', 
				dataType: 'json',
				success: function(response){
					var htm = '';						
					$.each(response, function(i,res) {						
						htm += '<a href="<?php echo base_url(); ?>'+ res.file_url +'" target="_blank" > '+ res.file_name +' </a> <br>';												
					});	
					$(".list").html(htm);					
				}
			});
			
			$("#myModalProCertificate").modal();	
		});
		
		$("#certificate_file").click(function(){
			$("#file_heading").html("Certificate File");
			$.ajax({
				url:'<?php echo site_url('quotation/quotationCertificateFile'); ?>',
				method: 'post',
				data: 'quotation_id=<?php echo $quotationInfo->quote_id; ?>', 
				dataType: 'json',
				success: function(response){
					var htm = '';						
					$.each(response, function(i,res) {						
						htm += '<a href="<?php echo base_url(); ?>'+ res.file_url +'" target="_blank" > '+ res.file_name +' </a> <br>';												
					});	
					$(".list").html(htm);					
				}
			});
			
			$("#myModalProCertificate").modal();	
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