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
					<a href="<?php echo site_url('addCustomer'); ?>" class="btn btn-primary" id="addCustomer" data-toggle="tooltip" data-placement="top" title="Add Customer"> <i class="fas fa-plus"></i></a>&nbsp;									 					
				</div>
			</div>
		</div>		
	</div>
	<div class="row">
		<?php if (validation_errors()) : ?>
		<div class="col-md-12">		
			<?php if($RefNo->payment_ref_no){ ?>
				<span style="background-color:#f8d7da;padding: .75rem 1.25rem;margin-bottom: 1rem; color: #721c24;float:left;width:100%;border: 1px solid transparent;border-radius: .25rem;">Payment Ref. no <a href="<?php echo site_url()."/editRecord/".$RefNo->record_id; ?>"><?php echo $RefNo->payment_ref_no; ?></a> already exist in database.</span>
			<?php } else { ?>
				<div class="alert alert-danger" role="alert">
					<?php echo validation_errors(); ?>
				</div>
			<?php } ?>		
		</div>
		<?php elseif (!empty($errorMsg)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
					<?php echo $errorMsg; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo $error; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<script>
$(document).ready(function() {						
	$("#customerForm").validate({
		rules: {
			company_name: "required",					
			financial_year: "required",					
			bill_no: "required",					
			bill_date: "required",					
			bill_currency: "required",					
			bill_amount: "required",					
			challan_id: "required",					
			challan_date: "required",					
			payment_bank: "required",					
			payment_ref_no: "required",					
			awb: "required",					
			awb_date: "required",					
			method_of_shipment: "required",					
			boe_sdf: "required",					
			sb: "required",					
			bank_sub_date: "required",					
			bank_sub_date: "required"						
		},
		messages: {
			company_name: "Please Select Customer",			
		}
	})

	$('#submit').click(function() {
		$("#recordsForm").valid();
	});
});
</script>

	<form role="form" class="needs-validation" id="recordsForm" data-toggle="validator" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data">
	<div class="row" style="margin:0px;">
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Record Information</legend>
					<div class="row">							
						<div class="col-sm-6">						  
						  <div class="form-group">
							 <div class="control-label" >Customer Name <span style="color:gray;font-size:14px;">(Search without contact person title)</span></div> 
							 <input type="text" name="customer_name" value="<?php if(isset($recordInfo->customer_id)) { echo $recordInfo->company_name." | ".$recordInfo->person_title." ".$recordInfo->contact_person; } ?>" id="customer_name" class="form-control" autocomplete='off' required>								
						  </div>
						</div>
						
						<input type="hidden" name="record_id" value="<?php if(isset($recordInfo->record_id)) { echo $recordInfo->record_id; } ?>">
						
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Customer Id</div> 
							 <input type="text" name="customer_id" value="<?php if(isset($recordInfo->customer_id)) { echo $recordInfo->customer_id; } ?>" id="customer_id" class="form-control" readonly>								
						  </div>
						</div>
						
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Financial Year</div> 
							<?php
								$financeArr = array("2018-2019", "2017-2018", "2016-2017", "2015-2016", "2014-2015", "2013-2014", "2012-2013", "2011-2012", "2010-2011", "2009-2010");								
							?>
							 <select name="financial_year" id="financial_year" class="form-control" required>
								<option value="">-- Seclect --</option>
								<?php foreach($financeArr as $finance){ ?>
									<option value="<?php echo $finance; ?>" <?php if(isset($recordInfo->financial_year) && $recordInfo->financial_year == $finance ) { echo ' selected="selected"'; } ?> ><?php echo $finance; ?></option>
								<?php } ?>
								
							 </select>
						  </div>	
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Bill No.</div> 
							<input type="text" name="bill_no" value="<?php if(isset($recordInfo->bill_no)) { echo $recordInfo->bill_no; } ?>" id="bill_no" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Bill Date</div> 
							<input type="text" name="bill_date" value="<?php if(isset($recordInfo->bill_date)) { echo dateFormat('Y-m-d',$recordInfo->bill_date); } ?>" id="bill_date" class="form-control date" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Bill Currency</div> 							
							<select name="bill_currency" id="bill_currency" class="form-control" required>
								<option value="">-- Seclect --</option>
								<?php foreach($currencies as $currency){ ?>
									<option value="<?php echo $currency['id']; ?>" <?php if(isset($recordInfo->bill_currency) && $recordInfo->bill_currency == $currency['id'] ) { echo ' selected="selected"'; } ?> ><?php echo $currency['currency']; ?></option>
								<?php } ?>
							 </select>
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Bill Amount</div> 
							<input type="text" name="bill_amount" value="<?php if(isset($recordInfo->bill_amount)) { echo $recordInfo->bill_amount; } ?>" id="bill_amount" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>	
						
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Challan Id</div> 
							<input type="text" name="challan_id" value="<?php if(isset($recordInfo->challan_id)) { echo $recordInfo->challan_id; } ?>" id="challan_id" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Challan Date</div> 
							<input type="text" name="challan_date" value="<?php if(isset($recordInfo->challan_date)) { echo dateFormat('Y-m-d',$recordInfo->challan_date); } ?>" id="challan_date" class="form-control date" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Payment Bank</div> 							
							<select name="payment_bank" id="payment_bank" class="form-control" required>
								<option value="">-- Seclect --</option>
								<?php foreach($banks as $bank){ ?>
									<option value="<?php echo $bank['id']; ?>" <?php if(isset($recordInfo->payment_bank) && $recordInfo->payment_bank == $bank['id'] ) { echo ' selected="selected"'; } ?> ><?php echo $bank['bank_name']; ?></option>
								<?php } ?>
							 </select>
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Payment Ref. No</div> 
							<input type="text" name="payment_ref_no" value="<?php if(isset($recordInfo->payment_ref_no)) { echo $recordInfo->payment_ref_no; } ?>" id="payment_ref_no" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">AWB</div> 
							<input type="text" name="awb" value="<?php if(isset($recordInfo->awb)) { echo $recordInfo->awb; } ?>" id="awb" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>

						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">AWB Date</div> 
							<input type="text" name="awb_date" value="<?php if(isset($recordInfo->awb_date)) { echo dateFormat('Y-m-d',$recordInfo->awb_date); } ?>" id="awb_date" class="form-control date" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Method of Shipment</div> 
							<input type="text" name="method_of_shipment" value="<?php if(isset($recordInfo->method_of_shipment)) { echo $recordInfo->method_of_shipment; } ?>" id="method_of_shipment" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>
						<div class="col-sm-3">
							&nbsp;
						</div>
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">BOE / SDF / SB</div> 
							<input type="text" name="boe_sdf" value="<?php if(isset($recordInfo->boe_sdf)) { echo $recordInfo->boe_sdf; } ?>" id="boe_sdf" class="form-control" autocomplete='off' required>
							
						  </div>
						</div>	
						
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Bank Sub. Date</div> 
							<input type="text" name="bank_sub_date" value="<?php if(isset($recordInfo->bank_sub_date)) { echo dateFormat('Y-m-d',$recordInfo->bank_sub_date); } ?>" id="bank_sub_date" class="form-control date" autocomplete='off' required>
							
						  </div>
						</div>	
						
						<div class="col-sm-12">
						  <div class="form-group">
							<div class="control-label">Note</div> 
								<textarea name="note" id="note" class="form-control" ><?php if(isset($recordInfo->note)) { echo $recordInfo->note; } ?></textarea>
						  </div>
						</div>	
						
						
						<div class="col-sm-12">
							<button type="submit" id="submit" class="btn btn-primary float-right">
							<?php if(isset($recordInfo->record_id)) { ?>
								Update
							<?php } else { ?>
								Save
							<?php } ?>
							</button>	
						</div>
					</div>
			</fieldset>
		</div>
				
	</div>		
	</form>
</div>

<script>
	$(document).ready(function() {
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
		
	   	$('#customer_name').autocomplete({
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
					$('#customer_name').val(item['label']);				
					$('#customer_id').val(item['value']);
				}
			}
		});
		
		
		$("#bill_no").keyup(function(){
			var prefix = "E"
			if(this.value.indexOf(prefix) !== 0 ){
				this.value = prefix + this.value;
			}
		});
		
	});
</script>						