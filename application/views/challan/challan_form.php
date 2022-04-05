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
				sli_id: "required",								
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
			<div style="margin-left:15px;">Outstanding Balance : <b><?php echo $outstand_balance; ?></b></div>
			<div class="col-sm-12">
				<?php if(($customerInfo->store_id > 0) && ($customerInfo->customer_id == $this->config->item('allahabad_customer_id') || $customerInfo->customer_id == $this->config->item('delhi_customer_id'))){ ?>
				<p style="color:red;"><b>This challan will be used for Inter Store Transfer.</b></p>
				<?php } ?>
				<fieldset class="proinfo">
					<legend>Create Challan</legend>
						<div class="row">
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Store</b> </label>&nbsp;&nbsp;&nbsp;
										<?php $i=0; foreach($stores as $store){ ?>
									  <input class="form-check-input storeId" type="radio" name="store_id" value="<?php echo $store['store_id']; ?>" required <?php if($store_id==$store['store_id']){ echo "checked"; }elseif($i==0){echo "checked";} ?>  >  
									  <label class="form-check-label"><?php echo $store['store_name']; ?></label>&nbsp;&nbsp;&nbsp; 
										<?php $i++; } ?>									  
								</div>								
							</div>
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Challan Type</b> </label>&nbsp;&nbsp;&nbsp;
										
									  <input class="form-check-input" type="radio" name="challan_type" value="Domestic" <?php echo set_radio('challan_type', 'Domestic'); ?>  required>
									  <label class="form-check-label">Domestic</label>&nbsp;&nbsp;&nbsp; 
									  
									  <input class="form-check-input" type="radio" name="challan_type" value="Export" <?php echo set_radio('challan_type', 'Export'); ?>  required>
									  <label class="form-check-label">Export</label>&nbsp;&nbsp;&nbsp;
								</div>
								<div class="error errorTxt3"></div>
							</div>
							
							<div class="col-sm-4">						  
								<div class="form-check form-check-inline">
									<label class="form-check-label"><b>Bank Name</b> </label>:&nbsp; <span id="bank_name"><?php echo $bankInfo->bank_name; ?></span>									
									  &nbsp;&nbsp;&nbsp;									  
									  <input class="form-check-input" type="radio" name="conf" value="1" required >  
									  <label class="form-check-label">Yes</label>&nbsp;&nbsp;&nbsp; 
									  <input class="form-check-input" type="radio" name="conf" value="0" required >  
									  <label class="form-check-label">No</label>&nbsp;&nbsp;&nbsp; 
								</div>
								<div class="error errorTxt2"></div>
								<input type="hidden" name="bank_id" id="bank_id" value="<?php echo $bankInfo->id; ?>">								
							</div>
							
						</div>
						<br>
						<div class="row">
						
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Challan No</div> 
								 <input type="text" name="Challan_no" value="<?php echo getChallanNo($lastChallanId); ?>" id="Challan_no" class="form-control" autocomplete='off' readonly>								
							  </div>
							</div>
								
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Challan Date</div> 
								 <input type="text" name="challan_date" value="<?php echo set_value('challan_date'); ?>" id="challan_date" value="" class="form-control date" autocomplete='off' required>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Manual Challan No</div> 
								 <input type="text" name="manual_challan_no" value="<?php echo set_value('manual_challan_no'); ?>" id="manual_challan_no" class="form-control" autocomplete='off' >								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Manual Challan Date</div> 
								 <input type="text" name="manual_challan_date" value="<?php echo set_value('manual_challan_date'); ?>" id="manual_challan_date" class="form-control date" autocomplete='off'>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Method Of Shipment</div> 
								 <!-- <input type="text" name="method_of_shipment" value="<?php echo set_value('method_of_shipment'); ?>" id="method_of_shipment" class="form-control" autocomplete='off'> -->
								<select name="sli_id" id="sli_id" class="form-control" required>
									<option value="">-- Select --</option>
									<?php foreach($carriers as $carrier){ ?>
										<option value="<?php echo $carrier['sli_id']; ?>" <?php if($carrier['sli_id'] == $customerInfo->sli_id){ echo ' selected="selected"'; } ?> ><?php echo $carrier['sli_name']; ?></option>
									<?php } ?>
									<option value="addCarrier" style="color: #007bff;">Add Carrier</option>
								</select>
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Account Number</div> 
								 <input type="text" name="account_number" value="<?php if($customerInfo->account_number) { echo $customerInfo->account_number; } else { echo set_value('account_number'); } ?>" id="account_number" class="form-control">
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Date Of Shipment</div> 
								 <input type="text" name="date_of_shipment" value="<?php echo set_value('date_of_shipment'); ?>" id="date_of_shipment" class="form-control date" autocomplete='off'>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >SB Number</div> 
								 <input type="text" name="sb_number" value="<?php echo set_value('sb_number'); ?>" id="sb_number" class="form-control" autocomplete='off'>								
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Docket No.</div> 
								 <input type="text" name="docket_no" value="<?php echo set_value('docket_no'); ?>" id="docket_no" class="form-control" autocomplete='off'>								
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
							
							<div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Invoice No</div> 
									 <input type="text" name="invoice_no" value="<?php echo set_value('invoice_no'); ?>" id="invoice_no" class="form-control" autocomplete='off'>								
								  </div>
							</div>
							
							<div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Invoice Date</div> 
									 <input type="text" name="invoice_date" value="<?php echo set_value('invoice_date'); ?>" id="invoice_date" class="form-control date" autocomplete='off'>								
								  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Sales Person</div> 
									<select name="user_id" class="form-control">
										<option value=''>-Select-</option>
										<?php if(isset($users)){ ?>
										<?php foreach($users as $user){ ?>											
											<option value="<?php echo $user['user_id']; ?>" <?php if(($user['user_id'] == $_SESSION['user_id']) || ($user['user_id'] == set_value('user_id'))) { echo ' selected="selected"'; } ?>>
											<?php echo $user['firstname']." ".$user['lastname']; ?></option>											
										<?php } ?>
									<?php } ?>
									</select>								
							  </div>
							</div>	
							
							<div class="col-sm-2">	
								  <div class="form-group">
									 <div class="control-label" >Packer's Name</div> 
										<select name="packer_id" class="form-control">
											<option value=''>-Select-</option>
											<?php if(isset($packers)){ ?>
												<?php foreach($packers as $packer){ ?>												
													<option value="<?php echo $packer['packer_id']; ?>" <?php if(isset($packer['packer_id']) && $packer['packer_id'] == set_value('packer_id')) { echo ' selected="selected"'; } ?> ><?php echo $packer['packer_full_name']; ?></option>											
												<?php } ?>
											<?php } ?>
										</select>									
								  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" >Customer(Bill to):</div>
									<select name="billing_details_default" id="billing_details_default" class="form-control">
										<option value="">-- Select --</option>
										<?php $i=1; foreach($addresses as $address){ ?>							
											<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
										<?php $i++; } ?>
									</select>
								</div>
								<div class="form-group">
									<textarea name="billing_details" id="billing_details" rows="8"  class="form-control" required><?php if($orderInfo->billing_details) { echo $orderInfo->billing_details; } ?></textarea>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" >Customer(Ship to): &nbsp;&nbsp; <input type="checkbox" name="same_address" id="same_address"><span style="color:gray;"> Same as Bill Details</span></div>
									<select name="shipping_details_default" id="shipping_details_default" class="form-control">	
										<option value="">-- Select --</option>
										<?php $i=1; foreach($addresses as $address){ ?>							
											<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
										<?php $i++; } ?>
									</select>
								</div>
								<div class="form-group">
									<textarea name="shipping_details" id="shipping_details" rows="8" class="form-control" required><?php if($orderInfo->shipping_details) { echo $orderInfo->shipping_details; }  ?></textarea>
								</div>				
							</div>				
							
							<div class="col-sm-12">
								<div class="form-group">
									<div class="control-label" >Terms of Payments:</div>
									<textarea name="payment_terms" id="payment_terms" class="form-control"><?php if($orderInfo->payment_terms) { echo $orderInfo->payment_terms; } else if(set_value('payment_terms')){ echo set_value('payment_terms'); } ?></textarea>
								</div>
							</div>
						</div>
						<input type="hidden" name="country_id" id="country_id" value="<?php echo $customerInfo->countryId; ?>">
						<br>
						<div class="errorTxt"></div>
						<div class="row">
							<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
								<tr>
									<th class="" >S.N.</th>
									<th class="" >Product Description</th>
									<th class="" >Batch&nbsp;Selection&nbsp;&nbsp;</th>
									<th class="" >HSN</th>
									<th class="" >Ordered Qty</th>
									<th class="" >Pending Qty</th>
									<th class="" >Unit</th>								
								</tr>
								
								<?php
									$net_total = 0;
									$i=1;
									
									foreach($orderProducts as $orderProduct){ 
										$net_total = $net_total + $orderProduct['net_amount'];
										if(($orderInfo->currency == 'INR') && ($customerInfo->countryId == '99')){
											$totgst = ($orderProduct['net_amount'] * $orderProduct['product_gst'])/100;	
										}									
										$orderQty = $orderProduct['qty'] - $orderProduct['challan_qty'];
								?>	
									
									<tr class="ordpro <?php if($orderQty == 0){ echo "alert-success"; } ?>" data-toggle="tooltip" title="<?php //if($orderProduct['challan_id']){ echo "challan Already Created"; } ?>" >
									
										<?php if(($orderInfo->currency == 'INR') && ($customerInfo->countryId == '99')){ ?>
											<input type="hidden" name="totalgst[]" id="totalgst_<?php echo $orderProduct['prod_id']; ?>" value="<?php echo $totgst; ?>">
											<input type="hidden" name="gstper[]" id="gstper_<?php echo $orderProduct['prod_id']; ?>" value="<?php echo $orderProduct['product_gst']; ?>">
										<?php } ?>										
										
										<input type="hidden" name="nettot[]" id="nettot_<?php echo $orderProduct['prod_id']; ?>" value="<?php echo $orderProduct['net_amount']; ?>">
									
										<td class=" "><input type="checkbox" name="product_id[]" class="procheckbox" id="pro_<?php echo $orderProduct['prod_id'];?>" value="<?php echo $orderProduct['prod_id'];?>" <?php if($orderQty == 0) { echo "disabled"; } ?> required>&nbsp;&nbsp;<?php echo $i; ?></td>
										<td class=" "><b><?php echo $orderProduct['model_name']; ?></b> | <?php echo $orderProduct['description']; ?></td>
										<td class=" ">Auto <input type="radio" name="batchselect_<?php echo $orderProduct['prod_id'];?>" class="batch_select" value="auto" id="bts_<?php echo $orderProduct['prod_id'];?>" checked <?php if($orderQty == 0) { echo "disabled"; } ?>> Manual <input type="radio" name="batchselect_<?php echo $orderProduct['prod_id'];?>" class="batch_select" value="manual" id="bts_<?php echo $orderProduct['prod_id'];?>" <?php if($orderQty == 0) { echo "disabled"; } ?>> </td>
										<td class=" "><?php echo $orderProduct['hsn']; ?></td>
										<td class=" "><?php echo $orderProduct['qty']; ?></td>
										<td class=" "><?php if($orderQty > 0){ echo $orderQty;  } else { echo 0; } ?></td>
										<td class=" "><?php echo $orderProduct['unit']; ?></td>					
									</tr>								
								<?php $i++; } ?>					
								
							</table>
						</div>
						<br>
						
						<div class="row">	
							<table class="table-sm table-bordered" id="protbl" width="100%" cellspacing="0">
								<tr>									
									<th class="" style="width:30%;">Product Description</th>
									<th class="" style="width:10%;">HSN</th>
									<th class="" style="">Unit</th>
									<th class="" style="">Qty</th>
									<th class="" style="">Rate</th>
									<th class="" style="">Batch No</th>									
									<th class="" style="width:12%;">Mfg Dt./Exp Dt.</th>									
									<th class="" style="">Discount/Unit</th>									
									<th>Net Amount</th>									
								</tr>
								
								<tbody id="productBatch">
									
								</tbody>
								
								
								<tr>									
									<td colspan="8" align="right">Net Total</td>									
									<td align="right" id="netTotal"></td>									
								</tr>
								
								<?php
									$value = array_sum(array_column($freightCharges,'freight_charges'));									
									if($orderInfo->freight_charge){
										$fatchrg = $orderInfo->freight_charge - $value;										
									} else {
										$fatchrg = 0;
									}									
								?>
								
								<tr>
									<td align="Left">Freight Charges Adviced : <?php echo $orderInfo->freight_charge; ?></td>									
									
									<td colspan="6" >Please Enter Freight Charges : <input type="text" autocomplete="off" name="freightcharges" id="freightchargesInput" style="width:100px;border: 1px solid gray;" value="<?php if($fatchrg > 0){ echo $fatchrg; } else { echo 0; }; ?>" ></td>
									<td align="right">Freight Charges</td>									
									<td align="right" id="freight_charges"><?php if($fatchrg > 0){ echo $fatchrg; } else { echo 0; }; ?></td>									
								</tr>
								
								<tbody id="gstcalculation">									
								</tbody>			
							
						
								<tr>									
									<td colspan="8" align="right">Grand Total</td>									
									<td align="right" id="grand_total"></td>									
								</tr>
								
							</table>							
						</div>
						<br>						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<?php if(!empty($freightChargesList)){ ?>
										<p style="margin-bottom:0px;font-weight:600;">Freight Charge Summary <a href="#" id="viewFrtchrg" title="Freight Charge Summary"><i class="fas fa-eye"></i></a></p>										
									<?php } ?>
								</div>
							</div>	
							
							<div class="col-sm-6">
								<div class="form-group">									
									<img class="processing float-right" src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading.."><button type="submit" id="saveChallan" class="btn btn-primary float-right">Create Challan</button>	
								</div>
							</div>	
						</div>	
				</fieldset>	
				
			</div>			
		</div>
	</form>
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="max-width: 700px;">	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Batch List</h4>
		  <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>			  
		</div>
		<div id="alert-danger"></div>
		<div class="modal-body" style="padding-left:2rem;padding-right:2rem;">
			<div class="row">
				<table class="table-sm table-bordered"  width="100%" cellspacing="0">
					<tr>									
						<th>Product Description</th>
						<th>Ordered Qty</th>																			
					</tr>
					<tr>
						<input type="hidden" name="batchListProId" id="batchListProId" value="">
						<td id="pro_des"></td>
						<td id="pro_qty"></td>													
					</tr>				
				</table>
			</div><br>
			<form name="batchlistform" id="batchlistform" method="post" action="">
				<input type="hidden" name="order_pro_qty" id="order_pro_qty" value="">				
				<div class="row">					
					<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">					
						<tr>									
							<th class="" style="width:40%">Batch List</th>
							<th class="" style="width:20%">Store Name</th>
							<th class="" style="">Expiry</th>
							<th class="" style="">Available Stock</th>
							<th class="" style="">Qty</th>													
						</tr>
						<tbody id="batchlist">																			
						</tbody>	
					</table>				
				</div>
				<br>
				<!-- <div class="float-left">
					<button type="button" class="btn btn-primary" id="addExpiryBatchList" >Show More Batches</button>
				</div> -->
				<div class="float-right">
					<button type="button" class="btn btn-primary" id="addBatchList" >Add</button>
				</div>
			</form>
		</div>
	  </div>	  
	</div>
