<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">			
		<h1 style="float: left;">Generate Quotation</h1> <?php echo $this->breadcrumbs->show(); ?>
	</div>

	<?php if (validation_errors()) : ?>
	<script>
		$(document).ready(function() {
			$("#submit").show();							
		});
	</script>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
				<?php echo validation_errors(); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if (isset($error)) : ?>
		<script>
			$(document).ready(function() {
				$("#submit").show();							
			});
		</script>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php endif; ?>
		
	<script>
		$(document).ready(function() {						
			$("#quotationform").validate({
				rules: {
					customer_name1: "required",				
					//quotation_date: "required",				
					user_id: "required",				
					Currency: "required",				
					Bank: "required",				
					freight_charge: {number: true},				
				},
				messages: {
					product_name: "Please Select product",
					model: "Please Select model",
					batch: "Please Select batch",
					qty: "Please Enter Quntity"				
				}
			})

			$('#submit').click(function(e) {
				$("#submit").hide();
				$(".processing").show();
				setTimeout(function(){
					$(".processing").hide();
					$("#submit").show();		
				}, 10000);
				
				$("#quotationform").valid();				
			});
		});
	</script>

	<style>		
		.prodsc{width:40% !important;}
		.certificate .table td, .certificate .table th{padding:5px;}
		.certificate .table-bordered{border-bottom:0px solid gray;}
	</style>
	<?php if($quotationInfo->is_deleted == 'Y'){ ?>
		<h4 align="center">Quotation Deleted</h4>
	<?php } else { ?>
	<form role="form"  id="quotationform" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" >
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
			
				
				<fieldset class="proinfo">
					<legend>Select Customer</legend>
						<div class="row">
							
							<div class="col-sm-12">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Issue From</b> </label>&nbsp;&nbsp;&nbsp;
										<?php $i=0; foreach($stores as $store){ ?>
									  <input class="form-check-input storeId" type="radio" name="store_id" value="<?php echo $store['store_id']; ?>" required <?php if($i==0){ echo "checked"; } ?>  >  
									  <label class="form-check-label"><?php echo $store['store_name']; ?></label>&nbsp;&nbsp;&nbsp; 
										<?php $i++; } ?>
									  
								</div>								
							</div>
						
							<div class="col-sm-6">						  
							  <div class="form-group auto">
								 <div class="control-label" >Customer Name <span style="color:gray;font-size:14px;">(Search without contact person title)</span></div> 
								 <input type="text" name="customer_name1" value="<?php if($quotationInfo->customer_name) { echo $quotationInfo->customer_name; } ?>" id="customer_name1" class="form-control" autocomplete='off' required>								
							  </div>
							</div>
								<input type="hidden" name="countryId" id="countryId" value="<?php if(!empty($customerInfo->country_id)){ echo $customerInfo->country_id; } ?>">
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Customer Id</div> 
								 <input type="text" name="customer_id" value="<?php if($quotationInfo->customer_id) { echo $quotationInfo->customer_id; } ?>" id="customer_id" class="form-control" readonly>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Quotation No.</div> 
								 <input type="text" name="quotation_no" value="<?php if($quotationInfo->quote_id) { echo getQuotationNo($quotationInfo->quote_id); } else { echo getQuotationNo($lastQuotationId); } ?>" id="quotation_no" class="form-control" autocomplete='off' readonly>
								
							  </div>
							</div>
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Quotation Date</div> 
								 <input type="text" name="quotation_date" value="<?php if($quotationInfo->quotation_date) { echo dateFormat("Y-m-d", $quotationInfo->quotation_date); } else { echo date("Y-m-d"); } ?>" id="quotation_date" class="form-control date" autocomplete='off'>
								
							  </div>
							</div>
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Genrated By</div> 
									<select name="user_id" class="form-control" required>
										<option value=''>Select</option>
										<?php if(isset($users)){ ?>
										<?php foreach($users as $user){ ?>
											
											<option value="<?php echo $user['user_id']; ?>" <?php if(isset($quotationInfo->user_id) && $quotationInfo->user_id == $user['user_id'] ) { echo ' selected="selected"'; } ?>>
											<?php echo $user['firstname']." ".$user['lastname']; ?></option>
											
										<?php } ?>
									<?php } ?>
									</select>								
							  </div>
							</div>
							<div class="col-sm-4">
								<div class="row">
									<div class="col-sm-6">
									  <div class="form-group">
										 <div class="control-label" >Currency</div> 
											<select name="currency_id" id="currency_id" class="form-control" required>
												<option value=''>Select</option>
												<?php if(isset($currencies)){ ?>
												<?php foreach($currencies as $currency){ ?>
													
													<option value="<?php echo $currency['id']; ?>" <?php if(isset($quotationInfo->currency_id) && $quotationInfo->currency_id == $currency['id'] ) { echo ' selected="selected"'; } ?>><?php echo $currency['currency']; ?></option>
													
												<?php } ?>
											<?php } ?>
											</select>								
									  </div>
									</div>
									
									<div class="col-sm-6">
									  <div class="form-group">
										 <div class="control-label" >Quotation valid for (Days)</div> 
											<?php
												$validArr = array('15','30','45','60');
											?>
											<select name="valid_for" id="valid_for" class="form-control" required>
												<?php foreach($validArr as $valid){ ?>
													<option value="<?php echo $valid; ?>" <?php if(!empty($quotationInfo->valid_for) && $quotationInfo->valid_for == $valid){ echo ' selected="selected"';  } else if(empty($quotationInfo->valid_for) && $valid == '45'){ echo ' selected="selected"'; } ?> ><?php echo $valid; ?></option>
												<?php } ?>											
											</select>								
									  </div>
									</div>
									
								</div>
							</div>
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Bank</div> 
								 <select name="bank_id" class="form-control" required>
									<option value=''>Select</option>
									<?php if(isset($banks)){ ?>
									<?php foreach($banks as $bank){ ?>
										
										<option value="<?php echo $bank['id']; ?>" <?php if(isset($quotationInfo->bank_id) && $quotationInfo->bank_id == $bank['id'] ) { echo ' selected="selected"'; } ?>>
										<?php echo $bank['bank_name']." - ".$bank['account_number']; ?></option>
										
									<?php } ?>
									<?php } ?>
								</select>
								
							  </div>
							</div>							
														
							<div class="col-sm-6">						  
							  <div class="form-group">
								 <div class="control-label" >Billing Details</div> 
								 <select name="billing_details_default" id="billing_details_default" class="form-control">
									
								 </select>
								 </br>
								 <textarea name="billing_details" id="billing_details" rows="8"  class="form-control" ><?php if($quotationInfo->billing_details) { echo $quotationInfo->billing_details; } ?></textarea>								
							  </div>
							</div>
							<div class="col-sm-6">						  
							  <div class="form-group">
								 <div class="control-label" >Shipping Details &nbsp;&nbsp; <input type="checkbox" name="same_address" id="same_address"><span style="color:gray;"> Same as Bill Details</span> &nbsp;&nbsp; <a href="#" id="addNewAddress">Add New Address</a> </div> 
								 <select name="shipping_details_default" id="shipping_details_default" class="form-control">									
								 </select>
								 </br>
								 <textarea name="shipping_details" id="shipping_details" rows="8" class="form-control" ><?php if($quotationInfo->shipping_details) { echo $quotationInfo->shipping_details; } ?></textarea>
							  </div>
							</div>
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Delivery</div> 
								 <textarea  name="delivery"  id="delivery" class="form-control " ><?php if($quotationInfo->delivery) { echo $quotationInfo->delivery; } ?></textarea>
								
							  </div>
							</div>
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Insurance</div> 
								 <textarea  name="insurance"  id="insurance" class="form-control " ><?php if($quotationInfo->insurance) { echo $quotationInfo->insurance; } ?></textarea>
								
							  </div>
							</div>
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Terms & Conditions</div> 
								 <textarea  name="terms_conditions" id="terms_conditions" class="form-control " ><?php if($quotationInfo->terms_conditions) { echo $quotationInfo->terms_conditions; } ?></textarea>
								
							  </div>
							</div>						
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Payment Terms</div> 
								 <input type="text" name="payment_terms" value="<?php if($quotationInfo->payment_terms) { echo $quotationInfo->payment_terms; } ?>" id="payment_terms" class="form-control " autocomplete='off' >
								
							  </div>
							</div>
							
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="control-label" >Freight Charge</div> 
								 <input type="text" name="freight_charge" value="<?php if($quotationInfo->freight_charge) { echo $quotationInfo->freight_charge; } ?>" id="freight_charge" class="form-control " autocomplete='off' >
								
							  </div>
							</div>
							
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								 <div class="row">
									
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><b>Discount Type</b></label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="discount_type" value="amt" <?php if($quotationInfo->discount_type == 'amt') { echo "checked"; } ?> > Amount</label>
									</div>
									
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="discount_type" value="per" <?php if($quotationInfo->discount_type == 'per') { echo "checked"; } ?> > Percentage</label>
									</div>
																	
								</div>
								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Pan No.</div> 
								 <input type="text" name="pan_no" value="<?php if($quotationInfo->pan_no) { echo $quotationInfo->pan_no; } ?>" id="pan_no" class="form-control " autocomplete='off' >
								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >GST</div> 
								 <input type="text" name="gst" value="<?php if($quotationInfo->gst) { echo $quotationInfo->gst; } ?>" id="gst" class="form-control " autocomplete='off' >
								
							  </div>
							</div>
							
							<div class="col-sm-8">						  
							  <div class="form-group">
								 <div class="control-label" >Special Instruction</div> 
								 <textarea name="special_instruction" id="special_instruction" class="form-control "  ><?php if($quotationInfo->special_instruction) { echo $quotationInfo->special_instruction; } ?></textarea>								
							  </div>
							</div>
							
							<div class="col-sm-4">						  
							  <div class="form-group">
								<div class="row">
									
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><b>Is Sample</b></label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="checkbox" name="is_sample" id="is_sample" value="1" <?php if($quotationInfo->is_sample == '1') { echo "checked"; } ?>></label>
									</div>
																	
								</div>
								
							  </div>
							</div>
							
							<div class="col-sm-4">
								<div class="control-label" >Certificates</div> 
								<div style="overflow:auto;height:204px;border:1px solid #ced4da;">
									<div class="table-responsive certificate">
										<table class="table table-bordered table-hover">
										  <tbody id="certificatesfilename">
												<?php if($certificates){ ?>
													<?php foreach($certificates as $certificate){  
													
														$expire_date_time = $certificate['expire_date_time']; 
														 $expire_date = date("d-m-Y", strtotime($expire_date_time));
													
													?>
														<tr>
															<td>
																<input type="checkbox" name="certificate_id[]" value="<?php echo $certificate['certificate_id']; ?>" class="certificateId" <?php if(!empty($certificate_id) && is_array($certificate_id)){ if (in_array($certificate['certificate_id'], $certificate_id)){ echo "checked='true'"; } } ?> />															
															</td>
															<td><?php echo $certificate['certificate_name']; ?> ( <span style="font-size:11px;font-style: italic;"><?php echo $expire_date; ?></span> )</td>
														</tr>
													<?php } ?>
												<?php } ?>
										  </tbody>
										</table>
										<div class="control-label" style="padding-left:8px;margin-top:-12px;"><b><a href="#" id="addCertificatePopup">Add New Certificate</a></b></div> 
									</div>	
								</div>	
							</div>
							
							<div class="col-sm-4">
								<!-- <div class="control-label" ><b><a href="#" id="addCertificatePopup">Add Certificate</a></b></div> -->
								<div class="form-group" style="margin-top: 20px;">
									<select name="certificates[]" class="form-control" size="8" id="certificates" multiple=""></select>
								</div>
							</div>
							
						</div>					
				</fieldset>

				<fieldset class="proinfo">
					<legend>Quotation Summary</legend>
					<div  class='table-responsive'>
					<table id="order-list" class=" table order-list">
						<!-- <thead> -->
							<tr >
								<th style="width:25%" >Product#Model</th>								
								<th  style="width:8%">Qty</th>
								<th style="width:16%" >Rate (Per unit with gst)</th>
								<th style="width:35%" >Discount/Unit</th>
								<th style="width:14%" >Total</th>
							</tr>
						<!-- </thead>
						<tbody> -->
							<?php if($quoteProductInfo){ ?>
								<?php foreach($quoteProductInfo as $productInfo){ ?>
								<?php
								$basePrice	= $productInfo['rate'];
								$productGst	= $productInfo['product_gst'];;
								$withGstPrice = $basePrice + ($basePrice * $productGst / 100);
								
								$discount = $productInfo['discount'] + ($productInfo['discount'] * $productGst / 100);
								$netAmount = $productInfo['qty'] * ($withGstPrice - $discount);
								?>								
									<tr class='prolist'>
										<td ><input type="hidden" name="prod_id[]" value="<?php echo $productInfo['prod_id']; ?>"/><?php echo $productInfo['prod_name']; ?> # <?php echo $productInfo['model_name']; ?></td>
										
										<td ><input type="text" autocomplete="off" class="form-control proqty" id="proqty_<?php echo $productInfo['id']; ?>" name="qty[]" value="<?php echo $productInfo['qty']; ?>"/></td>
										
										<td ><input type="text" autocomplete="off" class="form-control proprs price-box" id="proprs_<?php echo $productInfo['id']; ?>" name="price[]" value="<?php echo number_format((float)$withGstPrice, 2, '.', ''); ?>" readonly/></td>
										
										<td><input style="width:40%;float:left;" type="text" autocomplete="off" class="form-control prodsc" id="prodsc_<?php echo $productInfo['id']; ?>" name="discount[]" value="<?php echo number_format((float)$discount, 2, '.', ''); ?>" />
										
										&nbsp;&nbsp; <input style="width:40%;float:left;margin-left:10px;" type="text" class="form-control prodscrate" id="prodscrate_<?php echo $productInfo['id']; ?>" name="discount_rate[]" value="<?php echo number_format((float)$productInfo['discount_per'], 4, '.', ''); ?>" /><span style="vertical-align: -moz-middle-with-baseline;margin-left: -10px;">%</span></td>
										
										<input type="hidden" class="form-control" name="pro_gst[]" value="<?php echo $productInfo['product_gst']; ?>"/>
										<input type="hidden" class="form-control" name="unit_name[]" value="<?php echo $productInfo['unit']; ?>"/>
										<td ><input type="text" class="form-control protot" id="protot_<?php echo $productInfo['id']; ?>" name="total[]" value="<?php echo number_format((float)$netAmount, 2, '.', ''); ?> " readonly /></td>
										<td ><button type="button" class="ibtnDel btn btn-md btn-danger"><i class="fa fa-trash"></i></button></td>
									</tr>										
								<?php } ?>
							<?php } ?>
						 <!-- </tbody> -->
					</table>
					 
					</div>
					<div class="row">
						<div class="col-sm-12">
							<img class="processing float-right" src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading.."><button type="submit" id="submit" class="btn btn-primary float-right"> 
							<?php 
							if($quotationInfo->quote_id){ 
								echo "Save";
							} else {
								echo "Generate Quotation"; 
							}
							?>
							 </button>	
						</div>
					</div>
				</fieldset>				
			</div>			
		</div>
	</form>
	<form role="form"  class="needs-validation" id="addstockform">
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>Select Product</legend>
					<div class="row"  >
						<div class="col-sm-3">						  
							<div class="form-group">
								<div class="control-label">Product Name</div> 
								<input type="text" name="product_name" value="" id="product_name" class="form-control product_name typeahead" autocomplete='off' required>
							</div>
						</div>							
						<div class="col-sm-3">						  
							<div class="form-group">							
								<div class="control-label" >Model</div> 
								<select name="model" id="input-model" class="form-control"></select>
							</div>
						</div>	
						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >Qty</div> 
							<input type="text" name="qty" value="" id="qty" class="form-control" autocomplete='off' required>		
						  </div>
						</div>	
						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >Rate (Per unit with gst)</div> 
							<input type="text" name="price" value="" id="price" class="form-control price-box" autocomplete='off' <?php if($this->session->userdata('group_type') != 'SADMIN'){ echo ' readonly '; }?> required>
							<input type="hidden" name="min_price" value="" id="min_price" class="form-control" autocomplete='off'>
							
						  </div>										
						</div>
						
						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >Discount/Unit</div> 
							<input type="text" name="discount" value="" id="discount" class="form-control" autocomplete='off' >
							<b style="color:red;" id="discountType"></b>
						  </div>										
						</div>

						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >In Stock</div> 
							<!-- <input type="text" name="stock_in" value="" id="stock_in" class="form-control " disabled> -->
							<span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;" id="stock_in"></span>
						  </div>
						</div>
						
						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >GST</div> 
							<input type="text" name="pro_gst" value="" id="pro_gst" class="form-control" style="height: 50px;color:red;" disabled>
							<!-- <span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;" id="pro_gst"></span> -->
						  </div>
						</div>
						
						<div class="col-sm-2">						  
						  <div class="form-group">							
							<div class="control-label" >Unit</div> 
							 <input type="text" name="unit_name" value="" id="unit_name" class="form-control" style="height: 50px;" disabled> 
							<!-- <span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;" id="unit_name"></span> -->
						  </div>
						</div>
						
					
						<!-- <div class="col-sm-3">						  
						  <div class="form-group">
							<div class="control-label" >Last Trade Price </div> 
							<!-- <input type="text" name="ltp" value="" id="ltp" class="form-control " disabled> 
							<span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;" id="ltp"></span>
						  </div>
						</div> -->
						
						<div class="col-sm-3">						  
						  <div class="form-group">							
							<div class="control-label" >Last Trade Price | Date</div> 
							<!-- <input type="text" name="ltd" value="" id="ltd" class="form-control" disabled> -->
							<span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;"><span id="ltp"></span> <span id="ldis"></span></span>
						  </div>
						</div>
						
						<div class="col-sm-3">						  
						  <div class="form-group">
							<div class="control-label" >Trade Range </div> 
							<!-- <input type="text" name="ltp" value="" id="ltp" class="form-control " disabled> -->
							<span class="form-control" style="background-color: #e9ecef;opacity: 1;height: 50px;" ><span id="highest"></span><span id="lowest"></span></span>
						  </div>
						</div>
						
						<div class="col-sm-12">						  
						  <div class="form-group">
							<div class="control-label" >&nbsp;</div>
							<button type="button" id="addrow" class="btn btn-primary float-right"> Add Product</button>
						  </div>									
						</div>
					</div>
				</fieldset>
			 </div>
		  </div>
		  
	</form>
	<div class='mt-3'>	</div>
	<?php } ?>
