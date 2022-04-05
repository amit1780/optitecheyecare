<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>
			</div>
			<!-- <div class="col-sm-6">
				<div class="float-right">
					<a href="<?php //echo site_url('challan'); ?>?order_id=<?php //echo $ordersInfo->order_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Create Challan"><i class="fas fa-plus"></i></a> &nbsp;					
				</div>
			</div> -->			
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
	<?php if(isset($error)){ ?>
		<script>
			$(document).ready(function() {
				$("#saveChallan").show();							
			});
		</script>
		<div class="alert alert-danger">
		  <?php echo $error; ?>
		</div>
	<?php } ?>	
	<style>
		#challan_type-error{position: absolute;margin-top: 46px;margin-left:17%;}
		.procheckbox label{position: absolute;margin-top: -65px;}
		.errorTxt{
		  border: 0px solid red;
		  min-height: 20px;
		  color:red;
		}
	</style>
	
<script>
	$(document).ready(function() {						
		$("#saveChallanForm").validate({
			rules: {
				challan_type: "required",					
				conf: "required",								
				product_id: {
					required: true,
					minlength: 1
				}		 			
			},					
			errorPlacement: function(error, element) {					
				if(element.attr("name") == "product_id[]"){
					error.appendTo('.errorTxt');						
					$(".errorTxt").html( "Please select any product to create challan." ); 
					return;
				} else if (element.attr("name") == "conf"){
					 error.appendTo('.errorTxt2');						
					 $(".errorTxt2").html( "Please confirm bank" );
					 return;
				  }	else if(element.attr("name") == "challan_type"){
					  error.appendTo('.errorTxt3');						
						$(".errorTxt3").html( "Please Select Challan Type" );
					 return;
				  } else {
					error.insertAfter(element);
				}		
				
			}
		});
		
		$('#saveChallan').click(function() {
			$("#saveChallan").hide();
			$(".processing").show();
			setTimeout(function(){
				$(".processing").hide();
				$("#saveChallan").show();		
			}, 10000);
			$("#saveChallanForm").valid();
		});
	});  