</div>


<div class="modal fade" id="myModal2" role="dialog" >
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Freight Charge Summary</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			
			<div class="modal-body">
					<?php if(!empty($freightChargesList)){ ?>										
						<table class="table-sm table-bordered" align="center" cellspacing="0">
							<thead>
								<tr>
									<th>Challan No</th>
									<th>Freight Charge</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($freightChargesList as $frgChrg){ ?>
									<tr>
										<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $frgChrg['challan_id']; ?>" ><?php echo getChallanNo($frgChrg['challan_id']); ?></a></td>
										<td><?php echo $frgChrg['freight_charges']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
			</div>
		</div>				  
	</div>
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

<div class="modal fade" id="myModalCarriers" role="dialog">
	<div class="modal-dialog" style="max-width: 600px;">		
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Add Carrier</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
		</div>
		<div id="alert-danger12"></div>
		<div class="modal-body" style="padding:2rem;">
			<form method="post" action="" enctype="multipart/form-data" id="addnewCarrier" name="addnewCarrier">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="control-label">Carrier name</div>
							<input type="text" name="sli_name" value=""  id="sli_name" class="form-control" required>								
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="control-label">Account number for Tarun Enterprises</div>
							<input type="text" name="sli_account_number" value=""  id="sli_account_number" class="form-control" >								
						</div>
					</div>						
					<div class="col-sm-12">
						<div class="form-group">									
							<button type="button" id="addCarrier" class="btn btn-primary float-right">Save</button>	
						</div>
					</div>
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
			changeMonth: true,
			changeYear: true
		});
		// End Date time
		
		// Get product Batch
		$('.procheckbox').click(function() {
			$(".errorTxt").html('');
			var currency = '<?php echo $orderInfo->currency; ?>';
			var country_id = '<?php echo $customerInfo->countryId; ?>';
			if($(this).prop("checked") == true){
				var product_id = $(this).val();				
				var batch_select = $("#bts_"+product_id).val();
				$("#bts_"+product_id).prop("checked", true);
				if(batch_select == 'auto'){
					var order_id = $("#order_id").val();
					var store_id = $('input[name=store_id]:checked').val();				
					$.ajax({
						url:'<?php echo site_url('getProductBatch');?>',
						method: 'post',					
						data: {product_id: product_id, order_id: order_id, store_id: store_id},
						dataType: 'json',
						success: function(response){
							    
								if(!(response.batch_error)){
									var htm = "";
									var netTot = '';
									if(response.list == undefined){
										alert("No Batch Available for this product.");
										$("#pro_"+product_id).prop("checked", false);
										return false;
									}
									$.each(response.list, function(i,res) {
										
										htm += "<tr class='prtr' data-val='"+ product_id +"'>";
										
										htm += "<input type='hidden' name='productid[]' value='"+res.product_id+"'>";
										htm += "<input type='hidden' name='batch_id[]' value='"+res.batch_id+"'>";
										htm += "<input type='hidden' name='qty[]' value='"+res.qty+"'>";
										htm += "<input type='hidden' name='rate[]' value='"+res.rate+"'>";
										htm += "<input type='hidden' name='discount[]' value='"+res.discount+"'>";
										htm += "<input type='hidden' name='net_total[]' value='"+res.net_total+"'>";
										if((currency == 'INR') && (country_id == '99')){
											htm += "<input type='hidden' name='gstRate[]' value='"+res.gst_rate+"'>";
										}									
										htm += "<td><b>"+res.model_name+"</b> | "+res.description+"</td>";
										htm += "<td>"+res.hsn+"</td>";
										htm += "<td>"+res.pack_unit+"</td>";
										htm += "<td>"+res.qty+"</td>";
										htm += "<td>"+res.rate+"</td>";
										htm += "<td>"+res.batch_no+"</td>";
										htm += "<td>"+res.mfg_date+"/"+res.exp_date+"</td>";
										htm += "<td>"+res.discount+"</td>";
										htm += "<td align='right'>"+res.net_total+"</td>";
										htm += "</tr>";
										
										netTot = parseFloat(netTot) + parseFloat(res.net_total);
									});
									
									$('#productBatch').append(htm);
									
									
									var total = 0;									
									var gstArr = {};
									$('.prtr').each(function(){
										var pro_id = $(this).find('input[name="productid[]"]').val();							
										var gstRate = $(this).find('input[name="gstRate[]"]').val();							
										var	net_total = $(this).find("td:last").html();
										
										
										if(gstArr[gstRate]==null){
											gstArr[gstRate]=0.00;
										}
										//if(currency == 'INR'){
										if((currency == 'INR') && (country_id == '99')){
											var gstAmount= (net_total*gstRate)/100;								
											gstArr[gstRate] =  parseFloat(gstArr[gstRate]) + parseFloat(gstAmount);
										}
										
										total = parseFloat(total) + parseFloat(net_total);
										
									});
									
									
									//var freightCharges = response.freight_charges;	
									var freightCharges = $('#freightchargesInput').val();
									var freight_gst = response.freight_gst;
									
									var gsttot = 0.00;
									//if(currency == 'INR'){
									if((currency == 'INR') && (country_id == '99')){
										var htm2 = '';
										var perProFrch = 0;
										var gstFlag = 0;
										$.each(gstArr , function(index, val) {
										    
											//perProFrch = (parseFloat(freightCharges) / parseFloat(total)) * parseFloat(val);						
											//val = parseFloat(perProFrch) + parseFloat(val);
											if(isNaN(val)) {
                    							val = 0.00;
                    						}
                    						
                    						if(freight_gst == index){
											    gstFlag = 1;
											    var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
											    val = val + gtval;
											}
                    						
                    						
											htm2 += "<tr>";
											//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
											htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
											htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
											htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
											htm2 += "</tr>";
											
											
											
										    gsttot = parseFloat(gsttot) + parseFloat(val);
										});		
										
										if(freight_gst > 0 && gstFlag == 0){
										    var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
										    htm2 += "<tr>";
											//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
											htm2 += "<input type='hidden' name='gst_total_amount["+freight_gst+"]' value="+parseFloat(gtval).toFixed(2)+">";
											htm2 += "<td colspan='8' align='right'>GST @ "+freight_gst+"%</td>";
											htm2 += "<td align='right' id='gst_"+freight_gst+"'>"+parseFloat(gtval).toFixed(2)+"</td>";
											htm2 += "</tr>";
											
											gsttot = parseFloat(gsttot) + parseFloat(gtval);
										}
										
										$('#gstcalculation').html(htm2);
									}									
									
									
									$('#netTotal').html(total.toFixed(2));
									
									var grand_total = parseFloat(total) + parseFloat(freightCharges) + parseFloat(gsttot);
									if(isNaN(grand_total)) {
            							grand_total = 0.00;
            						}
									$('#freight_charges').html(freightCharges);
									$('#freightchargesInput').val(freightCharges);
									$('#grand_total').html(grand_total.toFixed(2));
									
								} else {
									alert(response.batch_error);
								} 	
													
						}
					});
				}
				
			} else if($(this).prop("checked") == false) {
				
				var uncheckval = $(this).attr('checked',false).val();				
				$(".prtr").each(function(){
					$("#protbl").find("[data-val='"+ uncheckval +"']").remove();					
				});
				
				//if(currency == 'INR'){
				if((currency == 'INR') && (country_id == '99')){
					var gstArr = {};
					$('input[name="product_id[]"]').each(function(){
						if (this.checked) {
							var pId = this.value;
							
							var gstper = $("#gstper_"+pId).val();
							var protgst = $("#totalgst_"+pId).val();										
							if(gstArr[gstper]==null){
								gstArr[gstper]=0.00;
							}										
							gstArr[gstper]=parseFloat(gstArr[gstper])+parseFloat(protgst);										
						}
					});
				}
				var freightCharges1 = $("#freightchargesInput").val();
				//var freightCharges = response.freight_charges;
				var freight_gst = response.freight_gst;
				var net_total1 = '';
				var total1 = 0;
				$(".prtr").each(function(){				
					net_total1 = $(this).find("td:last").html();
					total1 = parseFloat(total1) + parseFloat(net_total1);
				});	
				
				var gsttot = 0.00;
				//if(currency == 'INR'){
				if((currency == 'INR') && (country_id == '99')){
					var htm2 = '';
					var perProFrch = 0;
					var gstFlag = 0;
					$.each(gstArr , function(index, val) {						
						//perProFrch = (parseFloat(freightCharges1) / parseFloat(total1)) * parseFloat(val);						
						//val = parseFloat(perProFrch) + parseFloat(val);
						if(isNaN(val)) {
    							val = 0.00;
    						}
    						
    					if(freight_gst == index){
                        	gstFlag = 1;
                        	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                        	val = val + gtval;
                        }
    						
						htm2 += "<tr>";
						//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
						htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
						htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
						htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
						htm2 += "</tr>";
						
					    gsttot = parseFloat(gsttot) + parseFloat(val);
					});	
					
					if(freight_gst > 0 && gstFlag == 0){
                    	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                    	htm2 += "<tr>";
                    	//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
                    	htm2 += "<input type='hidden' name='gst_total_amount["+freight_gst+"]' value="+parseFloat(gtval).toFixed(2)+">";
                    	htm2 += "<td colspan='8' align='right'>GST @ "+freight_gst+"%</td>";
                    	htm2 += "<td align='right' id='gst_"+freight_gst+"'>"+parseFloat(gtval).toFixed(2)+"</td>";
                    	htm2 += "</tr>";
                    	
                    	gsttot = parseFloat(gsttot) + parseFloat(gtval);
                    }
					
					
					$('#gstcalculation').html(htm2);
				}				
				
				$('#netTotal').html(total1.toFixed(2));
				
				var grand_total1 = parseFloat(total1) + parseFloat(freightCharges1) + parseFloat(gsttot);
				if(isNaN(grand_total1)) {
						grand_total1 = 0.00;
					}
				$('#freight_charges').html(freightCharges1);
				$('#freightchargesInput').val(freightCharges1);
				$('#grand_total').html(grand_total1.toFixed(2));
				
			}
		});
		
		$('.batch_select').on('change', function() {
			$("#addExpiryBatchList").attr("disabled", false);
			var currency = '<?php echo $orderInfo->currency; ?>';
			var country_id = '<?php echo $customerInfo->countryId; ?>';
			var store_id = $('input[name=store_id]:checked').val();	
			var batch_select = $(this).val();
			var order_id = $("#order_id").val();
			var result = (this.id).split('_');
			var product_id =  result[1];
			$("#pro_"+product_id).prop("checked", true);
			if(batch_select == 'manual'){
				$("#addBatchList").attr("disabled", false);			
				$(".prtr").each(function(){
					$("#protbl").find("[data-val='"+ product_id +"']").remove();					
				});
				
				/* if(currency == 'INR'){
					var gstArr = {};
					$('input[name="product_id[]"]').each(function(){
						if (this.checked) {
							var pId = this.value;
							
							var gstper = $("#gstper_"+pId).val();
							var protgst = $("#totalgst_"+pId).val();										
							if(gstArr[gstper]==null){
								gstArr[gstper]=0.00;
							}										
							gstArr[gstper]=parseFloat(gstArr[gstper])+parseFloat(protgst);										
						}
					});
				}
				
				var net_total1 = '';
				var total1 = 0;
				$('input[name="product_id[]"]').each(function(){
					if (this.checked) {
						var pId = this.value;						
						net_total1 = $("#nettot_"+pId).val();
						total1 = parseFloat(total1) + parseFloat(net_total1);
					}
				});	
				
				$('#netTotal').html(total1.toFixed(2));
				
				//var freightCharges = response.freight_charges;						
				var freightCharges1 = $("#freightchargesInput").val();	
				
				var gsttot = 0.00;
				if(currency == 'INR'){
					var htm2 = '';
					var perProFrch = 0;
					$.each(gstArr , function(index, val) {
						
						perProFrch = (parseFloat(freightCharges1) / parseFloat(total1)) * parseFloat(val);						
						val = parseFloat(perProFrch) + parseFloat(val);
						
						htm2 += "<tr>";
						//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
						htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
						htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
						htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
						htm2 += "</tr>";
						
					gsttot = parseFloat(gsttot) + parseFloat(val);
					
					});								
					$('#gstcalculation').html(htm2);
				}
				
				var grand_total1 = parseFloat(total1) + parseFloat(freightCharges1) + parseFloat(gsttot);						
				$('#freight_charges').html(freightCharges1);
				$('#freightchargesInput').val(freightCharges1);
				$('#grand_total').html(grand_total1.toFixed(2)); */
				
				
				var chkbox = '';
				$(".ordpro").each(function(){
					chkbox = $(this).find('input[type="checkbox"]');
					if(chkbox.prop("checked")==true){
						var checkbox_id = chkbox.val();						
						if(checkbox_id == product_id){
							var pro_des = $(this).find("td:eq(1)").html();
							var pro_qty = $(this).find("td:eq(4)").html();
							$("#order_pro_qty").val(pro_qty);
							$("#batchListProId").val(product_id);
							$("#pro_des").html(pro_des);
							$("#pro_qty").html(pro_qty);
						}
					}
				});			
				
				$.ajax({
					url:'<?php echo site_url('getBatchList');?>',
					method: 'post',					
					data: {product_id: product_id, store_id: store_id},
					dataType: 'json',
					success: function(response){						
						var htm = "";
							htm += "<input type='hidden' name='product_id' id='batchProductId' value='"+product_id+"'>";
							htm += "<input type='hidden' name='order_id' value='"+order_id+"'>";
						
						$.each(response, function(i,res) {
							
							var out_qty = res.out_qty;
							if(out_qty == 'NaN' || out_qty == null){
								out_qty = 0;
							}
							var return_qty = res.return_qty;
							if(return_qty == 'NaN' || return_qty == null){
								return_qty = 0;
							}
							var stock_qty = res.stock_qty;
							if(stock_qty == 'NaN' || stock_qty == null){
								stock_qty = 0;
							}
							
							var avalQty = 0;
							 avalQty = parseInt(stock_qty) - parseInt(out_qty) + parseInt(return_qty);
							if(avalQty <= 0){
								 return true;
							}
							
							
																				
							htm += "<tr style='background-color:"+res.color+"'>";														
							htm += "<td><input type='checkbox' name='batch_id[]' value='"+res.batch_id+"'>&nbsp;&nbsp;"+res.batch_no+"</td>";
							htm += "<td><input type='hidden' name='store_id' value="+res.store_id+">"+res.store_name+"</td>";
							htm += "<td>"+res.exp_date+"</td>";
							htm += "<td>"+avalQty+"</td>";
							htm += "<td><input type='text' class='' name='qty["+res.batch_id+"]' style='width:70px;'></td>";
							htm += "</tr>";
						});						
						$('#batchlist').html(htm);
					}
				});	

				$("#myModal").modal();
			} else if(batch_select == 'auto'){
				$("#addBatchList").attr("disabled", false);
				
				$(".prtr").each(function(){
					$("#protbl").find("[data-val='"+ product_id +"']").remove();					
				});
							
					$.ajax({
						url:'<?php echo site_url('getProductBatch');?>',
						method: 'post',					
						data: {product_id: product_id, order_id: order_id, store_id: store_id},
						dataType: 'json',
						success: function(response){
							if(!(response.batch_error)){
								var htm = "";
								if(response.list == undefined){
									alert("No Batch Available for this product.");
									return false;
								}
								$.each(response.list, function(i,res) {
									
									htm += "<tr class='prtr' data-val='"+ product_id +"'>"; 
									
									htm += "<input type='hidden' name='productid[]' value='"+res.product_id+"'>";
									htm += "<input type='hidden' name='batch_id[]' value='"+res.batch_id+"'>";
									htm += "<input type='hidden' name='qty[]' value='"+res.qty+"'>";
									htm += "<input type='hidden' name='rate[]' value='"+res.rate+"'>";
									htm += "<input type='hidden' name='discount[]' value='"+res.discount+"'>";
									htm += "<input type='hidden' name='net_total[]' value='"+res.net_total+"'>";
									if((currency == 'INR') && (country_id == '99')){
										htm += "<input type='hidden' name='gstRate[]' value='"+res.gst_rate+"'>";
									}									
									htm += "<td><b>"+res.model_name+"</b> | "+res.description+"</td>";
									htm += "<td>"+res.hsn+"</td>";
									htm += "<td>"+res.pack_unit+"</td>";
									htm += "<td>"+res.qty+"</td>";
									htm += "<td>"+res.rate+"</td>";
									htm += "<td>"+res.batch_no+"</td>";
									htm += "<td>"+res.mfg_date+"/"+res.exp_date+"</td>";
									htm += "<td>"+res.discount+"</td>";
									htm += "<td align='right'>"+res.net_total+"</td>";
									htm += "</tr>";
								});
								
								$('#productBatch').append(htm);
								
								//if(currency == 'INR'){
								if((currency == 'INR') && (country_id == '99')){
									var gstArr = {};
									$('input[name="product_id[]"]').each(function(){
										if (this.checked) {
											var pId = this.value;
											var gstper = $("#gstper_"+pId).val();
											var protgst = $("#totalgst_"+pId).val();										
											if(gstArr[gstper]==null){
												gstArr[gstper]=0.00;
											}										
											gstArr[gstper]=parseFloat(gstArr[gstper])+parseFloat(protgst);										
										}
									});
								}
								
								var net_total = '';
								var total = 0;
								$('input[name="product_id[]"]').each(function(){
									if (this.checked) {
										var pId = this.value;
										net_total = $("#nettot_"+pId).val();
										total = parseFloat(total) + parseFloat(net_total);
									}
								});
								
								//var freightCharges = response.freight_charges;	
								var freightCharges = $('#freightchargesInput').val();	
								var freight_gst = response.freight_gst;
								var gsttot = 0.00;
								//if(currency == 'INR'){
								if((currency == 'INR') && (country_id == '99')){
									var htm2 = '';
									var perProFrch = 0;
									var gstFlag = 0;
									$.each(gstArr , function(index, val) {
										//perProFrch = (parseFloat(freightCharges) / parseFloat(total)) * parseFloat(val);						
										//val = parseFloat(perProFrch) + parseFloat(val);
										if(isNaN(val)) {
                                            val = 0.00;
                                        }
                                        
                                        if(freight_gst == index){
										    gstFlag = 1;
										    var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
										    val = val + gtval;
										}
                                        
										htm2 += "<tr>";
										//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
										htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
										htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
										htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
										htm2 += "</tr>";
										
										
										gsttot = parseFloat(gsttot) + parseFloat(val);
									});	
									
									if(freight_gst > 0 && gstFlag == 0){
									    var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
									    htm2 += "<tr>";
										//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
										htm2 += "<input type='hidden' name='gst_total_amount["+freight_gst+"]' value="+parseFloat(gtval).toFixed(2)+">";
										htm2 += "<td colspan='8' align='right'>GST @ "+freight_gst+"%</td>";
										htm2 += "<td align='right' id='gst_"+freight_gst+"'>"+parseFloat(gtval).toFixed(2)+"</td>";
										htm2 += "</tr>";
										
										gsttot = parseFloat(gsttot) + parseFloat(gtval);
									}
									
									$('#gstcalculation').html(htm2);
								}
								
								$('#netTotal').html(total.toFixed(2));
								
								var grand_total = parseFloat(total) + parseFloat(freightCharges) + parseFloat(gsttot);
								if(isNaN(grand_total)) {
                                        grand_total = 0.00;
                                    }
								$('#freight_charges').html(freightCharges);
								$('#freightchargesInput').val(freightCharges);
								$('#grand_total').html(grand_total.toFixed(2));	
							} else {
								alert(response.batch_error);
							}	
													
						}
					});
			}
		});
		
		//Show Expiry List
		$('#addExpiryBatchList').click(function() {
			$("#addExpiryBatchList").attr("disabled", true);
			var store_id = $('input[name=store_id]:checked').val();	
			var product_id = $("#batchListProId").val();
			var order_id = $("#order_id").val();
						
			$.ajax({
				url:'<?php echo site_url();?>'+'/challan/getAllBatchListWithExpiry',
				method: 'post',					
				data: {product_id: product_id, store_id: store_id},
				dataType: 'json',
				success: function(response){						
					var htm = "";
						//htm += "<input type='hidden' name='product_id' id='batchProductId' value='"+product_id+"'>";
						//htm += "<input type='hidden' name='order_id' value='"+order_id+"'>";
					
					$.each(response, function(i,res) {
						
						var out_qty = res.out_qty;
						if(out_qty == 'NaN' || out_qty == null){
							out_qty = 0;
						}
						var return_qty = res.return_qty;
						if(return_qty == 'NaN' || return_qty == null){
							return_qty = 0;
						}
						var stock_qty = res.stock_qty;
						if(stock_qty == 'NaN' || stock_qty == null){
							stock_qty = 0;
						}
						
						var avalQty = 0;
						avalQty = parseInt(stock_qty) - parseInt(out_qty) + parseInt(return_qty);
						if(avalQty <= 0){
							 return true;
						}
						
						htm += "<tr style='background-color:"+res.color+"'>";														
						htm += "<td><input type='checkbox' name='batch_id[]' value='"+res.batch_id+"'>&nbsp;&nbsp;"+res.batch_no+"</td>";
						htm += "<td><input type='hidden' name='store_id' value="+res.store_id+">"+res.store_name+"</td>";
						htm += "<td><input type='hidden' name='expVal' value='1'>"+res.exp_date+"</td>";
						htm += "<td>"+avalQty+"</td>";
						htm += "<td><input type='text' class='' name='qty["+res.batch_id+"]' style='width:70px;'></td>";
						htm += "</tr>";
					});						
					$('#batchlist').append(htm);
				}
			});	
		});		
		
		
		$('#addBatchList').click(function() {
			$("#addBatchList").attr("disabled", true);	
			var country_id = '<?php echo $customerInfo->countryId; ?>';
			var currency = '<?php echo $orderInfo->currency; ?>';
			var data_form = $('#batchlistform').serialize();			
			$.ajax({
				url:'<?php echo site_url('getProductBatchManul');?>',
				method: 'post',					
				data: data_form,
				dataType: 'json',
				success: function(response){
					
					if(response.error){
						$("#addBatchList").attr("disabled", false);
						var mess = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
						$("#alert-danger").html(mess);						
					} else {						
						$("#addBatchList").attr("disabled", true);				
						var htm = "";
						$.each(response.list, function(i,res) {
							$("#pro_"+res.product_id).prop('checked', true);
							
							htm += "<tr class='prtr' data-val='"+ res.product_id +"'>"; 							
							htm += "<input type='hidden' name='productid[]' value='"+res.product_id+"'>";
							htm += "<input type='hidden' name='batch_id[]' value='"+res.batch_id+"'>";
							htm += "<input type='hidden' name='qty[]' value='"+res.qty+"'>";
							htm += "<input type='hidden' name='rate[]' value='"+res.rate+"'>";
							htm += "<input type='hidden' name='discount[]' value='"+res.discount+"'>";
							htm += "<input type='hidden' name='net_total[]' value='"+res.net_total+"'>";
							//if(currency == 'INR'){
							if((currency == 'INR') && (country_id == '99')){
								htm += "<input type='hidden' name='gstRate[]' value='"+res.gst_rate+"'>";
							}							
							htm += "<td><b>"+res.model_name+"</b> | "+res.description+"</td>";
							htm += "<td>"+res.hsn+"</td>";
							htm += "<td>"+res.pack_unit+"</td>";
							htm += "<td>"+res.qty+"</td>";
							htm += "<td>"+res.rate+"</td>";
							htm += "<td>"+res.batch_no+"</td>";
							htm += "<td>"+res.mfg_date+"/"+res.exp_date+"</td>";
							htm += "<td>"+res.discount+"</td>";
							htm += "<td align='right'>"+res.net_total+"</td>";
							htm += "</tr>";
						});
						
						$('#productBatch').append(htm);
						
						var net_total = 0;						
						var total = 0;
						var gstTotAmount = 0;
						var gstArr = {};
						$(".prtr").each(function(){
							var pro_id = $(this).find('input[name="productid[]"]').val();							
							var gstRate = $(this).find('input[name="gstRate[]"]').val();							
							net_total = $(this).find("td:last").html();
							
							if(gstArr[gstRate]==null){
								gstArr[gstRate]=0.00;
							}							
							//if(currency == 'INR'){
							if((currency == 'INR') && (country_id == '99')){
								var gstAmount= (net_total*gstRate)/100;								
								gstArr[gstRate] = parseFloat(gstArr[gstRate]) + parseFloat(gstAmount);
							}							
							total = parseFloat(total) + parseFloat(net_total);
						});
											
						//var freightCharges = response.freight_charges;
						var freightCharges = $('#freightchargesInput').val();
						var freight_gst = response.freight_gst;
						$('#netTotal').html(total.toFixed(2));
						
						$('#gstcalculation').html('');
						
						var gsttot = 0.00;
						//if(currency == 'INR'){
						if((currency == 'INR') && (country_id == '99')){
							var htm2 = '';
							var perProFrch = 0;	
							var gstFlag = 0;
							$.each(gstArr , function(index, val) {
								//perProFrch = (parseFloat(freightCharges) / parseFloat(total)) * parseFloat(val);						
								//val = parseFloat(perProFrch) + parseFloat(val);
								if(isNaN(val)) {
                                        val = 0.00;
                                    }
                                
                                if(freight_gst == index){
                                	gstFlag = 1;
                                	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                                	val = val + gtval;
                                } 
                                    
								htm2 += "<tr>";
								//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
								htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
								htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
								htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
								htm2 += "</tr>";
								
							    gsttot = parseFloat(gsttot) + parseFloat(val);
							});
							
							if(freight_gst > 0 && gstFlag == 0){
                            	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                            	htm2 += "<tr>";
                            	//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
                            	htm2 += "<input type='hidden' name='gst_total_amount["+freight_gst+"]' value="+parseFloat(gtval).toFixed(2)+">";
                            	htm2 += "<td colspan='8' align='right'>GST @ "+freight_gst+"%</td>";
                            	htm2 += "<td align='right' id='gst_"+freight_gst+"'>"+parseFloat(gtval).toFixed(2)+"</td>";
                            	htm2 += "</tr>";
                            	
                            	gsttot = parseFloat(gsttot) + parseFloat(gtval);
                            }
							
							$('#gstcalculation').html(htm2);
						}
						
						var grand_total = parseFloat(total) + parseFloat(freightCharges) + parseFloat(gsttot);
						if(isNaN(grand_total)) {
                                grand_total = 0.00;
                            }
						$('#freight_charges').html(freightCharges);
						$('#freightchargesInput').val(freightCharges);
						$('#grand_total').html(grand_total.toFixed(2));
						
						var mess = '<div class="alert alert-success" role="alert">Successfully Added Batch Product.</div>';
						$("#alert-danger").html(mess);					
						
						setTimeout(function(){
							$("#myModal .close").click();
							$("#alert-danger").html('');
						}, 1000);
						
					}
				}
			});	
		});		
		// End Get product Batch

		$('#freightchargesInput').keyup(function() {
			var currency = '<?php echo $orderInfo->currency; ?>';
			var country_id = '<?php echo $customerInfo->countryId; ?>';
			var freightCharges = this.value;
			$('#freight_charges').html(freightCharges);			
			
			var net_total = 0;						
			var total = 0;
			var gstTotAmount = 0;
			var gstArr = {};
			$(".prtr").each(function(){
				var pro_id = $(this).find('input[name="productid[]"]').val();							
				var gstRate = $(this).find('input[name="gstRate[]"]').val();							
				net_total = $(this).find("td:last").html();
				
				if(gstArr[gstRate]==null){
					gstArr[gstRate]=0.00;
				}							
				//if(currency == 'INR'){
				if((currency == 'INR') && (country_id == '99')){
					var gstAmount= (net_total*gstRate)/100;								
					gstArr[gstRate] = parseFloat(gstArr[gstRate]) + parseFloat(gstAmount);
				}							
				total = parseFloat(total) + parseFloat(net_total);
			});
			
			var freight_gst = '<?php echo $this->config->item('PER_FREIGHT_GST'); ?>';
			
			var gsttot = 0.00;
			//if(currency == 'INR'){
			if((currency == 'INR') && (country_id == '99')){
				var htm2 = '';
				var perProFrch = 0;
				var gstFlag = 0;
				$.each(gstArr , function(index, val) {					
					//perProFrch = (parseFloat(freightCharges) / parseFloat(total)) * parseFloat(val);					
					//val = parseFloat(perProFrch) + parseFloat(val);
					if(isNaN(val)) {
                            val = 0.00;
                        }
                        
                    if(freight_gst == index){
                    	gstFlag = 1;
                    	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                    	val = val + gtval;
                    } 
                        
					htm2 += "<tr>";
					//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
					htm2 += "<input type='hidden' name='gst_total_amount["+index+"]' value="+parseFloat(val).toFixed(2)+">";
					htm2 += "<td colspan='8' align='right'>GST @ "+index+"%</td>";
					htm2 += "<td align='right' id='gst_"+index+"'>"+parseFloat(val).toFixed(2)+"</td>";
					htm2 += "</tr>";
					
					gsttot = parseFloat(gsttot) + parseFloat(val);
				});	
				
				if(freight_gst > 0 && gstFlag == 0){
                	var gtval = (parseFloat(freightCharges) * parseFloat(freight_gst)) / 100;
                	htm2 += "<tr>";
                	//htm2 += "<input type='hidden' name='gst_rate[]' value="+index+">";
                	htm2 += "<input type='hidden' name='gst_total_amount["+freight_gst+"]' value="+parseFloat(gtval).toFixed(2)+">";
                	htm2 += "<td colspan='8' align='right'>GST @ "+freight_gst+"%</td>";
                	htm2 += "<td align='right' id='gst_"+freight_gst+"'>"+parseFloat(gtval).toFixed(2)+"</td>";
                	htm2 += "</tr>";
                	
                	gsttot = parseFloat(gsttot) + parseFloat(gtval);
                }
				
				$('#gstcalculation').html(htm2);
			}
			
			var grand_total = parseFloat(total) + parseFloat(freightCharges) + parseFloat(gsttot);
			if(isNaN(grand_total)) {
                    grand_total = 0.00;
                }
			$('#grand_total').html(grand_total.toFixed(2));			
		});
		
		
		
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

		/* $("#close").on("click", function () {
			var batchProductId = $("#batchProductId").val();
			$("#pro_"+batchProductId).prop('checked', false);
		}); */
		
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
		
		
		$('#sli_id').on('change', function() {
			var value = $(this).val();
			if(value == 'addCarrier'){
				$("#myModalCarriers").modal();
			}
		});
		
		$("#addCarrier").click(function(){		
			if(! $("#addnewCarrier").valid()) return false;			
			var name = $("#sli_name").val();			
			var sli_account_number = $("#sli_account_number").val();			
			var dataString = 'sli_name='+ name + '&sli_account_number=' + sli_account_number; 
			$.ajax({
				url:'<?php echo site_url('customer/addCarrier'); ?>',
				method: 'post',
				data: dataString,
				dataType: 'json',
				success: function(response){
					$("#alert-danger12").html('');
					if(response.error){
						var html = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
						$("#alert-danger12").html(html);
					} else {
						var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
						$("#alert-danger12").html(htm);
						
						var html = '<option value="'+ response.sli_id +'" selected>'+ response.sli_name +'</option>';					
						$("#sli_id option").eq(-2).after(html);						
						
						setTimeout(function(){
							$("#myModalCarriers .close").click();
							$("#sli_name").val('');
							$("#alert-danger12").html('');
						}, 3000);
						
					}
				}
			});
		});
		
	});
	
	function formatDate(date) {
		 var d = new Date(date),
			 month = '' + (d.getMonth() + 1),
			 day = '' + d.getDate(),
			 year = d.getFullYear();

		 if (month.length < 2) month = '0' + month;
		 if (day.length < 2) day = '0' + day;

		 //return [year, month, day].join('/');
		 return [month, year].join('/');
	}

</script>