<script>
	$(document).ready(function() {
		$(".processing").hide();
		$("#addNewAddressForm").validate({
			rules: {
				address_1: "required",				
				country_id: "required",				
				state_id: "required",				
				city: "required",				
				Pin: "required"				
				
			},
			messages: {
				address_1: "Please Enter Address",
				country_id: "Please Select Country ",
				state_id: "Please Select State",
				city: "Please Enter City",
				pin: "Please Enter Pin"
			}
		})
	});
	
	$(document).ready(function() {						
		$("#addstockform").validate({
			rules: {
				product_name: "required",				
				model: "required",				
				qty: {
					required: true,
					number: true
				},					
				price: {
					required: true,
					number: true
				},			
				discount: {number: true}			
			}/* ,
			messages: {
				product_name: "Please Select Product Name",
				model: "Please Select Model",
				qty: "Please Enter Qty",
				price: "Please Enter Price",
				//discount: "Please Enter discount"				
			} */
		})
	});

$(document).ready(function() {	
	var group='<?php echo $this->session->userdata('group_type');?>';
	if( group != 'SADMIN'){
		mrpReadonly();
		$('#currency_id').change(function() {
			mrpReadonly();
		});
	}	
});
function mrpReadonly(){
	if($("#currency_id").val()=='1'){
		$(".price-box").attr("readonly", true); 
	}else{
		$(".price-box").attr("readonly", false); 
	}
}
</script>	
	
