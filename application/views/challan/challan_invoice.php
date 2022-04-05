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
					<a href="<?php echo site_url('challan/challanInvoicePrint'); ?>?challan_id=<?php echo $challan_id; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="top" title="Invoice Print"> <i class="fas fa-print"></i></a> &nbsp;
						
					<a href="#" class="btn btn-primary" id="mailbox" data-toggle="tooltip" data-placement="top" title="Email"><i class="fas fa-envelope"></i></a> 
				</div>
			</div> 
						
		</div>
	</div>
	
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
	
	<?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>

	<form role="form" class="needs-validation" id="saveChallanInvoiceForm" method="post" action="<?php echo $form_action;?>" enctype="multipart/form-data" >
		<input type="hidden" name="order_id" id="order_id" value="<?php echo $challanInfo->order_id; ?>">
		<!-- <input type="hidden" name="customer_id" id="customer_id" value="<?php //echo $orderInfo->customer_id; ?>"> -->
		<input type="hidden" name="challan_id" id="challan_id" value="<?php echo $challan_id; ?>">
		
		<fieldset class="proinfo">
			<legend>Invoice</legend>
			
				<div class="row" style="margin-top:-15px;margin-bottom: 15px;">
					<div class="col-sm-12">
						<span>Challan No : <b><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challan_id; ?>" ><?php echo getChallanNo($challan_id); ?></a></b></span> | 
						<span>Order No : <b><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challan['order_id']; ?>" ><?php echo getOrderNo($challanInfo->order_id); ?></a></b></span> |
						<span>Quotation No : <b><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $ordersInfo->quotation_id; ?>"><?php echo getQuotationNo($ordersInfo->quotation_id); ?></a></b></span> |
						<span>Company Name : <b><a target="_blank" href="<?php echo site_url('customerView'); ?>/<?php echo $customerInfo->customer_id; ?>"><?php echo $customerInfo->company_name; ?></a></b></span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Invoice No</div> 
							 <input type="text" name="invoice_no" value="<?php if(!empty($challanInfo->invoice_no)){ echo $challanInfo->invoice_no; } else { echo set_value('invoice_no'); } ?>" id="invoice_no" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
							<?php $invoice_date = dateFormat('Y-m-d',$challanInfo->invoice_date); ?>
							<div class="form-group">
								<div class="control-label" >Invoice Date</div> 
								<input type="text" name="invoice_date" value="<?php if(!empty($invoice_date)){ echo $invoice_date; } else { echo set_value('invoice_date'); } ?>" id="invoice_date" class="form-control date" autocomplete='off'>								
							</div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Supplier's Ref.</div> 
							 <input type="text" name="supplier_ref" value="<?php if(!empty($challanInvoiceInfo->supplier_ref)){ echo $challanInvoiceInfo->supplier_ref; } else { echo set_value('supplier_ref'); } ?>" id="supplier_ref" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Despatch Document No.</div>
							 <input type="text" name="docket_no" value="<?php if(!empty($challanInfo->docket_no)){ echo $challanInfo->docket_no; } else { echo set_value('docket_no'); } ?>" id="docket_no" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Despatched through</div> 
							 <input type="text" name="despatched_through" value="<?php if(!empty($challanInvoiceInfo->despatched_through)){ echo $challanInvoiceInfo->despatched_through; } else { echo set_value('invoice_no'); } ?>" id="despatched_through" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Destination</div> 
							 <input type="text" name="destination" value="<?php if(!empty($challanInvoiceInfo->destination)){ echo $challanInvoiceInfo->destination; } else { echo set_value('destination'); } ?>" id="destination" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Vessel/Flight No.</div> 
							 <input type="text" name="vessel_flight_no" value="<?php if(!empty($challanInvoiceInfo->vessel_flight_no)){ echo $challanInvoiceInfo->vessel_flight_no; } else { echo set_value('vessel_flight_no'); } ?>" id="vessel_flight_no" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Place of receipt by shipper</div> 
							 <input type="text" name="place_of_receipt_by_shipper" value="<?php if(!empty($challanInvoiceInfo->place_of_receipt_by_shipper)){ echo $challanInvoiceInfo->place_of_receipt_by_shipper; } else { echo set_value('place_of_receipt_by_shipper'); } ?>" id="place_of_receipt_by_shipper" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >City/Port of Loading</div> 
							 <input type="text" name="city_port_of_loading" value="<?php if(!empty($challanInvoiceInfo->city_port_of_loading)){ echo $challanInvoiceInfo->city_port_of_loading; } else { echo set_value('city_port_of_loading'); } ?>" id="city_port_of_loading" class="form-control" autocomplete='off'>								
						  </div>
					</div>
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >City/Port of Discharge</div> 
							 <input type="text" name="city_port_of_discharge" value="<?php if(!empty($challanInvoiceInfo->city_port_of_discharge)){ echo $challanInvoiceInfo->city_port_of_discharge; } else { echo set_value('city_port_of_discharge'); } ?>" id="city_port_of_discharge" class="form-control" autocomplete='off'>								
						  </div>
					</div>					
					<!-- <div class="col-sm-3">
					  <div class="form-group">
						<div class="control-label" >Country</div> 
						<?php //$country_id = $this->input->get('country_id'); ?>
						<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" >
							<option value="">-- Seclect --</option>
							<?php foreach($countries as $country){ ?>
								<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
							<?php } ?>
						</select>					
					  </div>
					</div> 
					<div class="col-sm-3">	
						  <div class="form-group">
							 <div class="control-label" >Country of Origin of Goods</div> 
							 <input type="text" name="country_of_origin_of_goods" value="" id="country_of_origin_of_goods" class="form-control" autocomplete='off'>								
						  </div>
					</div> -->
					
					<div class="col-sm-3">
					  <div class="form-group">
						<div class="control-label" >Country of Final Destination</div> 
						<?php $country_id = $challanInvoiceInfo->country_of_final_destination; ?>
						<select name="country_of_final_destination" id="country_of_final_destination" class="form-control" onChange="getState(this.value)" >
							<option value="">-- Seclect --</option>
							<?php foreach($countries as $country){ ?>
								<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
							<?php } ?>
						</select>					
					  </div>
					</div>
					
					<div class="col-sm-3">
					  <div class="form-group">
						<div class="control-label" >Terms of delivery</div> 
						<textarea name="terms_of_delivery" id="terms_of_delivery" class="form-control" style="height:38px;"><?php if(!empty($ordersInfo->delivery)){ echo $ordersInfo->delivery; } else { echo set_value('terms_of_delivery'); } ?></textarea>				
					  </div>
					</div>
					
					<div class="col-sm-12"><br>
						<div class="form-group">									
							<button type="submit" id="saveChallanInvoice" class="btn btn-primary float-right">Save</button>	
						</div>
					</div>	
					
				</div>
		</fieldset>	
	</form>
	<div class="container">	
				<div class="row">
					<!-- <div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
						<p style="margin: 0px;">Bank Details</p>
					</div> -->
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
						<!-- <div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Payment :</b></p><p style="margin: 0px;float:left;">100% T/T(wire)</p>
						</div> -->	
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
							<div class="col-sm-2">Attachment:</div>															
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
		// Date time
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
		// End Date time
		
	
		$("#mailbox").click(function(){			
			$.ajax({
				url:'<?php echo site_url('challan/challanInvoiceSavePdf'); ?>',
				method: 'post',
				data: 'challan_id=<?php echo $challan_id; ?>', 
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
				url:'<?php echo site_url('challan/challanInvoiceSendMail'); ?>',
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