</script>	
	
	<form role="form" class="needs-validation" id="saveChallanForm" method="post" action="<?php echo $form_action;?>" enctype="multipart/form-data" >
		<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $orderInfo->customer_id; ?>">
		
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				
				<fieldset class="proinfo">
					<legend>Edit Challan</legend>
						<!-- <div class="row">
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Store</b> </label>&nbsp;&nbsp;&nbsp;
										<?php foreach($stores as $store){ ?>
									  <input class="form-check-input storeId" type="radio" name="store_id" value="<?php echo $store['store_id']; ?>" required <?php if($store['store_id']==$challanInfo->store_id){ echo "checked"; } ?>  disabled>  
									  <label class="form-check-label"><?php echo $store['store_name']; ?></label>&nbsp;&nbsp;&nbsp; 
										<?php } ?>
									  
								</div>								
							</div>
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Challan Type</b> </label>&nbsp;&nbsp;&nbsp;
										
									  <input class="form-check-input" type="radio" name="challan_type" value="Domestic" <?php if($challanInfo->challan_type == 'Domestic'){ echo "checked"; } ?> <?php echo set_radio('challan_type', 'Domestic'); ?> disabled  required>
									  <label class="form-check-label">Domestic</label>&nbsp;&nbsp;&nbsp; 
									  
									  <input class="form-check-input" type="radio" name="challan_type" value="Export" <?php if($challanInfo->challan_type == 'Export'){ echo "checked"; } ?> <?php echo set_radio('challan_type', 'Export'); ?> disabled  required>
									  <label class="form-check-label">Export</label>&nbsp;&nbsp;&nbsp;
								</div>
								<div class="error errorTxt3"></div>
							</div>
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Bank Name</b> </label>:&nbsp; <span id="bank_name"><?php echo $challanInfo->bank_name; ?></span>									
									  &nbsp;&nbsp;&nbsp;									  
									  <input class="form-check-input" type="radio" name="conf" value="1" disabled required >  
									  <label class="form-check-label">Yes</label>&nbsp;&nbsp;&nbsp; 
									  <input class="form-check-input" type="radio" name="conf" value="0" disabled required >  
									  <label class="form-check-label">No</label>&nbsp;&nbsp;&nbsp; 
								</div>
								<div class="error errorTxt2"></div>
								<input type="hidden" name="bank_id" id="bank_id" value="<?php echo $challanInfo->bank_id; ?>">								
							</div>
							
						</div> 
						<br> -->
						<!-- <div class="row">
						
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Challan No</div> 
								 <input type="text" name="Challan_no" value="<?php echo getChallanNo($challanInfo->challan_id); ?>" id="Challan_no" class="form-control" autocomplete='off' disabled>								
							  </div>
							</div>
								
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Challan Date</div> 
								 <input type="text" name="challan_date" value="<?php echo dateFormat('Y-m-d',$challanInfo->challan_date); ?>" id="challan_date" value="" class="form-control date" autocomplete='off' required disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Manual Challan No</div> 
								 <input type="text" name="manual_challan_no" value="<?php echo $challanInfo->manual_challan_no; ?>" id="manual_challan_no" class="form-control" autocomplete='off' disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Manual Challan Date</div> 
								 <input type="text" name="manual_challan_date" value="<?php echo dateFormat('Y-m-d',$challanInfo->manual_challan_date); ?>" id="manual_challan_date" class="form-control date" autocomplete='off' disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Method Of Shipment</div> 
								 <input type="text" name="method_of_shipment" value="<?php echo $challanInfo->method_of_shipment; ?>" id="method_of_shipment" class="form-control" autocomplete='off' disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Date Of Shipment</div> 
								 <input type="text" name="date_of_shipment" value="<?php echo dateFormat('Y-m-d',$challanInfo->date_of_shipment); ?>" id="date_of_shipment" class="form-control date" autocomplete='off' disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >SB Number</div> 
								 <input type="text" name="sb_number" value="<?php echo $challanInfo->sb_number; ?>" id="sb_number" class="form-control" autocomplete='off' disabled>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Docket No.</div> 
								 <input type="text" name="docket_no" value="<?php echo $challanInfo->docket_no; ?>" id="docket_no" class="form-control" autocomplete='off' disabled>								
							  </div>
							</div>
							
								
							
							<!-- <div class="col-sm-3">	
								<div class="row">
									<div class="col-sm-6">	
										  <div class="form-group">
											 <div class="control-label" >Invoice No</div> 
											 <input type="text" name="invoice_no" value="" id="invoice_no" class="form-control" autocomplete='off'>								
										  </div>
									</div>
									
									<div class="col-sm-6">	
										  <div class="form-group">
											 <div class="control-label" >Invoice Date</div> 
											 <input type="text" name="invoice_date" value="" id="invoice_date" class="form-control date" autocomplete='off'>								
										  </div>
									</div>
								</div>
							</div> -->
							
							<!-- <div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Invoice No</div> 
									 <input type="text" name="invoice_no" value="<?php echo $challanInfo->invoice_no; ?>" id="invoice_no" class="form-control" autocomplete='off' disabled>								
								  </div>
							</div>
							
							<div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Invoice Date</div> 
									 <input type="text" name="invoice_date" value="<?php echo dateFormat('Y-m-d',$challanInfo->invoice_date); ?>" id="invoice_date" class="form-control date" autocomplete='off' disabled>								
								  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Sales Person</div> 
									<select name="user_id" class="form-control" disabled>
										<option value=''>-Select-</option>
										<?php if(isset($users)){ ?>
										<?php foreach($users as $user){ ?>
											
											<option value="<?php echo $user['user_id']; ?>" <?php if(isset($user['user_id']) && $user['user_id'] == $challanInfo->user_id) { echo ' selected="selected"'; } ?>>
											<?php echo $user['firstname']." ".$user['lastname']; ?></option>
											
										<?php } ?>
									<?php } ?>
									</select>								
							  </div>
							</div>	
							
							<div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Packer's Name</div> 
										<select name="packer_id" class="form-control" disabled>
											<option value=''>-Select-</option>
											<?php if(isset($packers)){ ?>
												<?php foreach($packers as $packer){ ?>												
													<option value="<?php echo $packer['packer_id']; ?>" <?php if(isset($packer['packer_id']) && $packer['packer_id'] == $challanInfo->packer_id) { echo ' selected="selected"'; } ?> ><?php echo $packer['packer_full_name']; ?></option>											
												<?php } ?>
											<?php } ?>
										</select>									
								  </div>
							</div>
												
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" >Customer(Bill to):</div>
									<select name="billing_details_default" id="billing_details_default" class="form-control" disabled>
										<option value="">-- Select --</option>
										<?php $i=1; foreach($addresses as $address){ ?>							
											<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
										<?php $i++; } ?>
									</select>
								</div>
								<div class="form-group">
									<textarea name="billing_details" id="billing_details" rows="8"  class="form-control" required disabled><?php if($challanInfo->billing_details) { echo $challanInfo->billing_details; } ?></textarea>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" >Customer(Ship to): &nbsp;&nbsp; <input type="checkbox" name="same_address" id="same_address" disabled><span style="color:gray;"> Same as Bill Details</span></div>
									<select name="shipping_details_default" id="shipping_details_default" class="form-control" disabled>	
										<option value="">-- Select --</option>
										<?php $i=1; foreach($addresses as $address){ ?>							
											<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
										<?php $i++; } ?>
									</select>
								</div>
								<div class="form-group">
									<textarea name="shipping_details" id="shipping_details" rows="8" class="form-control" required disabled><?php if($challanInfo->shipping_details) { echo $challanInfo->shipping_details; }  ?></textarea>
								</div>				
							</div>				
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="control-label" >Terms of Payments:</div>
									<textarea name="payment_terms" id="payment_terms" class="form-control" disabled><?php if($challanInfo->payment_terms) { echo $challanInfo->payment_terms; } else if(set_value('payment_terms')){ echo set_value('payment_terms'); } ?></textarea>
								</div>
							</div>
						</div>
						<br>
						<div class="errorTxt"></div> -->
						
						<div class="row">
							<input type="hidden" name="order_id" value="<?php echo $ordersInfo->order_id; ?>">							
							<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
								<tr>
									<th class="border_right" style="width:4%;">S.N.</th>
									<th class="border_right" style="width:20%;">Product Description</th>
									<th class="border_right" style="width:7%;text-align:center;">HSN</th>
									<th class="border_right" style="width:5%;text-align:center;">Unit</th>
									<th class="border_right" style="width:6%;text-align:center;">Qty</th>
									<th class="border_right" style="width:8%;text-align:center;">Rate</th>
									<th class="border_right" style="width:11%;text-align:center;">Batch No</th>									
									<th class="border_right" style="width:12%;text-align:center;">Mfg Dt./Exp Dt.</th>
									<th class="border_right" style="width:8%;text-align:center;">Discount/Unit</th>									
									<th class="border_right" style="width:8%;text-align:center;">Edit Discount</th>									
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
								?>
								<input type="hidden" name="challan_pro_id" value="<?php echo $challanProduct['challan_pro_id']; ?>">
								<tr class="prtr" data-val="<?php echo $challanProduct['product_id'];?>" data-gst="<?php echo $challanProduct['product_gst'];?>">
									<td class="border_right border_top"><?php echo $i; ?></td>
									<td align="left" class="border_right border_top"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>
									<td align="center" class="border_right border_top"><?php echo $challanProduct['pro_hsn']; ?></td>
									<td align="center" class="border_right border_top"><?php echo $challanProduct['pro_unit']; ?></td>
									<td align="center" class="border_right border_top"><?php echo $challanProduct['qty']; ?></td>
									<td align="center" class="border_right border_top"><?php echo number_format((float)$challanProduct['rate'], 4, '.', ''); ?></td>
									<td align="center" class="border_right border_top"><?php echo $challanProduct['batch_no']; ?></td>
									<td align="center" class="border_right border_top"><?php echo dateFormat('m-Y', $challanProduct['batch_mfg_date']); ?>/<?php echo dateFormat('m-Y', $challanProduct['batch_exp_date']); ?></td>
									<td align="center" class="border_right border_top"><?php echo number_format((float)$challanProduct['discount'], 4, '.', ''); ?></td>
									<td align="center" class="border_right border_top"><input type="text" name="new_discount[<?php echo $challanProduct['challan_pro_id']; ?>]" class="discount" style="width:100%;"></td>
									<td class="border_top" align="right"><?php echo number_format((float)$challanProduct['net_total'], 2, '.', ''); ?></td>							
								</tr>
								
								<?php $i++; } ?>					
								<tr class="nettottr">
									<td class="border_right border_top" colspan="10" align="right" ><b>Net Total</b></td>
									<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="net_total"><?php echo number_format((float)$net_total, 2, '.', ''); ?></span></td>
								</tr>
								<tr class="ftr">
									<td class="border_right border_top" colspan="10" align="right" ><b>Freight Charges</b></td>
									<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; 
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
										<td class="border_right border_top" colspan="10" align="right" ><b>GST @ <?php echo $progst['gst_rate']; ?>%</b></td>
										<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id='gstTotal_<?php echo $progst['gst_rate']; ?>'> <?php echo number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?></span></td>
										<input type="hidden" id="gstTotalAmount_<?php echo $progst['gst_rate']; ?>" name="gst_total_amount[<?php echo $progst['gst_rate']; ?>]" value="<?php echo number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?>">										
									</tr>
									
									<?php } ?>
									<?php } ?>
									<?php } ?>
									
								<tr class="grndtr">
									<td class="border_right border_top" colspan="10" align="right" ><b>Grand Total</b></td>
									<td class="border_right border_top" align="right"> <b><i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="grand_total"><?php echo number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', ''); ?></span></b></td>
								</tr>
							</table>
						</div>
						<br>						
						<div class="row">							
							<div class="col-sm-12">
								<div class="form-group">									
									<img class="processing float-right" src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading.."><button type="submit" id="saveChallan" class="btn btn-primary float-right">Save Challan</button>	
								</div>
							</div>	
						</div>
				</fieldset>	
				
			</div>			
		</div>
	</form>
