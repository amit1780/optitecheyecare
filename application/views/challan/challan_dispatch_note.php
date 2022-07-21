<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<form name="dispatchNoteForm" id="dispatchNoteForm" method="post" action="<?php echo site_url($form_action);?>">
		<div class="page_heading">
			<div class="row">
				<div class="col-sm-6">					
					<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
				</div>
				 <div class="col-sm-6">
					<div class="float-right">
						<button type="submit" class="btn btn-primary" >Save</button>
						&nbsp; <a href="<?php echo site_url('dispatchNotePrint'); ?>/<?php echo $challanInfo->challan_id; ?>" class="btn btn-primary" id="dispatchPrint" target="_blank" data-toggle="tooltip" data-placement="top" title="Dispatch Note Print"> <i class="fas fa-print"></i></a> &nbsp;
						<a href="#" class="btn btn-primary" id="mailbox" data-toggle="tooltip" data-placement="top" title="Email"><i class="fas fa-envelope"></i></a> &nbsp;
						<a href="#" class="btn btn-primary" class="whatsAppMessageBox" id="whatsappbox" title="WhatsApp">
							<?php 
								if($customerInfo->wa_status=='P'){
									echo"<i class='fab fa-whatsapp-square text-warning'></i>";
								}elseif($customerInfo->wa_status=='I'){
									echo"<i class='fab fa-whatsapp-square text-danger'></i>";
								}elseif($customerInfo->wa_status=='C'){
									echo"<i class='fab fa-whatsapp-square text-success'></i>";
								}										
							?>
						</a>
					</div> 	
				</div> 	
			</div>
		</div>
		
		<?php if(isset($success)){ ?>
			<div class="alert alert-success">
			  <?php echo $success; ?>
			</div>
		<?php } ?>
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo validation_errors(); ?>
				</div>
			</div>
			<?php elseif (!empty($errorMsg)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
						<?php echo $errorMsg; ?>
				</div>
			</div>
		<?php endif; ?>	
			
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
			.card{border: 0px solid rgba(0,0,0,.125) !important; }
		</style>
		
		<div class="card mb-3">
				
				<input type="hidden" name="challan_id" value="<?php echo $challanInfo->challan_id; ?>">
				<div class="card-body">
					<center><span id="marqueeText" style="color:red;"></span></center>
					<h3 style="text-align:center;">DISPATCH NOTE</h3>
					<div class="row quote_view borderbox">
						<div class="col-sm-12 justify-content-center ">
							<div style="text-align:center;">
								<!-- <p><b>Exporter:</b></p> -->
								<p style="padding:10px;">Thank You for valued order.</p>								
							</div>
						</div>	
						<!-- <div class="col-sm-12 justify-content-center border_top">
							<div style="text-align:center;">
								
								<p><b>TARUN ENTERPRISES</b></p>
								<p><?php echo $challanInfo->store_address; ?></p>
								<p>Phone: <?php echo $challanInfo->store_phone; ?></p>
								<p>Email: <?php echo $challanInfo->store_email; ?></p>
								<p>GST No: <?php echo $challanInfo->store_gst_no; ?></p>
								<?php if($challanInfo->store_name == 'Allahabad'){  ?>
									<p>Drug Licence: ALLD/5/21B/385,ALLD/5/20B/388</p>
									<p>Dt. 06.05.2008</p>
								<?php } ?>
							</div>
						</div>	 -->
						
						<div class="col-sm-6 border_top border_right">
							<p><b>Bill to:</b></p>
							<?php $billingAddress=nl2br($ordersInfo->billing_details);
								while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
									print "<b>$matcher[1]</b>";
									$billingAddress=after($matcher[0],$billingAddress);
									break;
								}
							?>
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
							<p><b>Ship to:</b></p>					
							<?php $shippingAddress=nl2br($ordersInfo->shipping_details);
								while(preg_match("/(.*?)\n/is",$shippingAddress,$matcher)){
									print "<b>$matcher[1]</b>";
									$shippingAddress=after($matcher[0],$shippingAddress);
									break;
								}
							?>
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
							<p style=""><b style="float:left;width:37%;">Challan No.</b> <?php echo getChallanNo($challanInfo->challan_id); ?> </p>						
						</div>
						
						<div class="col-sm-6 border_top border_bottom">
							<p style=""><b style="float:left;width:37%;">Invoice No:</b> <input type="text" name="invoice_no" value="<?php if($challanInfo->invoice_no){ echo $challanInfo->invoice_no; } else { echo set_value('invoice_no'); } ?>" id="invoice_no" style="border:1px solid black;" ></p>	
							
						</div>
						
						<div class="col-sm-6  border_right border_bottom">							
							<p style=""><b style="float:left;width:37%;">Challan Date:</b> <?php echo dateFormat('Y-m-d', $challanInfo->challan_date); ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom">							
							<p style=""><b style="float:left;width:37%;">Invoice Date:</b> <input type="text" name="invoice_date" value="<?php echo dateFormat('Y-m-d', $challanInfo->invoice_date); ?>" id="invoice_date" class="date" autocomplete='off' style="border:1px solid black;"></p>
						</div>
						<?php if($challanInfo->manual_challan_no){ ?>
						<div class="col-sm-6  border_right border_bottom">					
							<p style=""><b style="float:left;width:37%;">Manual Challan No.:</b> <?php echo $challanInfo->manual_challan_no; ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom">
							<p style=""><b style="float:left;width:37%;">Manual Challan Date:</b> <?php echo dateFormat('Y-m-d', $challanInfo->manual_challan_date); ?></p>
						</div>
						<?php } ?>
						<div class="col-sm-6  border_right border_bottom">					
							<p style=""><b style="float:left;width:37%;">Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom">
							<p style=""><b style="float:left;width:37%;">Method Of Shipment:</b>
							<!-- <input type="text" name="method_of_shipment" value="<?php if($challanInfo->method_of_shipment){ echo $challanInfo->method_of_shipment; } else { echo set_value('method_of_shipment'); } ?>" id="method_of_shipment" style="border:1px solid black;" > -->
							
							<?php /*if($challanInfo->sli_name){							
								echo $challanInfo->sli_name;
								?>
								<input type='hidden' name='sli_id' value='<?php echo $challanInfo->sli_id; ?>'>
								<?php
							}else */ //Removed by Arun requested to edit Method Of Shipment


							if($challanInfo->method_of_shipment){ 
								echo $challanInfo->method_of_shipment;
								?>
								<input type='hidden' name='method_of_shipment' value='<?php echo $challanInfo->method_of_shipment; ?>'>
								<?php
							}else{

								$sli_id=$challanInfo->sli_id;
								if(empty($sli_id)){
									$sli_id=$customerInfo->sli_id;
								}
							?>							
							<select name="sli_id" id="sli_id" width='160px;'>
								<option value="">-- Select --</option>
								<?php foreach($carriers as $carrier){ ?>
									<option value="<?php echo $carrier['sli_id']; ?>" <?php if($carrier['sli_id'] == $sli_id){ echo ' selected="selected"'; } ?> ><?php echo $carrier['sli_name']; ?></option>
								<?php } ?>
							</select>
							<?php  } ?>
							
							</p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom">					
							<p style=""><b style="float:left;width:37%;">Order No:</b> <?php echo getOrderNo($challanInfo->order_id); ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom">
							
							<p style=""><b style="float:left;width:37%;">Date Of Shipment:</b> <input type="text" name="date_of_shipment" value="<?php echo dateFormat('Y-m-d', $challanInfo->date_of_shipment); ?>" id="date_of_shipment" class="date" autocomplete='off' style="border:1px solid black;"></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom">					
							<p style=""><b style="float:left;width:37%;">Sales Person:</b> <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?></p>					
						</div>
						
						<!-- <div class="col-sm-6  border_bottom">
							<p style=""><b>Payment Terms:</b> <?php echo $ordersInfo->payment_terms; ?></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom">					
							<p style=""><b>Special Information:</b> <?php echo $ordersInfo->special_instruction; ?></p>					
						</div> -->
						
						<div class="col-sm-6  border_bottom">							
							<p style=""><b style="float:left;width:37%;">Docket No:</b> <input type="text" name="docket_no" value="<?php if($challanInfo->docket_no){ echo $challanInfo->docket_no; } else { echo set_value('docket_no'); } ?>" id="docket_no" style="border:1px solid black;" ></p>						
						</div>
						
						<div class="col-sm-6 border_right border_bottom">
							<p><b style="float:left;width:37%;">Dispatched From:</b> <?php echo $challanInfo->store_name; ?></p>
							
						</div>
						
						<div class="col-sm-6 border_bottom">
							<p><b style="float:left;width:37%;">SB Number:</b> <input type="text" name="sb_number" value="<?php if($challanInfo->sb_number){ echo $challanInfo->sb_number; } else { echo set_value('sb_number'); } ?>" id="sb_number" autocomplete='off' style="border:1px solid black;"></p>		
						</div>
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Terms of Delivery:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->delivery; ?></p>	
						</div>
						<div class="col-sm-6 border_bottom">							
							<p><b style="float:left;width:37%;">E-Way Bill:</b> <input type="text" name="eway_bill" value="<?php if($challanInfo->eway_bill){ echo $challanInfo->eway_bill; } else { echo set_value('eway_bill'); } ?>" id="eway_bill" autocomplete='off' style="border:1px solid black;"></p>		
						</div>	
						
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Special Information:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->special_instruction; ?></p>
						</div>
						<div class="col-sm-6 border_bottom">
							<p><b>Terms of Payments:</b></p>
							<p style="margin-bottom: 15px;"><textarea name="payment_terms" id="payment_terms" style="border:1px solid black; width:100%;"><?php if($challanInfo->payment_terms){ echo $challanInfo->payment_terms; } else { echo set_value('payment_terms'); }  ?></textarea></p>
						</div>

							

						<div class="col-sm-12 border_bottom">
							<p><b>Terms & Conditions:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->terms_conditions; ?></p>								
						</div>	
						
						<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
							<tr>
								<th class="border_right" style="width:4%;">S.N.</th>
								<th class="border_right" style="width:80%;">Product Description</th>
								
								<th class="border_right" style="">Unit</th>
								<th class="" style="">Qty</th>
								
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
									<td class="border_right border_top"><?php echo $i; ?></td>
									<td class="border_right border_top"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>							
									<td class="border_right border_top"><?php echo $challanProduct['pro_unit']; ?></td>
									<td class=" border_top"><?php echo $challanProduct['qty']; ?></td>													
								</tr>
							
							<?php $i++; } ?>					
						</table>
					</div>
					<div class="row">
						<div class="col-sm-12" style="padding-left:0px;margin-top:20px;">
							<p style="margin: 0px;">Doc No. TE/F-7.5-07 For Tarun Enterprises</p> 
							<p style="margin: 0px;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?>&nbsp;&nbsp;|&nbsp;&nbsp;Packed by <?php echo $challanInfo->packer_full_name; ?></p>
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
				
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">						
						<p style="margin: 0px;">Bank remittance charge shall be paid by payer(buyer)</p><br>
						<p style="margin: 0px;">For Tarun Enterprises</p><br><br>
						<p style="margin: 0px;">Order Processing Team</p><br>
						<!-- <p style="margin: 0px;font-size:14px;">Created by (<?php echo $ordersInfo->firstname .' '.$ordersInfo->lastname; ?>)</p> --> 
					</div>						
					</div>
					
				</div>			
		</div>
	</form>	