<div class="modal fade" id="newAddressmyModal" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New Address</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" enctype="multipart/form-data" id="addNewAddressForm" >
					 <input type="hidden" name="customer_id" value="" id="address_customer_id" class="form-control">
					<div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label" >Address 1</div> 
							<textarea class="form-control text-capitalize" name="address_1" id="address_1" autocomplete="nope" required></textarea>
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label" >Address 2</div> 							
							<textarea class="form-control text-capitalize" name="address_2" id="address_2" autocomplete="nope" ></textarea>
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label" >Country</div> 							
							<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" required>
								<option value="">-- Seclect --</option>
								<?php foreach($countries as $country){ ?>
									<?php $country_id = $customer->country_id; ?>
									<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>										
								<?php } ?>
							</select>
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label">State</div> 
								<select name="state_id" id="state_id" class="form-control text-capitalize" required>
									
								</select>								
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label">District</div> 
							<input type="text" name="district" value="" id="district" class="form-control text-capitalize" autocomplete="nope" required>
							<div class="invalid-feedback">
								Required
							</div>
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label">City</div> 
							<input type="text" name="city" value="" id="city" class="form-control text-capitalize" autocomplete="nope" required>
							<div class="invalid-feedback">
								Required
							</div>
						  </div>
						</div>
						
						<div class="col-sm-6">
						  <div class="form-group">
							<div class="control-label">Pin</div> 
							<input type="text" name="pin" value="" id="pin" class="form-control" autocomplete="nope" required>
							<div class="invalid-feedback">
								Required
							</div>
						  </div>
						</div>

						<div class="col-sm-6"><br>
							<div class="form-group">									
								<button type="button" id="saveAddress" class="btn btn-primary float-right"> Save</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>