</div>

<div class="modal fade" id="myModal3" role="dialog" >
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Bank List</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>			
			<div class="modal-body">
				<form name="banklistform" id="banklistform" method="post" action="">
					<?php foreach($banks as $bank){ ?>
						<div style="width:100%;margin-left:10%;">
							<input class="form-check-input bank_id" type="radio" name="bankid" value="<?php echo $bank['id']; ?>" >  
							<label class="form-check-label" id="bankname_<?php echo $bank['id'];  ?>" ><?php echo $bank['bank_name']; ?></label>
						</div>
					<?php } ?>
					<div class="float-right">
						<button type="button" class="btn btn-primary" id="addBank" >Add</button>
					</div>
				</form>
			</div>
		</div>				  
	</div>
</div>

<script>
	$(document).ready(function() {
		$(".processing").hide();
		var currDate = '<?php echo date("Y-m-d"); ?>';
		$("#challan_date").val(currDate);
		
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
		
		$('#billing_details_default').change(function() {
			
			var address_id = $("#billing_details_default option:selected").val();
			if(address_id == ''){
				$("#billing_details").val('');
				return false;
			}
			var customer_id = '<?php echo $customerInfo->customer_id; ?>';			
			$.ajax({
				url:'<?php echo site_url('getAddressByAddressId');?>',
				method: 'post',					
				data: {address_id: address_id, customer_id: customer_id},
				dataType: 'json',
				success: function(response){						
					var company_name1 			= (response.company_name) ? response.company_name : '';
					var contact_person1 		= (response.contact_person) ? "\n" + response.contact_person : '';
					var address_11 				= (response.address_1) ? "\n" + response.address_1 : '';
					var address_21 				= (response.address_2) ? "\n" +response.address_2 : '';
					var city1 					= (response.city) ? "\n" +response.city : '';						
					var district1 				= (response.district) ? "," +response.district : '';
					var state1 					= (response.state_name) ? "," +response.state_name : '';
					var pin1 					= (response.pin) ? "\n" +response.pin : '';
					var country1 				= (response.country_name) ? "," +response.country_name : '';
					var phone1 					= (response.phone) ? " " + response.phone : '';
					var mobile1 				= (response.mobile) ? " " + response.mobile : '';
					
					var mob = '';
					if(phone1 && mobile1){ 
						mob = "\nMobile: "+phone1 + ", "+mobile1;
					}else if((phone1) && (mobile1 == '')) {
						mob = "\nMobile: "+phone1;
					} else if((mobile1) && (phone1 == '')){
						mob = "\nMobile: "+mobile1;
					}
					var email1 					= (response.email) ? "\nEmail: " +response.email : '';						
				
					var billing_address = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;	
					
					$("#billing_details").val(billing_address);
				}
			});
			
		});
		
		$('#shipping_details_default').change(function() {
			$("#same_address").prop('checked', false);
			
			var address_id = $("#shipping_details_default option:selected").val();
			if(address_id == ''){
				$("#shipping_details").val('');
				return false;
			}
			var customer_id = '<?php echo $customerInfo->customer_id; ?>';			
			$.ajax({
				url:'<?php echo site_url('getAddressByAddressId');?>',
				method: 'post',					
				data: {address_id: address_id, customer_id: customer_id},
				dataType: 'json',
				success: function(response){						
					var company_name1 			= (response.company_name) ? response.company_name : '';
					var contact_person1 		= (response.contact_person) ? "\n" + response.contact_person : '';
					var address_11 				= (response.address_1) ? "\n" + response.address_1 : '';
					var address_21 				= (response.address_2) ? "\n" +response.address_2 : '';
					var city1 					= (response.city) ? "\n" +response.city : '';						
					var district1 				= (response.district) ? "," +response.district : '';
					var state1 					= (response.state_name) ? "," +response.state_name : '';
					var pin1 					= (response.pin) ? "\n" +response.pin : '';
					var country1 				= (response.country_name) ? "," +response.country_name : '';
					
					var phone1 					= (response.phone) ? " " + response.phone : '';
					var mobile1 				= (response.mobile) ? " " + response.mobile : '';
					
					var mob = '';
					if(phone1 && mobile1){ 
						mob = "\nMobile: "+phone1 + ", "+mobile1;
					}else if((phone1) && (mobile1 == '')) {
						mob = "\nMobile: "+phone1;
					} else if((mobile1) && (phone1 == '')){
						mob = "\nMobile: "+mobile1;
					}
					
					
					var email1 					= (response.email) ? "\nEmail: " +response.email : '';						
				
					var shipping_details = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;	
					
					$("#shipping_details").val(shipping_details);
				}			
			});
		});
		
		$("#same_address").on("click", function () {			
			if($(this).is(":checked")) {
				 $("#shipping_details").val($("#billing_details").val());   
		    } else {
				$("#shipping_details").val('');  
			}			
		});	
		
		$(".storeId").on("change", function () {			
			var store_id = $(this).val();
			$(".procheckbox").prop('checked', false);
			$('#gstcalculation').html('');
			$('#productBatch').html('');
			$('#netTotal').html('');
			$('#grand_total').html('');			
		});
		
		$('#viewFrtchrg').click(function() {
			$("#myModal2").modal();
		});
		
		$("input[name='conf']").click(function() {			
			$(".errorTxt2").html('');
			if($(this).val() == 0){
				$(this).prop('checked', false);
				$("#myModal3").modal();
			}
		});
		
		$("input[name='challan_type']").click(function() {			
			$(".errorTxt3").html('');			
		});
		
		$("#addBank").click(function() {
			$(".errorTxt2").html('');
			if($("input[name='bankid']").is(":checked")) {				
				var bank_id = $('input[name=bankid]:checked').val();				
				var bank_name = $('#bankname_'+bank_id).text();
				$('#bank_id').val(bank_id);
				$('#bank_name').html(bank_name);
				$("input[value='1']").prop('checked', true);
				$("#myModal3 .close").click();
			}
		});
		
		$('.discount').keyup(function() {			
			var currency = '<?php echo $ordersInfo->currency; ?>';
			var freight_gst = '<?php echo $this->config->item('PER_FREIGHT_GST'); ?>';
			var discount = $(this).val();
			var qty = $(this).closest('tr').find("td:eq(4)").html();
			var rate = $(this).closest('tr').find("td:eq(5)").html();						
			var net_amount = parseFloat(rate) - parseFloat(discount);
			
			net_amount = parseFloat(net_amount) * parseFloat(qty);
			$(this).closest('tr').find("td:eq(10)").html(net_amount.toFixed(2));
			
			var result = (this.id).split('_');
			var product_id = result[1];
			$("#proamt_"+product_id).val(net_amount.toFixed(2));
			
			var nettot = 0;
			var prototal = '';
			var grand_tot = '';
			var freight_charge = '';
			var chkbox = '';
			var gstArr={};			
			$(".prtr").each(function(){				
				var pro_id = $(this).closest('tr').attr("data-val");
				var gstRate = $(this).closest('tr').attr("data-gst");				
				var gstAmt="gstAmt_"+pro_id;
				if(gstArr[gstRate]==null){
					gstArr[gstRate]=0.00;
				}

				prototal = $(this).find("td:last").html();					
				nettot = parseFloat(nettot) + parseFloat(prototal);				
				var gstAmount=0.00;
				
				if(currency == 'INR'){
					gstAmount=(prototal*gstRate)/100;					
					gstArr[gstRate]=parseFloat(gstArr[gstRate])+parseFloat(gstAmount);
				}
				
			});	
			nettot = nettot.toFixed(2);
			$("#net_total").html(nettot);				
			freight_charge = $("#freight_charge").html();				
			grand_tot = parseFloat(nettot) + parseFloat(freight_charge);
			var gstFlag = 0;
			if(currency == 'INR'){
				var perProFrch = 0;				
				$.each(gstArr , function(index, val) {
					//perProFrch = (parseFloat(freight_charge) / parseFloat(nettot)) * parseFloat(val);						
					//val = parseFloat(perProFrch) + parseFloat(val);
					
					if(freight_gst == index){
                    	gstFlag = 1;
                    	var gtval = (parseFloat(freight_charge) * parseFloat(freight_gst)) / 100;
                    	val = val + gtval;
                    }
					
					var gstTotal="gstTotal_"+index;
					$("#"+gstTotal).html(val.toFixed(2));
					$("#gstTotalAmount_"+index).val(val.toFixed(2));
					grand_tot=parseFloat(grand_tot)+parseFloat(val);
				});
				
				if(freight_gst > 0 && gstFlag == 0){
                	var gtval1 = (parseFloat(freight_charge) * parseFloat(freight_gst)) / 100;
                	
                	var gstTotal1="gstTotal_"+freight_gst;					
					$("#"+gstTotal1).html(gtval1.toFixed(2));
					$("#gstTotalAmount_"+freight_gst).val(gtval1.toFixed(2));
                	
                	grand_tot = parseFloat(grand_tot) + parseFloat(gtval1);
				}
				
			}
			
			$("#grand_total").html(grand_tot.toFixed(2));
			
		});
		
	});	
</script>