</div>

<style>
.modal-dialog{max-width:1000px !important;}
</style>

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
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Dispatch Note for challan # <?php echo getChallanNo($challanInfo->challan_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10"> <!-- Dear <?php echo $customerInfo->person_title; ?> <?php echo $ordersInfo->contact_person; ?> -->
							<textarea class="form-control" rows="7" name="email_massage"  id="email_massage">Dear <?php echo $customerInfo->person_title; ?> <?php echo $ordersInfo->contact_person; ?>,							
							
Hope this finds you in best of health!

We appreciate your business.It is always pleasure to work with you.At this time, we are pleased to
inform you, a shipment has been made.Details as per “Despatch Note“ enclosed.

In line with our customer-centric approach, we request you to share with us your feedback on our
products and service.It shall help us to serve you better.

Please do confirm receipt of the shipment at your office for our records.

Best wishes.</textarea>
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

<div class="modal fade" id="myModalSendWhatsApp" role="dialog">
	<div class="modal-dialog" >
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send WhatsApp</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			
			</div>
			<div id="alert-danger-common"></div>
			<div class="modal-body">
				<form method="post" action="" id="whatsapp_form" enctype="multipart/form-data" >
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Message:</div>															
							<div class="col-sm-10">
								<textarea class="form-control" style="height:180px !important;" rows="7" name="wa_message" id="wa_message"></textarea>
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-sm-12">
																				
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" name="pdf_check" class="form-check-input" value="1">Check to send Challan along with message in pdf format.
								</label>
							</div>
						</div>									
					</div>
					<div>
						<input type="hidden" name="wa_challan_id" id="wa_challan_id" >
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="whatsapp_message" class="btn btn-primary float-right"> Send WhatsApp</button>	
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
		$("#whatsappbox").click(function(){
			var id = this.id.split("_");
			var wa_challan_id = '<?php echo $challanInfo->challan_id; ?>';
			$("#wa_challan_id").val(wa_challan_id);
			$("#myModalSendWhatsApp").modal();			
		});

		$("#whatsapp_message").click(function(){
			var data_form = $('#whatsapp_form').serialize();
			//console.log(data_form);
			var formData = new FormData($('#whatsapp_form')[0]);
			$.ajax({
				url:'<?php echo site_url('common/sendWhatsAppDispatchNote'); ?>',
				type: 'POST',
			    data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				beforeSend: function(){
					   $("#whatsapp_message").prop('disabled', true);
					   $("#whatsapp_message").attr('disabled', true);
				},
				complete: function(){
					  $("#whatsapp_message").prop('disabled', false);
				},
				success: function(response){
					$("#alert-danger-common").html('');
					var htm = '<div class="alert alert-success" role="alert">Message Sent Successfully.</div>';
					$("#alert-danger-common").html(htm);
					setTimeout(function(){
						$("#myModalSendWhatsApp .close").click();
						$("#alert-danger-common").html('');
					}, 3000);
				}
			});
		});

		$("#mailbox").click(function(){			
			$.ajax({
				url:'<?php echo site_url('challan/dispatchNoteSavePdf'); ?>',
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

<script>
	$(document).ready(function() {
		// Date time
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
		
		var invoice_no = $("#invoice_no").val();
		var invoice_date = $("#invoice_date").val();
		
		if((invoice_no == '') || (invoice_date == '' || invoice_date == null || invoice_date == '0000-00-00 00:00:00')){
			$("#dispatchPrint").hide();
			$("#mailbox").hide();
			$("#marqueeText").html("Please genrate invoice first to create dispatch note.");
		} else {
			$("#marqueeText").html("");
			$("#dispatchPrint").show();
			$("#mailbox").show();
		}
		
		$('#sli_id').on('change', function() {
			var value = $(this).val();
			var sli_id = '<?php echo $customerInfo->sli_id; ?>';
			var account_number = '<?php echo $customerInfo->account_number; ?>';
			
			if(value == sli_id){
				$('#account_number').val(account_number);
			}else{
				$('#account_number').val('');
			}
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