<!-- Start certificate Popup design -->
	<div class="modal fade" id="myModalCertificate" role="dialog">
		<div class="modal-dialog" style="max-width: 500px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Certificate</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger-certificate"></div>
			<div class="modal-body" style="padding:2rem;">
				<script src="<?php echo base_url(); ?>assets/script.js"></script>
				<form method="post" action="" enctype="multipart/form-data" id="addnewcertificate" name="addnewcertificate">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Certificate name</div>
								<input type="text" name="certificate_name" value=""  id="certificate_name" class="form-control" required>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Expiry Date</div>
								<input type="text" name="certificate_expiry_date" value=""  id="certificate_expiry_date" class="form-control date" required>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">								
								<!-- <input type="file" name="certificate_file" id="certificate_file"> -->
								
								<input type="file" name="file" id="file" style="margin-top: 15px;" required>
								<!-- <div class="upload-area"  id="uploadfile">
									Upload file
								</div> -->
								<img src="<?php echo base_url(); ?>assets/img/ajax-loader.gif" class="loader" style="display:none;" >
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">	<br>								
								<button type="button" id="addCertificate" class="btn btn-primary float-right">Save</button>
								<div id="uploadtext" style="padding-left: 30px;color:green;"></div>
							</div>
						</div>
					</div>
				</form>
							  
			</div>
		  </div>		  
		</div>
	</div>
	
	<script src="<?php echo base_url(); ?>assets/script.js"></script>	
	<script>
		$(document).ready(function() {
			var quotation_id =  '<?php echo $quotationInfo->quote_id; ?>';
			
			if(quotation_id){
				$(':input[type="submit"]').prop('disabled', false);
			}else {
				$(':input[type="submit"]').prop('disabled', true);
			}
			
			$('input[name="discount_type"]').on("click", function () {
				var discount_type = this.value;
				if(discount_type == 'per'){
					$("#discountType").html("Disc. in Percentage"); 
					$(".prodsc").attr('readonly', true); 
					$(".prodscrate").attr('readonly', false);
				} else if(discount_type == 'amt'){
					$("#discountType").html("Disc. in Amount"); 
					$(".prodscrate").attr('readonly', true);
					$(".prodsc").attr('readonly', false); 
				}
			});	
			
			var discount_type = $("input[name='discount_type']:checked").val();
			if(discount_type == 'per'){
				$("#discountType").html("Disc. in Percentage"); 
				$(".prodsc").attr('readonly', true); 
			} else if(discount_type == 'amt'){
				$("#discountType").html("Disc. in Amount"); 
				$(".prodscrate").attr('readonly', true);
			}
			
			var date_input=$('.date'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({
				dateFormat: 'yy-mm-dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
				changeMonth: true,
				changeYear: true
			});
					
			var counter = 0;
		
			$("#addrow").on("click", function () {				
				if(! $("#addstockform").valid()) return false;
				var pId = $("#input-model :selected").val();
				var d=0;
				var checked =  $("input[name=discount_type]").is(":checked") ;
				if(!checked){
					alert("Please select discount type");
					return false;
				}
							
				$(".prolist").each(function() {
					var prod_id = $(this).find('input[name="prod_id[]"]').val();
					if(prod_id == pId){
						alert("This product has already added into Quotation.");						
						d=1;
					}
				});
				
				var customer_name1 = $("#customer_name1").val();
				if(customer_name1 == ''){					
					$('html, body').animate({
						scrollTop: $("#quotationform").offset().top
					}, 2000);
					alert("Please select Customer");
					return false;
				}
				var currency_id = $("#currency_id").val();
				if(currency_id == ''){
					$('html, body').animate({
						scrollTop: $("#quotationform").offset().top
					}, 2000);
					alert("Please select currency");
					return false;
				}
				
				var qty = $("#qty").val();
				if(qty == '0' || qty == ''){
					alert("Please enter Qty");
					return false;
				}
				var price = $("#price").val();
				var min_price = $("#min_price").val();
				if(parseFloat(price) < parseFloat(min_price)){
					alert("Please enter minimum Rate "+min_price);
					return false;
				}
				var discount = $("#discount").val();
				var discount_type = $("input[name='discount_type']:checked").val();
								
				if(discount == ''){
					discount = 0.0; 
				} else {
				}
				
				var total = $("#price").val();
				var ftotal = total;
				if(discount_type == 'per'){									
					 ftotal = parseFloat(total) - (parseFloat(total) * parseFloat(discount)/100);
					 discount =  (parseFloat(total) * parseFloat(discount)/100);
				} else {
					 ftotal = (parseFloat(total) - parseFloat(discount));
				}
				ftotal = ftotal.toFixed(2);
				ftotal = parseInt(qty) * parseFloat(ftotal);
				
				var currency = $('#currency_id :selected').text();
				var countryId = $("#countryId").val();
				if(currency == 'INR' && countryId == '99'){
					var pro_gst = $("#pro_gst").val();
					/* var checkpro_gst =  confirm('GST is not applied this product');
					if(checkpro_gst == false){
						return false;
					} */
				} 
				
				var unit_name =$("#unit_name").val();				
				if(unit_name == ''){
					alert("Please Select Product Again");
					return false;
				}
				
				var dis = '';
				if(discount_type == 'per'){
					dis = discount.toFixed(2);
				} else {
					dis = discount;
				}
				
				var disRate = 0;
				var discount_rate = $("#discount").val();
				if(discount_rate != ''){
					if(discount_type == 'per'){	
						disRate = discount_rate;
					} else {					
						disRate = (parseFloat(discount_rate) * 100)/parseFloat(total);					
					}
				}
				
				var newRow = $("<tr class='prolist'>");
				var cols = "";
				cols += "<td >"+'<input type="hidden" name="prod_id[]" value="'+$("#input-model :selected").val()+'"/>';
				cols += $("#product_name").val()+" # "+$("#input-model :selected").text()+ "</td>";
				
				cols += '<td ><input type="text" class="form-control proqty" id="proqty_'+$("#input-model :selected").val()+'" name="qty[]" autocomplete="off" value="'+qty+'"/ readonly></td>';				
				cols += '<td ><input type="text" class="form-control proprs" id="proprs_'+$("#input-model :selected").val()+'" name="price[]" autocomplete="off" value="'+price+'"/ readonly></td>';
				cols += '<td ><input style="width:40%;float:left;" type="text" class="form-control prodsc" name="discount[]" autocomplete="off" value="'+dis+'" readonly/> &nbsp;&nbsp; <input style="width:40%;float:left;margin-left:10px;" type="text" class="form-control prodscrate" name="discount_rate[]" value="'+disRate+'" readonly/><span style="vertical-align: -moz-middle-with-baseline;margin-left: -10px;">%</span></td>';
				
				if(currency == 'INR' && countryId == '99'){
					cols += '<input type="hidden" class="form-control" name="pro_gst[]" value="'+pro_gst+'"/>';
				} else {
					cols += '<input type="hidden" class="form-control" name="pro_gst[]" value=""/>';
				}					
				
				cols += '<input type="hidden" class="form-control" name="unit_name[]" value="'+unit_name+'"/>';
				
				cols += '<td ><input type="text" class="form-control" name="total[]"  value="'+ftotal.toFixed(2)+'"/ readonly></td>';
				cols += '<td ><button type="button" class="ibtnDel btn btn-md btn-danger"><i class="fa fa-trash"></i></button></td>';
				
				newRow.append(cols);
				
				if(d == 0){
					$("#order-list").append(newRow);
				}
					
				$("#product_name").val('');
				$("#input-model").val('');
				$("#qty").val('');
				$("#price").val('');
				$("#discount").val('');
				$("#stock_in").html('');
				$("#ltp").html('');
				$("#ldis").html('');
				$("#highest").html('');
				$("#lowest").html('');
				
				$(':input[type="submit"]').prop('disabled', false);
				
			});
			
			$("#order-list").on("click", ".ibtnDel", function (event) {				
				$(this).closest("tr").remove();       
				counter -= 1;
				var count=0;
				$(".prolist").each(function(){
					 count++;
				});
				if(count == 0){
					$(':input[type="submit"]').prop('disabled', true);
				}
			});
			
			$(".proqty").keyup(function(){					
				useonkeybutton(this.id);
			});
			
			 $(".proprs").keyup(function(){
				//useonkeybutton(this.id);	
			});
			
			function useonkeybutton(textboxid){
				//var textboxid = this.id; 
				var result=textboxid.split('_');
				var pro_quote_id = result[1];
				
				var qty = $("#proqty_"+pro_quote_id).val();				
				var price = $("#proprs_"+pro_quote_id).val();
				var discount_type = $("input[name='discount_type']:checked").val();
				var discount = 0;
				//if(discount_type == 'per'){
					discount = $("#prodscrate_"+pro_quote_id).val();					
				/* } else {
					discount = $("#prodsc_"+pro_quote_id).val();
				} */
				
				var total = price;
				var ftotal = total;
				//if(discount_type == 'per'){									
					 ftotal = total - (total * discount/100);					 
					 discount =  (total * discount/100);					 
				//} else {
					 ftotal = (total - discount);
					// discount = (total - discount);
				//}
				
				ftotal = (parseFloat(total) - parseFloat(discount));
				
				ftotal = parseInt(qty) * parseFloat(ftotal);
				
				$("#prodsc_"+pro_quote_id).val(discount.toFixed(2));
				$("#protot_"+pro_quote_id).val(ftotal.toFixed(2));					
			}
			
			
			
			$(".prodscrate").keyup(function(){				
				var result=(this.id).split('_');
				var pro_quote_id = result[1];
				
				var qty = $("#proqty_"+pro_quote_id).val();
				var price = $("#proprs_"+pro_quote_id).val();
				//var discount = $("#prodsc_"+pro_quote_id).val();
				var discount_rate = $("#prodscrate_"+pro_quote_id).val();
				var discount_type = $("input[name='discount_type']:checked").val();
				if(discount_type == 'per'){	
					var total = price;
					var ftotal = total;
					var des = '';
					if(discount_type == 'per'){									
						 ftotal = total - (total * discount_rate/100);					 
						 des =  (total * discount_rate/100);					 
					}					
					ftotal = (parseFloat(total) - parseFloat(des));					
					ftotal = parseInt(qty) * parseFloat(ftotal);
					$("#prodsc_"+pro_quote_id).val(des);
					$("#protot_"+pro_quote_id).val(ftotal.toFixed(2));	
				}				
			});
			
			$(".prodsc").keyup(function(){				
				var result=(this.id).split('_');
				var pro_quote_id = result[1];
				
				var qty = $("#proqty_"+pro_quote_id).val();
				var price = $("#proprs_"+pro_quote_id).val();
				var discount = $("#prodsc_"+pro_quote_id).val();				
				var discount_type = $("input[name='discount_type']:checked").val();
				if(discount_type == 'amt'){	
					
					var total = price;
					var ftotal = total;
					var per = '';
					
					if(discount_type == 'amt'){									
						 per = (discount * 100)/total;					 
					} 
					
					ftotal = (parseFloat(total) - parseFloat(discount));
					
					ftotal = parseInt(qty) * parseFloat(ftotal);
					$("#prodscrate_"+pro_quote_id).val(per);
					$("#protot_"+pro_quote_id).val(ftotal.toFixed(2));	
				}				
			});
			
		});		
	</script>

<script>
    $(document).ready(function () {
		var billing_details = [];
		
		/* $('.product_name').typeahead({			
            source: function (query, result) {				
                $.ajax({
                    url:'<?php echo site_url('getProductName'); ?>',
					data: 'name=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item.product_name;
							//return item.name;
                        }));
                    }
                });
            }
        }); */

		$('.product_name').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getProductName'); ?>';
				var value = $('.product_name').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item.product_name
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				$('#product_name').val(ui.item['label']);
				var value = ui.item['label'];
				$.ajax({
					url:'<?php echo site_url('getProductModel');?>',
					method: 'post',
					data: 'name=' + encodeURIComponent(value), 
					dataType: 'json',
					success: function(response){
						var htm = '<option value="">Select model</option>';					
						$.each(response, function(i,res) {
							htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
						});		
						$("#input-model").html(htm);
					}
				});			
			},
			minLength : 3
		});
		
		$('#customer_name1').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getCustomerName'); ?>';
				var value = $('#customer_name1').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,  
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item['company_name'] + "  |  " +  item['person_title'] + " " + item['contact_person'],
								id: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				if(ui.item['id']){
					$("#pro_gst").val('');			
					$("#unit_name").val('');			
					$("#stock_in").html('');		
					$("#ltp").html('');
					$("#ldis").html('');
					$("#price").val('');
					$("#min_price").val('');
					$("#highest").html('');
					$("#lowest").html('');
					$('#fixdata').prop('title', '');
					
					
					$('#customer_name1').val(ui.item['label']);				
					$('#customer_id').val(ui.item['id']);
					$('#address_customer_id').val(ui.item['id']);
					var customer_id = ui.item['id'];
					
					$.ajax({
						url:'<?php echo site_url('getDefaultAddressCustomerById');?>',
						method: 'post',
						data: 'customer_id=' + customer_id, 
						dataType: 'json',
						success: function(response){
							var htm = '<option value="">Select Address</option>';
							var pan = '';
							var gst_no = '';
							var country_id = '';
							$.each(response, function(i,res) {
								//alert(i);								
								if(i == 0){
									country_id = res.country_id;
								}								
								if(res.pin=='0'){
									res.pin='';
								}
								var address_1 		= (res.address_1) ? res.address_1 : '';
								var address_2 		= (res.address_2) ? ', '+res.address_2 : '';
								var city 			= (res.city) ? ', '+res.city : '';
								var state 			= (res.state_name) ? ', '+res.state_name : '';
								var district 			= (res.district) ? ', '+res.district : '';
								var pin 			= (res.pin) ? ', '+res.pin : '';
								var country 		= (res.country_name) ? ', '+res.country_name : '';
								
								var address = address_1 + address_2 + city + district + state + pin + country;
								htm += '<option value="'+ i +'">'+ address +'</option>';
								
								var company_name1 			= (res.company_name) ? res.company_name : '';
								var contact_person1 		= (res.contact_person) ? "\n" + res.contact_person : '';
								var address_11 				= (res.address_1) ? "\n" + res.address_1 : '';
								var address_21 				= (res.address_2) ? "\n" +res.address_2 : '';
								var city1 					= (res.city) ? "\n" +res.city : '';
								var district1 				= (res.district) ? ", " +res.district : '';
								var state1 					= (res.state_name) ? ", " +res.state_name : '';								
								var pin1 					= (res.pin) ? "\n" +res.pin : '';
								var country1 				= (res.country_name) ? ", " +res.country_name : '';
								
								var mobile1 				= (res.mobile) ? " " + res.mobile : '';
								var phone1 					= (res.phone) ? " " + res.phone : '';
								
								var mob = '';
								if(phone1 && mobile1){ 
									mob = "\nMobile: "+phone1 + ", "+mobile1;
								}else if((phone1) && (mobile1 == '')) {
									mob = "\nMobile: "+phone1;
								} else if((mobile1) && (phone1 == '')){
									mob = "\nMobile: "+mobile1;
								}
																
								var email1 					= (res.email) ? "\nEmail: " +res.email : '';					
							
								var billing_address = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;
								
								billing_details[i]=billing_address; 
								pan 	= res.pan;
								gst_no 	= res.gst;								
							});
							
							$("#billing_details_default").html(htm);
							$("#shipping_details_default").html(htm);
							
							$("#pan_no").val(pan);
							$("#gst").val(gst_no);
							$("#countryId").val(country_id);
							
						}
					});
				}
			},
			minLength : 3
		});
		
		/* $('#customer_name1').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url:'<?php echo site_url('getCustomerName'); ?>',
					type: "POST",
					data: 'name=' + request,  
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {							
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item['company_name'] + "  |  " +  item['person_title'] + " " + item['contact_person'],
								value: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				if(item['value']){
					$('#customer_name1').val(item['label']);				
					$('#customer_id').val(item['value']);
					$('#address_customer_id').val(item['value']);
					var customer_id = item['value'];
					
					$.ajax({
						url:'<?php echo site_url('getDefaultAddressCustomerById');?>',
						method: 'post',
						data: 'customer_id=' + customer_id, 
						dataType: 'json',
						success: function(response){
							var htm = '<option value="">Select Address</option>';
							var pan = '';
							var gst_no = '';
							
							$.each(response, function(i,res) {
								//alert(i);
								if(res.pin=='0'){
									res.pin='';
								}
								var address_1 		= (res.address_1) ? res.address_1 : '';
								var address_2 		= (res.address_2) ? ', '+res.address_2 : '';
								var city 			= (res.city) ? ', '+res.city : '';
								var state 			= (res.state_name) ? ', '+res.state_name : '';
								var district 			= (res.district) ? ', '+res.district : '';
								var pin 			= (res.pin) ? ', '+res.pin : '';
								var country 		= (res.country_name) ? ', '+res.country_name : '';
								
								var address = address_1 + address_2 + city + district + state + pin + country;
								htm += '<option value="'+ i +'">'+ address +'</option>';
								
								var company_name1 			= (res.company_name) ? res.company_name : '';
								var contact_person1 		= (res.contact_person) ? "\n" + res.contact_person : '';
								var address_11 				= (res.address_1) ? "\n" + res.address_1 : '';
								var address_21 				= (res.address_2) ? "\n" +res.address_2 : '';
								var city1 					= (res.city) ? "\n" +res.city : '';
								var district1 				= (res.district) ? ", " +res.district : '';
								var state1 					= (res.state_name) ? ", " +res.state_name : '';								
								var pin1 					= (res.pin) ? "\n" +res.pin : '';
								var country1 				= (res.country_name) ? ", " +res.country_name : '';
								
								var mobile1 				= (res.mobile) ? " " + res.mobile : '';
								var phone1 					= (res.phone) ? " " + res.phone : '';
								
								var mob = '';
								if(phone1 && mobile1){ 
									mob = "\nMobile: "+phone1 + ", "+mobile1;
								}else if((phone1) && (mobile1 == '')) {
									mob = "\nMobile: "+phone1;
								} else if((mobile1) && (phone1 == '')){
									mob = "\nMobile: "+mobile1;
								}
																
								var email1 					= (res.email) ? "\nEmail: " +res.email : '';					
							
								var billing_address = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;
								
								billing_details[i]=billing_address; 
								pan 	= res.pan;
								gst_no 	= res.gst;								
							});
							
							$("#billing_details_default").html(htm);
							$("#shipping_details_default").html(htm);
							
							$("#pan_no").val(pan);
							$("#gst").val(gst_no);
						}
					});
				}
			}
		}); */
		
		$('#billing_details_default').change(function() {
			var item=$(this);			
			var bill_addres = billing_details[item.val()];			
			$("#billing_details").val(bill_addres);
		});
		
		$('#shipping_details_default').change(function() {			
			var item=$(this);
			$("#same_address").prop('checked', false);
			var bill_addres = billing_details[item.val()];			
			$("#shipping_details").val(bill_addres);
		});
		
		$("#same_address").on("click", function () {			
			if($(this).is(":checked")) {
				 $("#shipping_details").val($("#billing_details").val());   
		    } else {
				$("#shipping_details").val('');  
			}			
		});

		var customer_id = '<?php echo $quotationInfo->customer_id; ?>';
		if(customer_id){
			$.ajax({
				url:'<?php echo site_url('getDefaultAddressCustomerById');?>',
				method: 'post',
				data: 'customer_id=' + customer_id, 
				dataType: 'json',
				success: function(response){								
					
					var htm = '<option value="">Select Address</option>';
					
					$.each(response, function(i,res) {
						
					    if(res.pin=='0'){
                            res.pin='';
						}
						var address_1 		= (res.address_1) ? res.address_1 : '';
						var address_2 		= (res.address_2) ? ', '+res.address_2 : '';
						var city 			= (res.city) ? ', '+res.city : '';
						var district 		= (res.district) ? ', '+res.district : '';
						var state 			= (res.state_name) ? ', '+res.state_name : '';
						var pin 			= (res.pin) ? ', '+res.pin : '';
						var country 		= (res.country_name) ? ', '+res.country_name : '';
						
						var address = address_1 + address_2 + city + district + state + pin + country;
						htm += '<option value="'+ i +'">'+ address +'</option>';
						
						var company_name1 			= (res.company_name) ? res.company_name : '';
						var contact_person1 		= (res.contact_person) ? "\n" + res.contact_person : '';
						var address_11 				= (res.address_1) ? "\n" + res.address_1 : '';
						var address_21 				= (res.address_2) ? "\n" +res.address_2 : '';
						var city1 					= (res.city) ? "\n" +res.city : '';						
						var district1 				= (res.district) ? "," +res.district : '';
						var state1 					= (res.state_name) ? "," +res.state_name : '';
						var pin1 					= (res.pin) ? "\n" +res.pin : '';
						var country1 				= (res.country_name) ? "," +res.country_name : '';
						var mobile1 				= (res.mobile) ? " " + res.mobile : '';
						var phone1 					= (res.phone) ? " " + res.phone : '';
						
						var mob = '';
						if(phone1 && mobile1){ 
							mob = "\nMobile: "+phone1 + ", "+mobile1;
						}else if((phone1) && (mobile1 == '')) {
							mob = "\nMobile: "+phone1;
						} else if((mobile1) && (phone1 == '')){
							mob = "\nMobile: "+mobile1;
						}
						
						var email1 					= (res.email) ? "\nEmail: " +res.email : '';						
					
						var billing_address = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;
						
						billing_details[i]=billing_address; 
						
					});
					
					$("#billing_details_default").html(htm); 
					$("#shipping_details_default").html(htm);					
				}
			});
		}
		
		// Add New Address
		$("#addNewAddress").click(function(){
			var customer_id = $("#customer_id").val();
			if(customer_id){
				$("#newAddressmyModal").modal();
			} else {
				alert("Please Select Customer.");
			}
						
		});
		
		$("#saveAddress").click(function(){		
			if(! $("#addNewAddressForm").valid()) return false;
		
			var data_form = $('#addNewAddressForm').serialize();	
			$.ajax({
				url:'<?php echo site_url('addNewAddress'); ?>',
				method: 'post',
				data: data_form, 
				dataType: 'json',
				success: function(response){
					
					var htm2 = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
						$("#alert-danger").html(htm2);	
									
					var address_1 		= (response.address_1) ? response.address_1 : '';
					var address_2 		= (response.address_2) ? ', '+response.address_2 : '';
					var city 			= (response.city) ? ', '+response.city : '';
					var state 			= (response.state_name) ? ', '+response.state_name : '';
					var district 		= (response.district) ? ', '+response.district : '';
					var pin 			= (response.pin) ? ', '+response.pin : '';
					var country 		= (response.country_name) ? ', '+response.country_name : '';

					var address = address_1 + address_2 + district + city + state + pin + country;
					
					var addVal =$("#billing_details_default option").eq(-1).val() ;
					addVal = parseInt(addVal) + 1;
					var htm = '<option value="'+ addVal +'">'+ address +'</option>';				
					$("#billing_details_default option").eq(-1).after(htm);
					$("#shipping_details_default option").eq(-1).after(htm);
					
					var company_name1 			= (response.company_name) ? response.company_name : '';
					var contact_person1 		= (response.contact_person) ? "\n" + response.person_title + " " + response.contact_person : '';
					var address_11 				= (response.address_1) ? "\n" + response.address_1 : '';
					var address_21 				= (response.address_2) ? "\n" +response.address_2 : '';
					var city1 					= (response.city) ? "\n" +response.city : '';						
					var district1 				= (response.district) ? "," +response.district : '';
					var state1 					= (response.state_name) ? "," +response.state_name : '';
					var pin1 					= (response.pin) ? "\n" +response.pin : '';
					var country1 				= (response.country_name) ? "," +response.country_name : '';
					
					var mobile1 				= (res.mobile) ? " " + res.mobile : '';
					var phone1 					= (res.phone) ? " " + res.phone : '';
					
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
					
					billing_details[addVal]=billing_address; 
					
					setTimeout(function(){
						$("#newAddressmyModal .close").click();						
						$("#alert-danger").html('');
					}, 3000);
				}
			});			
		});	
		
		$("#customer_name1").keyup(function(){				
			if(this.value == ''){
				$('#customer_id').val('');
				$("#billing_details").val('');
				$("#shipping_details").val('');
				$("#billing_details_default").html(''); 
				$("#shipping_details_default").html('');
			}
		});
		
    });    
</script>
<script>
$(document).ready(function(){		
	/* $('.product_name').on('autocompletechange change', function () {
		$.ajax({
			url:'<?php echo site_url('getProductModel');?>',
			method: 'post',
			data: 'name=' + encodeURIComponent(this.value), 
			dataType: 'json',
			success: function(response){
				var htm = '<option value="">Select model</option>';					
				$.each(response, function(i,res) {
					htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
				});		
				$("#input-model").html(htm);
			}
		}); 	
	}).change(); */
	
	$('#input-model').change(function() {		
		$("#pro_gst").val('');			
		$("#unit_name").val('');			
		$("#stock_in").html('');		
		$("#ltp").html('');
		$("#ldis").html('');
		$("#price").val('');
		$("#min_price").val('');
		$("#highest").html('');
		$("#lowest").html('');
		$('#fixdata').prop('title', '');
		
		var customer_id = $("#customer_id").val();
		if(customer_id == ''){
		  $("#input-model").val('');
		  $('html, body').animate({
				scrollTop: $("#quotationform").offset().top
			}, 2000);
			alert("Please Select Customer.");			
			return false;		  
		}
		
		var currency_id = $("#currency_id").val();
		if(currency_id == ''){
			$("#input-model").val('');
			$('html, body').animate({
				scrollTop: $("#quotationform").offset().top
			}, 2000);
			alert("Please select currency");
			return false;
		}
	  
	  
	  var product_id = $(this).val(); 
	  var currency = $("#currency_id option:selected").text();
	  var currency_id = $("#currency_id").val();	  
	  var store_id = $('input[name=store_id]:checked').val();
	  
	  var countryID = $("#countryId").val();
		
		$.ajax({
			url:'<?php echo site_url('getProductById');?>',
			method: 'post',
			data: 'product_id=' + product_id + '&customer_id=' + customer_id + '&store_id=' + store_id, 
			dataType: 'json',
			success: function(response){
				
				if(currency == 'INR' && response.gst == ''){
					//alert(response.gst);
					var proname = $("#product_name").val();
					var model = $("#input-model option:selected").text();
					var checkstr =  confirm('GST is not applied on '+proname+' - '+model+'.\n Please confirm if you want.');
					if(checkstr == true){
						if(currency == 'INR' && countryID == '99'){
							$("#pro_gst").val(response.gst);
						} else {
							$("#pro_gst").val('NA');
						}
						$("#unit_name").val(response.unit_name);			
						$("#stock_in").html(response.stock_qty);
						
						$("#ltp").html(response.last_trade_price);
						$("#ldis").html(response.last_discount);
						
						
						$("#highest").html(response.hightest_last_trade_price);
						$("#lowest").html(response.lowest_last_trade_price);
						
						if(currency == 'INR'){					
							$("#price").val(response.mrp);
							//$("#price").val(response.price[currency_id]);
							$("#min_price").val(response.min_price[currency_id]);
						} else {
							$("#price").val(response.price[currency_id]);
							$("#min_price").val(response.min_price[currency_id]);
						}
					} else {
						$("#product_name").val('');
						$("#input-model").html('');
						return false;
					}
				} else {
					//$("#pro_gst").val(response.gst);
					if(currency == 'INR' && countryID == '99'){
						$("#pro_gst").val(response.gst);
					} else {
						$("#pro_gst").val('NA');
					}
					$("#unit_name").val(response.unit_name);			
					$("#stock_in").html(response.stock_qty);
					
					$("#ltp").html(response.last_trade_price);
					$("#ldis").html(response.last_discount);
					
					
					$("#highest").html(response.hightest_last_trade_price);
					$("#lowest").html(response.lowest_last_trade_price);
					
					if(currency == 'INR'){					
						$("#price").val(response.mrp);
						//$("#price").val(response.price[currency_id]);
						$("#min_price").val(response.min_price[currency_id]);
					} else {
						$("#price").val(response.price[currency_id]);
						$("#min_price").val(response.min_price[currency_id]);
					}
				}
			}
		}); 
	});

	$("#product_name").on("change", function () {			
		var store_id = $(this).val();		
		$('#input-model').val('');		
		$('#stock_in').html('');		
		$('#ltp').html('');		
		$('#ldis').html('');		
		$('#unit_name').html('');		
		$('#qty').val('');		
		$('#price').val('');		
		$('#discount').val('');	
		$("#highest").html('');
		$("#lowest").html('');
	});

	$(".storeId").on("change", function () {			
		var store_id = $(this).val();		
		$('#input-model').val('');		
		$('#stock_in').html('');		
		$('#ltp').html('');		
		$('#ldis').html('');		
		$('#unit_name').html('');		
		$('#qty').val('');		
		$('#price').val('');		
		$('#discount').val('');	
		$("#highest").html('');
		$("#lowest").html('');
	});
	
	
	
	
	var certificateIdArr = <?php echo json_encode($certificate_id); ?>;
	
	jQuery.each(certificateIdArr, function(index, item) {
		$.ajax({
			url:'<?php echo site_url('ajaxGetCertificateBuyId'); ?>',
			method: 'post',
			data: {certificate_id: item},
			dataType: 'json',
			success: function(response){
				var id = response.certificate_id;
				var name = response.certificate_name;
				var html = '<option value="'+ id +'">'+ name +'</option>'
				$("#certificates").append(html);
			}
		});
	});
	
	/* Add Certificate  */

	$("#addCertificatePopup").click(function(){
		//$(".loader").hide();
		$("#myModalCertificate").modal();
	});

	$("#addCertificate").click(function(){		
		$("#addCertificate").hide();
		$("#uploadtext").html("Uploading Certificate...");
		if(! $("#addnewcertificate").valid()) return false;
		
		var certificate_name = $("#certificate_name").val();
		var certificate_expiry_date = $("#certificate_expiry_date").val();		
		var dataString = 'certificate_name='+ certificate_name + '&certificate_expiry_date=' + certificate_expiry_date;
		
		var fd = new FormData();
		fd.append('certificate_name', certificate_name);
		fd.append('certificate_expiry_date', certificate_expiry_date);
		var files = $('#file')[0].files[0];
		fd.append('file',files);
 		
		$.ajax({
			url:'<?php echo site_url('product/addCertificate'); ?>',
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function(response){

				 $("#alert-danger-certificate").html('');
				
				var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
				$("#alert-danger-certificate").html(htm);
									
				var html1 = '<tr><td><input type="checkbox" name="certificate_id[]" value='+response.id+' class="certificateId"></td><td>'+response.name+' ( <span style="font-size:11px;font-style: italic;">'+response.date_time+'</span> )</td></tr>';
				
				$("#certificatesfilename").append(html1);				
				
				setTimeout(function(){
					$("#myModalCertificate .close").click();					
					$("#uploadtext").html("");
					$("#certificate_name").val('');
					$("#certificate_expiry_date").val('');
					$("#file").val('');
					$("#alert-danger-certificate").html('');
					$("#addCertificate").show();
				}, 3000);
				
				//$("#addCertificate").attr("disabled", true);
				
			}
		});
	});
	
	/* $("#file").change(function(){
		var base_url = '<?php echo base_url(); ?>'+'index.php/fileupload';		
		var fd = new FormData();
		var files = $('#file')[0].files[0];
		fd.append('file',files);
		
		$.ajax({
			url: base_url,
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			dataType: 'json',				
			success: function(response){
				if(response){
					//alert("Upload file Successful.");
				}
			}
		});			
	}); */		
	
});

$(document).on("click", ".certificateId" , function() {
	//$(".certificateId").click(function(){		
		if($(this).is(':checked')){ 
			var certificate_id = $(this).val();
			
			$.ajax({
				url:'<?php echo site_url('ajaxGetCertificateBuyId'); ?>',
				method: 'post',
				data: {certificate_id: certificate_id},
				dataType: 'json',
				success: function(response){
					var id = response.certificate_id;
					var name = response.certificate_name;
					var html = '<option value="'+ id +'">'+ name +'</option>'
					$("#certificates").append(html);
				}
			});
		} else {
			var certificate_id = $(this).val();
			$("#certificates option[value='"+certificate_id+"']").remove();
		}
	});
</script>	
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<script>
$(document).ready(function(){
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };
}(jQuery));

// Install input filters.
/* $("#intTextBox").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
$("#uintTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
$("#floatTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); }); */
  </script>
</div>